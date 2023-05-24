<?php

namespace Francerz\MxDatosFiscales;

use DateTimeImmutable;
use JsonSerializable;

/**
 * @property-read string|null $curp
 * @property-read string|null $nombre
 * @property-read string|null $apellidoPaterno
 * @property-read string|null $apellidoMaterno
 * @property-read DateTimeImmutable|null $fechaNacimiento
 * @property-read DateTimeImmutable|null $fechaInicioOperaciones
 * @property-read string|null $situacionContribuyente
 * @property-read DateTimeImmutable|null $fechaUltimoCambioSituacion
 */
class DatosIdentificacion implements JsonSerializable
{
    public const TIPO_PERSONA_FISICA = 'Persona Física';
    public const TIPO_PERSONA_MORAL = 'Persona Moral';

    /** @var string */
    private $tipo;

    /** @var ?string */
    private $curp;

    /** @var ?string */
    private $nombre;

    /** @var ?string */
    private $apellidoPaterno;

    /** @var ?string */
    private $apellidoMaterno;

    /** @var ?DateTimeImmutable */
    private $fechaNacimiento;

    /** @var ?string */
    private $razonSocial;

    /** @var ?string */
    private $regimenCapital;

    /** @var ?DateTimeImmutable */
    private $fechaConstitucion;

    /** @var ?DateTimeImmutable */
    private $fechaInicioOperaciones;

    private $situacionContribuyente;

    /** @var ?DateTimeImmutable */
    private $fechaUltimoCambioSituacion;

    private function __construct()
    {
        // Empty constructor
    }

    public static function createPersonaFisica(
        ?string $curp,
        ?string $nombre,
        ?string $apellidoPaterno,
        ?string $apellidoMaterno,
        ?DateTimeImmutable $fechaNacimiento,
        ?DateTimeImmutable $fechaInicioOperaciones,
        ?string $situacionContribuyente,
        ?DateTimeImmutable $fechaUltimoCambioSituacion
    ) {
        $pf = new static();
        $pf->tipo = self::TIPO_PERSONA_FISICA;
        $pf->curp = $curp;
        $pf->nombre = $nombre;
        $pf->apellidoPaterno = $apellidoPaterno;
        $pf->apellidoMaterno = $apellidoMaterno;
        $pf->fechaNacimiento = $fechaNacimiento;
        $pf->fechaInicioOperaciones = $fechaInicioOperaciones;
        $pf->situacionContribuyente = $situacionContribuyente;
        $pf->fechaUltimoCambioSituacion = $fechaUltimoCambioSituacion;
        return $pf;
    }

    public static function createPersonaMoral(
        ?string $razonSocial,
        ?string $regimenCapital,
        ?DateTimeImmutable $fechaConstitucion,
        ?DateTimeImmutable $fechaInicioOperaciones,
        ?string $situacionContribuyente,
        ?DateTimeImmutable $fechaUltimoCambioSituacion
    ) {
        $pm = new static();
        $pm->tipo = self::TIPO_PERSONA_MORAL;
        $pm->razonSocial = $razonSocial;
        $pm->regimenCapital = $regimenCapital;
        $pm->fechaConstitucion = $fechaConstitucion;
        $pm->fechaInicioOperaciones = $fechaInicioOperaciones;
        $pm->situacionContribuyente = $situacionContribuyente;
        $pm->fechaUltimoCambioSituacion = $fechaUltimoCambioSituacion;
        return $pm;
    }

    public function __get($name)
    {
        switch ($name) {
            case 'tipo':
                return $this->tipo;
            case 'curp':
                return $this->curp;
            case 'nombre':
                return $this->nombre;
            case 'apellidoPaterno':
                return $this->apellidoPaterno;
            case 'apellidoMaterno':
                return $this->apellidoMaterno;
            case 'fechaNacimiento':
                return $this->fechaNacimiento;
            case 'razonSocial':
                return $this->razonSocial;
            case 'regimenCapital':
                return $this->regimenCapital;
            case 'fechaConstitucion':
                return $this->fechaConstitucion;
            case 'fechaInicioOperaciones':
                return $this->fechaInicioOperaciones;
            case 'situacionContribuyente':
                return $this->situacionContribuyente;
            case 'fechaUltimoCambioSituacion':
                return $this->fechaUltimoCambioSituacion;
        }
    }

    public function jsonSerialize()
    {
        if ($this->tipo === self::TIPO_PERSONA_FISICA) {
            return [
                'tipo' => $this->tipo,
                'curp' => $this->curp,
                'nombre' => $this->nombre,
                'apellidoPaterno' => $this->apellidoPaterno,
                'apellidoMaterno' => $this->apellidoMaterno,
                'fechaNacimiento' => $this->fechaNacimiento ? $this->fechaNacimiento->format('Y-m-d') : null,
                'fechaInicioOperaciones' => $this->fechaInicioOperaciones ? $this->fechaInicioOperaciones->format('Y-m-d') : null,
                'situacionContribuyente' => $this->situacionContribuyente,
                'fechaUltimoCambioSituacion' => $this->fechaUltimoCambioSituacion ? $this->fechaUltimoCambioSituacion->format('Y-m-d') : null
            ];
        }

        if ($this->tipo === self::TIPO_PERSONA_MORAL) {
            return [
                'tipo' => $this->tipo,
                'razonSocial' => $this->razonSocial,
                'regimenCapital' => $this->regimenCapital,
                'fechaConstitucion' => $this->fechaConstitucion ? $this->fechaConstitucion->format('Y-m-d') : null,
                'fechaInicioOperaciones' => $this->fechaInicioOperaciones ? $this->fechaInicioOperaciones->format('Y-m-d') : null,
                'situacionContribuyente' => $this->situacionContribuyente,
                'fechaUltimoCambioSituacion' => $this->fechaUltimoCambioSituacion ? $this->fechaUltimoCambioSituacion->format('Y-m-d') : null
            ];
        }

        return [];
    }
}
