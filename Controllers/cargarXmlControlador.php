<?php

class cargarXmlControlador extends cargarXmlModelo {

    public function cargar_archivo_controlador() {

        if (isset($_SESSION['Usuario'])) {

            $countfiles = count($_FILES['archivos']['name']); //Cuenta el total de archivos
            $upload_location = __DIR__ . 'Archivos_subidos/'; //cargar directorio
            $upload_location = str_replace("Controllers", "", $upload_location);
            $count = 0;

            for ($i = 0; $i < $countfiles; $i++) {
                $file_name = $_FILES['archivos']['name'][$i]; //Nombre del archivo
                $path = $upload_location . $file_name; //Ruta del archivo
                $file_extension = pathinfo($path, PATHINFO_EXTENSION); //Extensión del archivo
                $file_extension = mb_strtolower($file_extension, 'utf-8'); //String cambia las letras a minúsculas; strtoupper pone en mayúsculas
                if ($file_extension == "xml") {
                    $archivo_xml = $_FILES['archivos']['name'][$i];
                } elseif ($file_extension == "pdf") {
                    $archivo_pdf = $_FILES['archivos']['name'][$i];
                }
                $valid_ext = array("xml", "pdf"); //Extensiones válidas
                if (in_array($file_extension, $valid_ext)) { //Verificar extensiones
                    //verificar si ya existe el archivo
                    if (is_file($path)) {
                        return "Ya existe un archivo con el mismo nombre, no se puede cargar el mismo archivo.";
                    } else {
//                        echo $_FILES['archivos']['tmp_name'][$i].PHP_EOL;
                        if (move_uploaded_file($_FILES['archivos']['tmp_name'][$i], $path)) { //Cargar archivos
                            $count += 1;
                        }
                    }
                }
            }
            //echo $count;
            if ($count > 0) {

                //convertir el archivo a base64 para ser enviado
                $fileXml = file_get_contents($upload_location . $archivo_xml);
                $fileB64 = base64_encode($fileXml);


                $array = [
                    'ubicacionArchivo' => $upload_location . $archivo_xml,
                    'nombreArchivoXml' => $archivo_xml,
                    'nombreArchivoPdf' => isset($archivo_pdf) ? $archivo_pdf : null,
                    'urlArchivo' => constantesUtil::$URL_ARCHIVOS,
                    'idUsuarioCarga' => $_SESSION['Usuario']->id,
                    'tipoDocumento' => '01',
                    'xmlBase64' => $fileB64,
                    "tipoDocumento" => $_POST['txtTipoDoc'],
                ];

                $respuesta = cargarXmlModelo::cargar_archivo_modelo($array);

                if (isset($respuesta) && isset($respuesta->respuesta)) {
//                    echo $respuesta->respuesta;
                    //mover el archivo a la ubicacion real de carpetas creadas en el java
                    if ($respuesta->respuesta == "OK") {

//                        echo "mover desde: " . $pathXml y $pathPdf;
//                        print_r($respuesta);
//                        echo PHP_EOL;
//                        print_r($respuesta->dto);

                        $carpetasPath = str_replace("Controllers", "", __DIR__) . $respuesta->dto; //aqui el path real 

//                        echo "mover hacia: " . $carpetasPath;

                        if (is_dir($carpetasPath)) {
                            //                    echo "SIIII existe";
                        } else {
                            //dar los permisos cuando existe
                            $pathAux = $carpetasPath;
                            $arrayPath = explode("/", $carpetasPath);
                            $pathsArray = [];
                            for ($i = (count($arrayPath) - 1); $i > (count($arrayPath) - 4); $i--) {
                                $pathAux = str_replace("/" . $arrayPath[$i], "", $pathAux);
//                                echo "<br>";
//                                echo PHP_EOL;
//                                echo $pathAux;
//                                echo "<br>";
//                                echo PHP_EOL;
//                                echo $i;
                                $pathsArray[$i] = $pathAux;
                            }
                            for ($i = (count($arrayPath) - 3); $i < count($arrayPath); $i++) {
//                                echo "<br>";
//                                echo PHP_EOL;
//                                echo $i;
//                                echo "<br>";
//                                echo PHP_EOL;
//                                echo $pathsArray[$i];
                                if (is_dir($pathsArray[$i])) {
                                    chmod($pathsArray[$i], 0777);
                                } else {
                                    mkdir($pathsArray[$i], 0777, true);
                                    chmod($pathsArray[$i], 0777);
                                }
                            }
                            
                            mkdir($carpetasPath, 0777, true);
                            chmod($carpetasPath, 0777);
                        }

                        //debe escribir en la nueva ubicacion el archivo pdf y el xml., los dos
//                        echo PHP_EOL."Desde: ".$upload_location . $archivo_xml." - Hasta: ".$carpetasPath . "/".$archivo_xml.PHP_EOL;
                        if (rename(($upload_location.$archivo_xml), $carpetasPath ."/".$archivo_xml)) {
                            chmod($carpetasPath . "/".$archivo_xml, 0666);
//                            echo "MOVIOOOOOO <br/>";
                        } else {
//                            echo "NOO se movvvv";
                        }
                        //escribir el archivo pdf
//                        echo PHP_EOL."Desde: ".$upload_location . $archivo_pdf." - Hasta: ".$carpetasPath . "/".$archivo_pdf.PHP_EOL;
                        if (rename(($upload_location.$archivo_pdf), $carpetasPath ."/".$archivo_pdf)) {
                            chmod($carpetasPath . "/".$archivo_pdf, 0666);
//                            echo "MOVIOOOOOO <br/>";
                        } else {
//                            echo "NOO se movvvv";
                        }
                    }
                    $respuesta = $respuesta->respuesta;
                }

                //si la respuesta es diferente a OK, no cargo archivo en base y se debe borrar el archivo fisico del disco
                if ($respuesta != "OK") {
                    if (is_file($upload_location . $archivo_xml)) {
                        unlink($upload_location . $archivo_xml);
                    }
                    if (is_file($upload_location . $archivo_pdf)) {
                        unlink($upload_location . $archivo_pdf);
                    }
                }

                return $respuesta;
            } else {
                return "No se carg&oacute; el archivo.";
            }
        }
    }
    
    
    public function eliminar_xmlcargado_controlador(){
        $respuesta = cargarXmlModelo::eliminar_xmlcargado_modelo($_POST["idXml"]);
        //se debe eliminar el archivo del disco del path que corresponde
        if(isset($respuesta->urlArchivo) && $respuesta->urlArchivo != null){
            $pathArchivo = "../" . str_replace($_SESSION['URL_SISTEMA'], "", $respuesta->urlArchivo) . "/";
            
            if(isset($respuesta->nombreArchivoXml) && $respuesta->nombreArchivoXml != null){
                $pathArchivoXml = $pathArchivo . $respuesta->nombreArchivoXml;
            }
            if(isset($respuesta->nombreArchivoPdf) && $respuesta->nombreArchivoPdf != null){
                $pathArchivoPdf = $pathArchivo . $respuesta->nombreArchivoPdf;
            }

            if(isset($pathArchivoXml) && is_file($pathArchivoXml)){
                unlink($pathArchivoXml);
            }
            if(isset($pathArchivoPdf) && is_file($pathArchivoPdf)){
                unlink($pathArchivoPdf);
            }
        }
    }
    
