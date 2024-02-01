<?php

namespace Francerz\MxSatCif\Tests;

use PHPUnit\Framework\TestCase;
use Francerz\MxSatCif\CatalogoRegimenes;

class CatalogoRegimenesTest extends TestCase
{
    public function testFind()
    {
        $catalogo = CatalogoRegimenes::getInstance();
        $regimen = $catalogo->find('Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas.');
        $this->assertEquals('625', $regimen->getClave());
    }
}
