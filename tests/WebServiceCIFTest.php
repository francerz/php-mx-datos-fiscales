<?php

namespace Francerz\MxSatCif\Tests;

use DateTimeImmutable;
use Francerz\Http\Client;
use Francerz\Http\HttpFactory;
use Francerz\MxSatCif\CatalogoRegimenes;
use Francerz\MxSatCif\DatosIdentificacion;
use Francerz\MxSatCif\WebServiceCIF;
use PHPUnit\Framework\TestCase;

class WebServiceCIFTest extends TestCase
{
    public function testFetch()
    {
        $wsCif = new WebServiceCIF(new Client(), new HttpFactory());

        $cif = $wsCif->fetch('17100119978', 'GUTV910823NL7');
        $this->assertEquals('17100119978', $cif->idCif);
        $this->assertEquals('GUTV910823NL7', $cif->rfc);
        $this->assertEquals('GUTV910823MDFZRR08', $cif->identificacion->curp);
        $this->assertEquals('VIRIDIANA', $cif->identificacion->nombre);
        $this->assertEquals('GUZMAN', $cif->identificacion->apellidoPaterno);
        $this->assertEquals('TORRES', $cif->identificacion->apellidoMaterno);
        $this->assertEquals(new DateTimeImmutable('1991-08-23'), $cif->identificacion->fechaNacimiento);
        $this->assertEquals(new DateTimeImmutable('2015-03-25'), $cif->identificacion->fechaInicioOperaciones);
        $this->assertEquals(DatosIdentificacion::SITUACION_ACTIVO, $cif->identificacion->situacionContribuyente);
        $this->assertEquals(new DateTimeImmutable('2015-03-25'), $cif->identificacion->fechaUltimoCambioSituacion);
        // echo json_encode($cif) . "\n\n";

        $cif = $wsCif->fetch('14040487365', 'NPL120913CL3');
        $this->assertEquals('14040487365', $cif->idCif);
        $this->assertEquals('NPL120913CL3', $cif->rfc);
        $this->assertEquals('NIÑOS PLENOS', $cif->identificacion->denominacion);
        $this->assertEquals('NIÑOS PLENOS', $cif->identificacion->razonSocial);
        $this->assertEquals('AC', $cif->identificacion->regimenCapital);
        $this->assertEquals(new DateTimeImmutable('2012-09-13'), $cif->identificacion->fechaConstitucion);
        $this->assertEquals(new DateTimeImmutable('2012-09-13'), $cif->identificacion->fechaInicioOperaciones);
        $this->assertEquals(DatosIdentificacion::SITUACION_ACTIVO, $cif->identificacion->situacionContribuyente);
        $this->assertEquals(new DateTimeImmutable('2012-09-21'), $cif->identificacion->fechaUltimoCambioSituacion);
        // echo json_encode($cif);
    }
}
