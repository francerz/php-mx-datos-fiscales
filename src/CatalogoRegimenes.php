<?php

namespace Francerz\MxSatCif;

final class CatalogoRegimenes
{
    /** @var static|null */
    private static $instance;

    /** @var RegimenFiscal[] */
    private $regimenes;

    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    private function __construct()
    {
        $this->regimenes = array_column($this->loadRegimenes(), null, 'clave');
    }

    private function loadRegimenes()
    {
        return [
            new RegimenFiscal('601', 'General de Ley Personas Morales', RegimenFiscal::TIPO_PERSONA_MORAL),
            new RegimenFiscal('603', 'Personas Morales con Fines no Lucrativos', RegimenFiscal::TIPO_PERSONA_MORAL),
            new RegimenFiscal('605', 'Sueldos y Salarios e Ingresos Asimilados a Salarios', RegimenFiscal::TIPO_PERSONA_FISICA),
            new RegimenFiscal('606', 'Arrendamiento', RegimenFiscal::TIPO_PERSONA_FISICA),
            new RegimenFiscal('607', 'Régimen de Enagenación o Adquisición de Bienes', RegimenFiscal::TIPO_PERSONA_FISICA),
            new RegimenFiscal('608', 'Demás ingresos', RegimenFiscal::TIPO_PERSONA_FISICA),
            new RegimenFiscal('610', 'Residentes en el Extranjero sin Establecimiento Permanente en México', RegimenFiscal::TIPO_PERSONA_FISICA | RegimenFiscal::TIPO_PERSONA_MORAL),
            new RegimenFiscal('611', 'Ingresos por Dividendos (socios y accionistas)', RegimenFiscal::TIPO_PERSONA_FISICA),
            new RegimenFiscal('612', 'Personas Físicas con Actividades Empresariales y Profesionales', RegimenFiscal::TIPO_PERSONA_FISICA),
            new RegimenFiscal('614', 'Ingresos por intereses', RegimenFiscal::TIPO_PERSONA_FISICA),
            new RegimenFiscal('615', 'Régimen de los ingresos por obtención de premios', RegimenFiscal::TIPO_PERSONA_FISICA),
            new RegimenFiscal('616', 'Sin obligaciones fiscales', RegimenFiscal::TIPO_PERSONA_FISICA),
            new RegimenFiscal('620', 'Sociedades Cooperativas de Producción que optan por diferir sus ingresos', RegimenFiscal::TIPO_PERSONA_MORAL),
            new RegimenFiscal('621', 'Incorporación Fiscal', RegimenFiscal::TIPO_PERSONA_FISICA),
            new RegimenFiscal('622', 'Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras', RegimenFiscal::TIPO_PERSONA_MORAL),
            new RegimenFiscal('623', 'Opcional para Grupos de Sociedades', RegimenFiscal::TIPO_PERSONA_MORAL),
            new RegimenFiscal('624', 'Coordinados', RegimenFiscal::TIPO_PERSONA_MORAL),
            new RegimenFiscal('625', 'Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas', RegimenFiscal::TIPO_PERSONA_FISICA),
            new RegimenFiscal('626', 'Régimen Simplificado de Confianza', RegimenFiscal::TIPO_PERSONA_FISICA | RegimenFiscal::TIPO_PERSONA_MORAL)
        ];
    }

    private static function normalizarDescripcion($descripcion)
    {
        $descripcion = strtr($descripcion, [
            'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U',
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'Ñ' => 'N', 'ñ' => 'n', 'Ü' => 'U', 'ü' => 'u'
        ]);
        $descripcion = strtolower($descripcion);
        $descripcion = preg_replace('/^(regimen\s+((de|del)\s+)?((el|la|los|las)\s+)?)/', '', $descripcion);
        return $descripcion;
    }

    private function getRegimenesNormalizados()
    {
        /** @var RegimenFiscal[] */
        static $regs;
        if (!isset($regs)) {
            $regs = [];
            foreach ($this->regimenes as $r) {
                $regs[static::normalizarDescripcion($r->descripcion)] = $r;
            }
        }
        return $regs;
    }

    public function get(string $clave)
    {
        if (!isset($this->regimenes[$clave])) {
            return null;
        }
        return $this->regimenes[$clave];
    }

    public function find(string $regimen)
    {
        $regimen = static::normalizarDescripcion($regimen);
        $regs = static::getRegimenesNormalizados();
        foreach ($regs as $k => $r) {
            if ($k == $regimen) {
                return $r;
            }
        }
        return null;
    }
}
