<?php
if (is_file('./Utils/configUtil.php')) {
    require_once './Utils/configUtil.php';
} else {
    require_once '../Utils/configUtil.php';
}

$archiCont = new archivoXmlControlador();
$respuesta = $archiCont->listar_archivos_controlador($_POST, 100000);
$columns = $archiCont->crear_columnas($respuesta);
//print_r($columns);
$csv = [];

$colus = "";
foreach ($columns as $cols){
    //array_push($colus, $cols['col']);
    $colus = $colus.$cols['col'].";";
}
$colus = $colus."~";

array_push($csv, $colus);



if (count($respuesta) > 0) {
    foreach ($respuesta as $listaArchivoXml) {
        $filas = [];
        array_push($filas, $listaArchivoXml->estadoSistema);
        array_push($filas, $listaArchivoXml->nombreUsuario);
        array_push($filas, date("d/m/Y", $listaArchivoXml->fechaEmision / 1000));
        array_push($filas, date("d/m/Y", $listaArchivoXml->fechaAutorizacion / 1000));
        array_push($filas, $listaArchivoXml->estadoSri);
        array_push($filas, $listaArchivoXml->numeroAutorizacion);
        array_push($filas, $listaArchivoXml->ambiente);
        
        $listvarj = json_decode($listaArchivoXml->comprobante);
        
        $tabla = new generarTablaControlador();
        $valores = $tabla->generarTabla($listvarj, $columns);


        foreach ($valores as $vals) {

            array_push($filas, $vals);

        }

        
        array_push($filas, $listaArchivoXml->tipoDocumentoTexto);
        array_push($filas, $listaArchivoXml->codigoJDProveedor);
        array_push($filas, $listaArchivoXml->usuarioAnula);
        array_push($filas, isset($listaArchivoXml->fechaAnula) ? date("d/m/Y", $listaArchivoXml->fechaAnula / 1000) : "");
        array_push($filas, $listaArchivoXml->razonAnulacion);
        array_push($filas, $listaArchivoXml->numeroReembolso);
        array_push($filas, $listaArchivoXml->tipoReembolso);
        
        array_push($filas, (($listaArchivoXml->nombreArchivoXml != null) ? $_SESSION["URL_SISTEMA"] . $listaArchivoXml->urlArchivo . "/" . $listaArchivoXml->nombreArchivoXml : ''));
        array_push($filas, (($listaArchivoXml->nombreArchivoPdf != null) ? $_SESSION["URL_SISTEMA"] . $listaArchivoXml->urlArchivo . "/" . $listaArchivoXml->nombreArchivoPdf : ''));
        
        if(isset($_POST['conDetalles']) && $_POST['conDetalles'] == true){
            array_push($filas, $listaArchivoXml->detalle);
            array_push($filas, $listaArchivoXml->precioUnitario);
            //para las retenciones
            array_push($filas, $listaArchivoXml->codDocSustento);
            array_push($filas, $listaArchivoXml->numDocSustento);
            array_push($filas, $listaArchivoXml->fechaEmisionDocSustento);
            array_push($filas, $listaArchivoXml->codigoRetencion);
            array_push($filas, $listaArchivoXml->baseImponible);
            array_push($filas, $listaArchivoXml->porcentajeRetener);
            array_push($filas, $listaArchivoXml->valorRetenido);
        }
        

        //al final se agregar fila por fila
        $filAux="";
        foreach ($filas as $dd){
            $filAux = $filAux.$dd.";";
        }
        $filAux = $filAux."~";
        
        array_push($csv, $filAux);
    }
    
    //echo '<br>';
    print_r($csv);
//    echo json_encode($csv);
    //echo '<br>';
}

