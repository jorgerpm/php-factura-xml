<?php

class cargarXmlControlador extends cargarXmlModelo {

    public function cargar_archivo_controlador() {
        
        if(isset($_SESSION['Usuario'])){

            $countfiles = count($_FILES['archivos']['name']); //Cuenta el total de archivos
            $upload_location = __DIR__ . 'Archivos_subidos/'; //cargar directorio
            $upload_location = str_replace("Controllers", "", $upload_location);
            $count = 0;

            for ($i = 0; $i < $countfiles; $i++) {
                $file_name = $_FILES['archivos']['name'][$i]; //Nombre del archivo
                $path = $upload_location . $file_name; //Ruta del archivo
                $file_extension = pathinfo($path, PATHINFO_EXTENSION); //Extensión del archivo
                $file_extension = strtolower($file_extension); //String cambia las letras a minúsculas; strtoupper pone en mayúsculas
                if ($file_extension == "xml") {
                    $archivo_xml = $_FILES['archivos']['name'][$i];
                } elseif ($file_extension == "pdf") {
                    $archivo_pdf = $_FILES['archivos']['name'][$i];
                }
                $valid_ext = array("xml", "pdf"); //Extensiones válidas
                if (in_array($file_extension, $valid_ext)) { //Verificar extensiones
                    //verificar si ya existe el archivo
                    if(is_file($path)){
                        return "Ya existe un archivo con el mismo nombre, no se puede cargar el mismo archivo.";
                    }
                    else{
                        if (move_uploaded_file($_FILES['archivos']['tmp_name'][$i], $path)) { //Cargar archivos
                            $count += 1;
                        }
                    }
                }
            }
    //echo $count;
            if($count > 0){

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
                ];

                $respuesta = cargarXmlModelo::cargar_archivo_modelo($array);
                
                if(isset($respuesta) && isset($respuesta->respuesta)){
                    $respuesta = $respuesta->respuesta;
                }

                //si la respuesta es diferente a OK, no cargo archivo en base y se debe borrar el archivo fisico del disco
                if($respuesta != "OK"){
                    if(is_file($upload_location . $archivo_xml)){
                        unlink($upload_location . $archivo_xml);
                    }
                }

                return $respuesta;
            }
            else{
                return "No se carg&oacute; el archivo.";
            }
            
        }
    }

}
