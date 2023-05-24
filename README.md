Datos Fiscales México
=======================================

Herramienta para recuperar la información de las Cédulas de Identificación
Fiscal del portal SAT utilizando los datos del QR de la Constancia de Situación
Fiscal.

Instalación
---------------------------------------

La instalación se puede realizar mediante composer.

```sh
composer require francerz/mx-sat-cif
```

Utilización
---------------------------------------

```php
use Francerz\MxSatCif\WebServiceCIF;

$httpClient = new HttpClient();
$requestFactory = new RequestFactory();

$wscif = new WebServiceCIF($httpClient, $requestFactory);

$idCIF = '12000000000';
$rfc = 'XAXX000101XAX';

$cedula = $wscif->fetch($idCIF, $rfc);

/*
    DATOS DE IDENTIFICACION
*/
echo $cedula->idCif;
echo $cedula->rfc;

/*
    DATOS DE IDENTIFICACIÓN (PERSONA FISICA)
*/
echo $cedula->tipo; // (string) DatosIdentificacion::TIPO_PERSONA_FISICA = "Persona Física"
echo $cedula->curp; // (string) Clave Única de Registro de Población
echo $cedula->nombre; // (string) Nombre del contribuyente
echo $cedula->apellidoPaterno; // (string) Primer apellido del contribuyente
echo $cedula->apellidoMaterno; // (string) Segundo apellido del contribuyente
echo $cedula->fechaNacimiento; // (DateTimeImmutable) Fecha de nacimiento

/*
    DATOS DE IDENTIFICACION (PERSONA MORAL)
*/
echo $cedula->tipo; // (string) DatosIdentificacion::TIPO_PERSONA_FISICA =  "Persona Moral"
echo $cedula->razonSocial; // (string) Denominación o Razón Social.
echo $cedula->regimenCapital; // (string) Régimen capital.
echo $cedula->fechaConstitucion; // (DateTimeImmutable) Fecha de constitución de la persona moral

/*
    DATOS DE IDENTIFICACIÓN (PERSONA FÍSICA Y MORAL)
*/
echo $cedula->fechaInicioOperaciones; // (DateTimeImmutable) Fecha de inicio de operaciones.
echo $cedula->situacionContribuyente; // (string) Situación del Contribuyente.
echo $cedula->fechaUltimoCambioSituacion; // (DateTimeImmutable) Fecha del último cambio de situación.


/*
    DATOS DE UBICACIÓN
*/
echo $cedula->entidadFederativa; // (string) Nombre de la entidad federativa del domicilio fiscal.
echo $cedula->municipio; // (string) Nombre del municipio.
echo $cedula->colonia; // (string) Nombre de la colonia.
echo $cedula->tipoVialidad; // (string) Tipo de vialidad (ej. calle, avenida, boulevard).
echo $cedula->nombreVialidad; // (string) Nombre de la vialidad del domicilio fiscal.
echo $cedula->numeroExterior; // (string) Número exterior del domicilio.
echo $cedula->numeroInterior; // (string) Número interior del domicilio (vacío si no aplica).
echo $cedula->codigoPostal; // (string) Código postal del asentamiento (colonia).
echo $cedula->correoElectronico; // (string) Dirección de correo electrónico registrada.

/*
    CACTERÍSTICAS FISCALES (REGÍMENES)


    El atributo características de CedulaIdentificacionFiscal es un arreglo de
    objetos del tipo Característica Fiscal.

    $cedula->caracteristicas : CaracteristicaFiscal[]
*/
foreach ($cedula->caracteristicas as $caracteristica) {
    echo $caracteristica->regimen; // (string) Nombre del régimen.
    echo $caracteristica->fechaAlta; // (DateTimeImmutable) Fecha de alta del régimen.
}

```
