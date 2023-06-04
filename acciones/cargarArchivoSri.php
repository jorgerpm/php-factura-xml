<?php

if (is_file('./Utils/configUtil.php')) {
    require_once './Utils/configUtil.php';
} else {
    require_once '../Utils/configUtil.php';
}

if (isset($_SESSION['Usuario'])) {
//set_time_limit(300);
//    print_r(json_decode($_POST['detalles']));

    $dets = json_decode($_POST['detalles']);

//    count($dets);
//    print_r($dets);
//    echo PHP_EOL;
    
    
    $arrayDetalles = [];
    $respuesta = [];
    for($i=0;$i<count($dets);$i++){
        $respuestaAux = null;
        $arrayDetalles[] = $dets[$i];
//        array_push($arrayDetalles, $dets[i]);
        
        if(($i+1) == count($dets)){
//            print_r($arrayDetalles);
            $cargarXmlModelo = new cargarXmlModelo();
            $respuestaAux = $cargarXmlModelo->cargar_archivo_sri_modelo($arrayDetalles);
            
            $arrayDetalles = [];
        }
        else{
            if((($i+1) % 3) == 0){
//                echo "es multiplo de 10<br>".PHP_EOL;
                $cargarXmlModelo = new cargarXmlModelo();
                $respuestaAux = $cargarXmlModelo->cargar_archivo_sri_modelo($arrayDetalles);
                
                $arrayDetalles = [];
            }
        }
        
        if($respuestaAux != null && count($respuestaAux) > 0){
            foreach ($respuestaAux as $aux){
                $respuesta[] = $aux;
            }
        }
    }
    
    
    //
//    $cargarXmlModelo = new cargarXmlModelo();
//    $respuesta = $cargarXmlModelo->cargar_archivo_sri_modelo($dets);

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
                
                
            }
            else if(isset($arch->respuesta)){
                $respss = $respss . $arch->respuesta . " ";
//                echo '<script>swal("", "'.$arch->respuesta.'", "error");</script>';
            }
            else{
                $respss = $respss . $arch->respuesta . " ";
//                echo '<script>swal("", "Error al cargar las facturas.", "error");</script>';
            }
            
            $arch->fileBase64 = null;
            $arch->rideBase64 = null;
            $arch->pathArchivos = null;
            
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

