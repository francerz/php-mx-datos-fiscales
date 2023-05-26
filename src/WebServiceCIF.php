<?php

namespace Francerz\MxSatCif;

use DateTimeImmutable;
use DOMDocument;
use DOMXPath;
use Fig\Http\Message\RequestMethodInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use RuntimeException;

class WebServiceCIF
{
    public const URL_PATTERN = 'https://siat.sat.gob.mx/app/qr/faces/pages/mobile/validadorqr.jsf?D1=10&D2=1&D3={idCIF}_{rfc}';

    public const XPATH_TD_AT_I_PATTERN = '(//tbody[@id]/tr/td)[{i}]';

    public const PATTERN_RFC_PF = '/[A-Z]{4}\d{6}[A-Z0-9]{3}/';
    public const PATTERN_RFC_PM = '/[A-Z]{3}\d{6}[A-Z0-9]{3}/';

    private $httpClient;
    private $requestFactory;

    public function __construct(ClientInterface $httpClient, RequestFactoryInterface $requestFactory)
    {
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
    }

    public function fetch(string $idCif, string $rfc)
    {
        $url = strtr(self::URL_PATTERN, ['{idCIF}' => $idCif, '{rfc}' => $rfc]);
        $request = $this->requestFactory->createRequest(RequestMethodInterface::METHOD_GET, $url);
        $response = $this->httpClient->sendRequest($request);
        return static::parse($idCif, $rfc, (string)$response->getBody());
    }

    private static function parse(string $idCif, string $rfc, $responseString)
    {
        $responseString = substr($responseString, strpos($responseString, '<!DOCTYPE html'));
        $domDoc = new DOMDocument('1.0', 'Latin-1');
        if (!$domDoc->loadHTML($responseString)) {
            throw new RuntimeException('Invalid DOM Document');
        }
        $domXPath = new DOMXPath($domDoc);

        if (preg_match(self::PATTERN_RFC_PF, $rfc)) {
            return new CedulaIdentificacionFiscal(
                $idCif,
                $rfc,
                static::getPersonaFisica($domXPath, 2),
                static::getDatosUbicacion($domXPath, 19),
                static::getCaracteristicasFiscales($domXPath, 40)
            );
        }
        if (preg_match(self::PATTERN_RFC_PM, $rfc)) {
            return new CedulaIdentificacionFiscal(
                $idCif,
                $rfc,
                static::getPersonaMoral($domXPath, 2),
                static::getDatosUbicacion($domXPath, 15),
                static::getCaracteristicasFiscales($domXPath, 36)
            );
        }
        return null;
    }

    private static function toDateTimeImmutable(string $datetime)
    {
        return new DateTimeImmutable($datetime);
    }

    private static function getTdText(DOMXPath $domXPath, int $number)
    {
        $path = strtr(self::XPATH_TD_AT_I_PATTERN, ['{i}' => $number]);
        $nodeList = $domXPath->query($path);
        $domNode = $nodeList->item(0);
        if (is_null($domNode)) {
            return null;
        }
        return utf8_decode($domNode->textContent);
    }

    private static function getPersonaFisica(DOMXPath $domXPath, int $offset = 2)
    {
        return DatosIdentificacion::createPersonaFisica(
            static::getTdText($domXPath, $offset),
            static::getTdText($domXPath, $offset + 2),
            static::getTdText($domXPath, $offset + 4),
            static::getTdText($domXPath, $offset + 6),
            static::toDateTimeImmutable(static::getTdText($domXPath, $offset + 8)),
            static::toDateTimeImmutable(static::getTdText($domXPath, $offset + 10)),
            static::getTdText($domXPath, $offset + 12),
            static::toDateTimeImmutable(static::getTdText($domXPath, $offset + 14))
        );
    }

    private static function getPersonaMoral(DOMXPath $domXPath, int $offset)
    {
        return DatosIdentificacion::createPersonaMoral(
            static::getTdText($domXPath, $offset),
            static::getTdText($domXPath, $offset + 2),
            static::toDateTimeImmutable(static::getTdText($domXPath, $offset + 4)),
            static::toDateTimeImmutable(static::getTdText($domXPath, $offset + 6)),
            static::getTdText($domXPath, $offset + 8),
            static::toDateTimeImmutable(static::getTdText($domXPath, $offset + 10))
        );
    }

    private static function getDatosUbicacion(DOMXPath $domXPath, int $offset)
    {
        $ubicacion = new DatosUbicacion(
            static::getTdText($domXPath, $offset),
            static::getTdText($domXPath, $offset + 2),
            static::getTdText($domXPath, $offset + 4),
            static::getTdText($domXPath, $offset + 6),
            static::getTdText($domXPath, $offset + 8),
            static::getTdText($domXPath, $offset + 10),
            static::getTdText($domXPath, $offset + 12),
            static::getTdText($domXPath, $offset + 14),
            static::getTdText($domXPath, $offset + 16)
        );
        return $ubicacion;
    }

    private static function getCaracteristicaFiscal(DOMXPath $domXPath, int $i, int $offset)
    {
        $regimen = static::getTdText($domXPath, $i * 4 + $offset);
        if (is_null($regimen)) {
            return null;
        }
        $regimenes = CatalogoRegimenes::getInstance();
        $regimen = $regimenes->find($regimen);
        $fechaAlta = static::toDateTimeImmutable(static::getTdText($domXPath, $i * 4 + $offset + 2));
        return new CaracteristicaFiscal($regimen, $fechaAlta);
    }

    /**
     * @param DOMXPath $domXPath
     * @return CaracteristicaFiscal[]
     */
    private static function getCaracteristicasFiscales(DOMXPath $domXPath, int $offset)
    {
        $i = 0;
        $caracteristicas = [];
        do {
            $caracteristica = static::getCaracteristicaFiscal($domXPath, $i++, $offset);
            if (is_null($caracteristica)) {
                break;
            }
            $caracteristicas[] = $caracteristica;
        } while (true);
        return $caracteristicas;
    }
}