    public function guardar_miscelaneo_controlador(){
        
//        print_r($_FILES['inputFileXml']);
        //aunque no se seleccione un archivo aca si llega el objeto $_FILES['inputFileXml']
        $countfiles = $_FILES['inputFileXml']['size']; //tamanio del archivo
        if($countfiles > 0){
            $file_extension = pathinfo($_FILES['inputFileXml']['name'], PATHINFO_EXTENSION);
            
            $nombreArchivo = str_replace(".".$file_extension, "", $_FILES['inputFileXml']['name']) ."_". strtotime("now") . "." . $file_extension;
        }
        
        $claveAcceso = $_SESSION['Usuario']->cedula . strtotime("now");
        
        $data = array(
            'tipoDocumento' => "MS",
            'estadoSri' => "AUTORIZADO",
            'numeroAutorizacion' => $claveAcceso,
            'fechaAutorizacion' => $_POST['txtFecha'],
            'fechaEmision' => $_POST['txtFecha'],
            'ambiente' => "PRODUCCIÓN",
            'idUsuarioCarga' => $_SESSION['Usuario']->id,
            'fechaCarga' => date('Y-m-d'),
            'claveAcceso' => $claveAcceso,
            'estadoSistema' => "CARGADO",
            'esFisica' => true,
            'razonSocial' => $_SESSION['Usuario']->nombre,
            'nombreArchivoPdf' => isset($nombreArchivo) ? $nombreArchivo : null,
            'comprobante' => '{"factura":{"infoTributaria":{"claveAcceso":"'.$claveAcceso.'","ambiente":2,"ruc":"'.$_SESSION['Usuario']->cedula.'",'
            . '"razonSocial":"'.$_SESSION['Usuario']->nombre
            . '","estab":"001","ptoEmi":"001","secuencial":"'.strtotime($_POST["txtFecha"]).'","codDoc":"MS","tipoEmision":1,"dirMatriz":"DIRECCION"},'
            . '"infoFactura":{"pagos":{"pago":[{"total":'.$_POST["txtValor"].',"plazo":1,"formaPago":"01","unidadTiempo":""}]},'
            . '"totalConImpuestos":{"totalImpuesto":[{"codigoPorcentaje":"0","tarifa":"0","codigo":2,"valor":0.0,"baseImponible":'.$_POST["txtValor"].'}]},'
            . '"identificacionComprador":"'.$_SESSION['Usuario']->cedula.'","razonSocialComprador":"'.$_SESSION['Usuario']->nombre.'",'
            . '"obligadoContabilidad":"NO","fechaEmision":"'.$_POST["txtFecha"].'","tipoIdentificacionComprador":"05","importeTotal":'.$_POST["txtValor"].','
            . '"totalDescuento":0.0,"moneda":"DOLAR","totalSinImpuestos":'.$_POST["txtValor"].'},'
            . '"detalles":{"detalle":[{"descripcion":"'.$_POST["txtConcepto"].'","precioUnitario":'.$_POST["txtValor"].','
            . '"precioTotalSinImpuesto":'.$_POST["txtValor"].',"descuento":0.0,"codigoPrincipal":"'.substr($_POST["txtConcepto"], 0, 3).'",'
            . '"cantidad":1,"impuestos":{"impuesto":[{"codigoPorcentaje":"0","tarifa":0,"codigo":"2","valor":0,"baseImponible":'.$_POST["txtValor"].'}]}}]}}}',
        );
        $respuesta = cargarXmlModelo::guardar_miscelaneo_modelo($data);
        
        if(isset($respuesta) && $respuesta->respuesta == "OK"){
            
            //tomar el archivo cargado, pero solo si si cargaron un archivo y 
            //guardarlo en la carpeta que corresponde
            if($countfiles > 0){
                $path_file = "../" . $respuesta->ubicacionArchivo;
                
                if (is_dir($path_file)) {
//                    echo "SIIII existe";
                } else {
                    $raux = explode("/", $respuesta->ubicacionArchivo);
                    //dar los permisos cuando no existe
                    $pathsArray = "../".$raux[0];
                
                    for ($i = 1; $i < count($raux); $i++) {
                        $pathsArray = $pathsArray . "/" .$raux[$i];
                        //echo $pathsArray . PHP_EOL;

                        if (is_dir($pathsArray)) {
                            chmod($pathsArray, 0777);
                        } else {
                            mkdir($pathsArray, 0777, true);
                            chmod($pathsArray, 0777);
                        }
                    }
                }
                
                $path = "../".$respuesta->ubicacionArchivo . "/" . $nombreArchivo;//aqui donde se debe guardar + el nombre del archivo
                
                if (move_uploaded_file($_FILES['inputFileXml']['tmp_name'], $path)) { //Cargar archivos
                    //exito
                }
            }
            
            return '<script>swal("", "Documentos almacenados correctamente", "success")
                    .then((value) => {
                        $(`#btnBuscaXmlCargados`).click();
                    });</script>';
        }
        else if(isset($respuesta)){
            return '<script>swal("", "'.$respuesta->respuesta.'", "error");</script>';
        }
        else {
            return '<script>swal("", "Error al guardar los datos.", "error");</script>';
        }
    }

}
