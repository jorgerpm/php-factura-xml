<?php

if (is_file('./Utils/configUtil.php')) {
    require_once './Utils/configUtil.php';
} else {
    require_once '../Utils/configUtil.php';
}

if (isset($_SESSION['Usuario'])) {

//    print_r(json_decode($_POST['detalles']));

    $dets = json_decode($_POST['detalles']);

    $cargarXmlModelo = new cargarXmlModelo();
    $respuesta = $cargarXmlModelo->cargar_archivo_sri_modelo($dets);

    if (isset($respuesta) && count($respuesta) > 0) {
        $respss = "";
        //aqui comprar el resultado de lacarga
        foreach ($respuesta as $arch){
//            echo $arch->respuesta;
//            echo PHP_EOL;
            
            if(isset($arch->respuesta) && strpos($arch->respuesta, "OK") !== false ){
                //aqui guardar los archivos en el disco
//                echo $arch->pathArchivos;
                $content = base64_decode($arch->fileBase64);
                $contentRide = base64_decode($arch->rideBase64);
                
//                echo "<br/>";
                $path = str_replace("acciones", "", __DIR__) . $arch->pathArchivos;
//                echo $path;
//                echo "<br/>";
                
                if(is_dir($path)){
//                    echo "SIIII existe";
                }
                else{
//                    echo "no existe";
                    mkdir($path, 0777, true);
//                    chmod($path, 0766);
                }
                //dar los permisos cuando existe
                $pathAux = $path;
                $arrayPath = explode("/", $path);
                $pathsArray = [];
                for ($i = (count($arrayPath)-1) ; $i>(count($arrayPath)-4) ; $i--){
                    $pathAux = str_replace("/".$arrayPath[$i], "", $pathAux);
//                    echo "<br>";
//                    echo PHP_EOL;
//                    echo $pathAux;
//                    echo "<br>";
//                    echo PHP_EOL;
//                    echo $i;
                    $pathsArray[$i] = $pathAux;
                }
                for($i = (count($arrayPath)-3); $i<count($arrayPath);$i++){
//                    echo "<br>";
//                    echo PHP_EOL;
//                    echo $i;
//                    echo "<br>";
//                    echo PHP_EOL;
//                    echo $pathsArray[$i];
                    chmod($pathsArray[$i], 0777);
                }
                chmod($path, 0777);
                
                //esta parte es para guardar el xml
                $file = fopen($path."/".$arch->claveAcceso.".xml", "w+b");
                fwrite($file, $content);
                fclose($file);
                chmod($path."/".$arch->claveAcceso.".xml", 0666);
                
                //y esta parte es para guardar el ridepdf
                $fileRide = fopen($path."/".$arch->claveAcceso.".pdf", "w+b");
                fwrite($fileRide, $contentRide);
                fclose($fileRide);
                chmod($path."/".$arch->claveAcceso.".pdf", 0666);
                
                
                //aca hacer el mesnaje de respuesta
                //echo '<script>swal("", "Datos cargados correctamente", "success");</script>';
//                    .then((value) => {
//                        $(`#btnBuscar`).click();
//                    });</script>';
                
            }
            else if(isset($arch->respuesta)){
                $respss = $respss . $arch->respuesta . " ";
//                echo '<script>swal("", "'.$arch->respuesta.'", "error");</script>';
            }
            else{
                $respss = $respss . $arch->respuesta . " ";
//                echo '<script>swal("", "Error al cargar las facturas.", "error");</script>';
            }
        }
        
        if($respss === ""){
//            echo '<script>swal("", "Datos cargados correctamente", "success");</script>';
        }
        else{
//            echo '<script>swal("", "' . $respss . '", "error");</script>';
        }
    }

    print_r(json_encode($respuesta));
}
else{
    header("Location: index");
    echo '<script>window.location.replace("index");</script>';
}

