<?php

namespace Francerz\MxDatosFiscales;

use DateTimeImmutable;
use JsonSerializable;

/**
 * @property-read string $regimen
 * @property-read DateTimeImmutable $fechaAlta
 */
class CaracteristicaFiscal implements JsonSerializable
{
    /** @var string */
    public $regimen;
    /** @var DateTimeImmutable */
    public $fechaAlta;

    public function __construct(string $regimen, DateTimeImmutable $fechaAlta)
    {
        $this->regimen = $regimen;
        $this->fechaAlta = $fechaAlta;
    }

    public function __get($name)
    {
        switch ($name) {
            case 'regimen':
                return $this->regimen;
            case 'fechaAlta':
                return $this->fechaAlta;
        }
    }

    public function jsonSerialize()
    {
        return [
            'regimen' => $this->regimen,
            'fechaAlta' => $this->fechaAlta ? $this->fechaAlta->format('Y-m-d') : null
        ];
    }
}
