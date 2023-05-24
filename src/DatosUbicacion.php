<?php

namespace Francerz\MxDatosFiscales;

use JsonSerializable;

/**
 * @property-read string $entidadFederativa
 * @property-read string $municipio
 * @property-read string $colonia
 * @property-read string $tipoVialidad
 * @property-read string $nombreVialidad
 * @property-read string $numeroExterior
 * @property-read string $numeroInterior
 * @property-read string $codigoPostal
 * @property-read string $correoElectronico
 */
class DatosUbicacion implements JsonSerializable
{
    /** @var ?string */
    private $entidadFederativa;

    /** @var ?string */
    private $municipio;

    /** @var ?string */
    private $colonia;

    /** @var ?string */
    private $tipoVialidad;

    /** @var ?string */
    private $nombreVialidad;

    /** @var ?string */
    private $numeroExterior;

    /** @var ?string */
    private $numeroInterior;

    /** @var ?string */
    private $codigoPostal;

    /** @var ?string */
    private $correoElectronico;

    public function __construct(
        ?string $entidadFederativa,
        ?string $municipio,
        ?string $colonia,
        ?string $tipoVialidad,
        ?string $nombreVialidad,
        ?string $numeroExterior,
        ?string $numeroInterior,
        ?string $codigoPostal,
        ?string $correoElectronico
    ) {
        $this->entidadFederativa = $entidadFederativa;
        $this->municipio = $municipio;
        $this->colonia = $colonia;
        $this->tipoVialidad = $tipoVialidad;
        $this->nombreVialidad = $nombreVialidad;
        $this->numeroExterior = $numeroExterior;
        $this->numeroInterior = $numeroInterior;
        $this->codigoPostal = $codigoPostal;
        $this->correoElectronico = $correoElectronico;
    }

    public function __get($name)
    {
        switch ($name) {
            case 'entidadFederativa':
                return $this->entidadFederativa;
            case 'municipio':
                return $this->municipio;
            case 'colonia':
                return $this->colonia;
            case 'tipoVialidad':
                return $this->tipoVialidad;
            case 'nombreVialidad':
                return $this->nombreVialidad;
            case 'numeroExterior':
                return $this->numeroExterior;
            case 'numeroInterior':
                return $this->numeroInterior;
            case 'codigoPostal':
                return $this->codigoPostal;
            case 'correoElectronico':
                return $this->correoElectronico;
        }
    }

    public function jsonSerialize()
    {
        return [
            'entidadFederativa' => $this->entidadFederativa,
            'municipio' => $this->municipio,
            'colonia' => $this->colonia,
            'tipoVialidad' => $this->tipoVialidad,
            'nombreVialidad' => $this->nombreVialidad,
            'numeroExterior' => $this->numeroExterior,
            'numeroInterior' => $this->numeroInterior,
            'codigoPostal' => $this->codigoPostal,
            'correoElectronico' => $this->correoElectronico
        ];
    }
}
