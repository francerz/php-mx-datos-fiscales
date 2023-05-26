<?php

namespace Francerz\MxSatCif;

use JsonSerializable;

/**
 * @property-read string $clave
 * @property-read string $descripcion
 * @property-read int $aplicaAPersona
 */
class RegimenFiscal implements JsonSerializable
{
    public const TIPO_PERSONA_FISICA = 0b01;
    public const TIPO_PERSONA_MORAL = 0b10;

    private $clave;
    private $descripcion;
    private $aplicaAPersona = 0;

    public function __construct(string $clave, string $descripcion, int $aplicaAPersona)
    {
        $this->clave = $clave;
        $this->descripcion = $descripcion;
        $this->aplicaAPersona = $aplicaAPersona;
    }

    public function __get($name)
    {
        switch ($name) {
            case 'clave':
                return $this->clave;
            case 'descripcion':
                return $this->descripcion;
            case 'aplicaAPersona':
                return $this->aplicaAPersona;
        }
    }

    public function getClave()
    {
        return $this->clave;
    }

    public function getDescripcion()
    {
        return $this->descripocion;
    }

    public function getAplicaAPersona()
    {
        return $this->aplicaAPersona;
    }

    public function aplicaA(int $tipoPersona)
    {
        return ($this->aplicaAPersona & $tipoPersona) == $tipoPersona;
    }

    public function aplicaAPersonaFisica()
    {
        return $this->aplicaA(self::TIPO_PERSONA_FISICA);
    }

    public function aplicaAPersonaMoral()
    {
        return $this->aplicaA(self::TIPO_PERSONA_MORAL);
    }

    public function jsonSerialize()
    {
        return [
            'clave' => $this->clave,
            'descripcion' => $this->descripcion
        ];
    }
}
