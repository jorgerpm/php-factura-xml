<?php
session_start();
$countfiles = count($_FILES['archivos']['name']); //Cuenta el total de archivos
$upload_location = __DIR__.'Archivos_subidos/'; //cargar directorio
$upload_location = str_replace("Controllers", "", $upload_location);
$count = 0;

//$archivo_xml = "";
//$archivo_pdf = "";

for ($i = 0; $i < $countfiles; $i++) {
    $file_name = $_FILES['archivos']['name'][$i]; //Nombre del archivo
    $path = $upload_location . $file_name; //Ruta del archivo
    $file_extension = pathinfo($path, PATHINFO_EXTENSION); //Extensión del archivo
    $file_extension = strtolower($file_extension); //String cambia las letras a minúsculas; strtoupper pone en mayúsculas
    if($file_extension == "xml") {
        $archivo_xml = $_FILES['archivos']['name'][$i];
    }elseif($file_extension == "pdf") {
        $archivo_pdf = $_FILES['archivos']['name'][$i];
    }
    $valid_ext = array("xml", "pdf"); //Extensiones válidas
    if (in_array($file_extension, $valid_ext)) { //Verificar extensiones
        if (move_uploaded_file($_FILES['archivos']['tmp_name'][$i], $path)) { //Cargar archivos
            $count += 1;
        }
    }
}
//echo $count;
/* //copiar el archivo a una carpeta
  foreach($_FILES['archivos']['tmp_name'] as $key => $value) {
  if(file_exists($_FILES['archivos']['tmp_name'][$key])) {
  move_uploaded_file($_FILES['archivos']['tmp_name'][$key], '../Archivos_subidos/'.$_FILES['archivos']['name'][$key]);
  $extension = pathinfo($_FILES['archivos']['name'][$key], PATHINFO_EXTENSION);
  if($extension == "xml") {
  $archivo_xml = $_FILES['archivos']['name'][$key];
  }elseif($extension == "pdf") {
  $archivo_pdf = $_FILES['archivos']['name'][$key];
  }
  else {
  echo "solo archivos con extensiones .xml y .pdf";
  }
  }
  } */

//enviarle a la base de datos
//require_once './../Utils/constantesUtil.php';
require_once '../Models/serviciosWebModelo.php';
$array = [
    'ubicacionArchivo' => '/home/jorge/proyectosPhp/proyectos/php-factura-xml/Archivos_subidos/' . $archivo_xml,
    //'ubicacionArchivo' => $upload_location . $archivo_xml,
    'nombreArchivoXml' => $archivo_xml,
    'nombreArchivoPdf' => isset($archivo_pdf) ? $archivo_pdf : null,
    'urlArchivo' => 'http://localhost/cargaXmlFacturas/Archivos_subidos',
    'idUsuarioCarga' => $_SESSION['Usuario']->id,
    'tipoDocumento' => '01'
];
$servicio = new serviciosWebModelo();
//print_r($servicio);
//print_r($array);
$respp = $servicio->invocarPost('archivoXml/guardarXmlDB', $array);
echo $respp->respuesta;
//header("location: ../cargarXml");
