<?php

namespace Francerz\MxSatCif;

use DateTimeImmutable;
use JsonSerializable;

/**
 * @property-read RegimenFiscal $regimen
 * @property-read DateTimeImmutable $fechaAlta
 */
class CaracteristicaFiscal implements JsonSerializable
{
    /** @var RegimenFiscal */
    public $regimen;
    /** @var DateTimeImmutable */
    public $fechaAlta;

    public function __construct(RegimenFiscal $regimen, DateTimeImmutable $fechaAlta)
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
