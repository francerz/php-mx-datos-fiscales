<?php

namespace Francerz\MxDatosFiscales;

use JsonSerializable;

/**
 * @property-read string $idCif
 * @property-read string $rfc
 * @property-read DatosIdentificacion $identificacion
 * @property-read DatosUbicacion $ubicacion
 * @property-read CaracteristicaFiscal[] $caracteristicas;
 */
class CedulaIdentificacionFiscal implements JsonSerializable
{
    private $idCif;
    private $rfc;
    private $identificacion;
    private $ubicacion;
    private $caracteristicas;

    /**
     * @param string $idCif
     * @param string $rfc
     * @param DatosIdentificacion $identificacion
     * @param DatosUbicacion $ubicacion
     * @param CaracteristicaFiscal[] $caracteristicas
     */
    public function __construct(
        string $idCif,
        string $rfc,
        DatosIdentificacion $identificacion,
        DatosUbicacion $ubicacion,
        array $caracteristicas = []
    ) {
        $this->idCif = $idCif;
        $this->rfc = $rfc;
        $this->identificacion = $identificacion;
        $this->ubicacion = $ubicacion;
        $this->caracteristicas = $caracteristicas;
    }

    public function __get($name)
    {
        switch ($name) {
            case 'idCIF':
            case 'idCif':
                return $this->idCif;
            case 'rfc':
                return $this->rfc;
            case 'identificacion':
                return $this->identificacion;
            case 'ubicacion':
                return $this->ubicacion;
            case 'caracteristicas':
                return $this->caracteristicas;
        }
    }

    public function jsonSerialize()
    {
        return [
            'idCif'             => $this->idCif,
            'rfc'               => $this->rfc,
            'identificacion'    => $this->identificacion,
            'ubicacion'         => $this->ubicacion,
            'caracteristicas'   => $this->caracteristicas
        ];
    }
}
