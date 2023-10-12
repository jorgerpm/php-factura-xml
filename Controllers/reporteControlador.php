<?php

class reporteControlador extends reporteModelo {

    public function ejecutar_reportepdf_controlador() {
        $reporteDto = reporteModelo::ejecutar_reportepdf_modelo($_POST['reporte'], $_POST['id']);
        
        if(isset($reporteDto) && $reporteDto->respuesta == "OK"){
//            $output_file = "tmp/".$_POST['reporte'].".pdf";
//            $ifp = fopen("../".$output_file, 'wb' );
//            fwrite( $ifp, base64_decode( $reporteDto->reporteBase64 ) );
//            fclose( $ifp ); 
//            base64_decode($reporteDto->reporteBase64);
//            return $output_file;
            return $reporteDto->reporteBase64;
        }
        
        return "";
    }
    
    public function ejecutar_reportexls_controlador() {
        $reporteDto = reporteModelo::ejecutar_reportexls_modelo($_POST['reporte'], $_POST['fechaIni'], $_POST['fechaFin']);
        
        if(isset($reporteDto) && $reporteDto->respuesta == "OK"){
//            $output_file = "tmp/".$_POST['reporte'].".xls";
//            $ifp = fopen("../".$output_file, 'wb' );
//            fwrite( $ifp, base64_decode( $reporteDto->reporteBase64 ) );
//            fclose( $ifp ); 
//            base64_decode($reporteDto->reporteBase64);
//            return $output_file;
            return $reporteDto->reporteBase64;
        }
        
        return "";
    }
    
    
    public function ejecutar_reportefirma_controlador() {
        $reporteDto = reporteModelo::ejecutar_reportefirma_modelo($_POST['reporte'], $_POST['ids'], $_POST['tiposGasto'], $_POST['tipoReembolso'], 
                $_SESSION["Usuario"]->id, $_POST['txtAprobador'], $_POST['asistentes'],
                
                mb_strtoupper($_POST['motivoViaje'], 'utf-8'),
                mb_strtoupper($_POST['periodoViaje'], 'utf-8'),
                mb_strtoupper($_POST['lugarViaje'], 'utf-8'),
                isset($_POST['fondoEntregado']) ? $_POST['fondoEntregado'] : 0,
                isset($_POST['observaciones']) ? mb_strtoupper($_POST['observaciones'], 'utf-8') : "",
                isset($_POST['seleccion']) ? $_POST['seleccion'] : "",
                isset($_POST['claveFirma']) ? $_POST['claveFirma'] : "",
                mb_strtoupper($_POST['numeroRC'], 'utf-8'),
                );
        
        if(isset($reporteDto) && $reporteDto->respuesta == "OK"){
            
            //esto se hace solo cuando ya firma, y escribe el archivo en disco en el 
            //path que viene desde el backend
            if($_POST['reporte'] == "SIFIRMA"){
            
                $output_file = $reporteDto->pathArchivo; //=> Archivos_subidos/reembolsos/VIAJES/POR_AUTORIZAR/1697061648256.pdf
                
                $raux = explode("/", $output_file);
                //desde aqui sale y se va al archivos_subidos que es la carpeta principal
                $path_file = "../" . str_replace("/".$raux[4], "", $output_file);
                
                if (is_dir($path_file)) {
//                    echo "SIIII existe";
                } else {
                    //dar los permisos cuando no existe
                    $pathsArray = "../".$raux[0];
                    
                    for ($i = 1; $i < count($raux)-1; $i++) {
//                                echo "<br>";
//                                echo PHP_EOL;
//                                echo $i;
//                                echo "<br>";
//                                echo PHP_EOL;
//                                echo $pathsArray[$i];
                        $pathsArray = $pathsArray . "/" .$raux[$i];
                        //echo $pathsArray . PHP_EOL;
                        
                        if (is_dir($pathsArray)) {
                            chmod($pathsArray, 0777);
                        } else {
                            mkdir($pathsArray, 0777, true);
                            chmod($pathsArray, 0777);
                        }
                    }

                    mkdir($path_file, 0777, true);
                    chmod($path_file, 0777);
                }
                
                
                $ifp = fopen("../".$output_file, 'wb' );
                fwrite( $ifp, base64_decode( $reporteDto->reporteBase64 ) );
                fclose( $ifp ); 
                return "CORRECTO";
            }
            
            
            return $reporteDto->reporteBase64;
        }
        else if(isset($reporteDto) && isset($reporteDto->respuesta)){
            return "ERROR: ".$reporteDto->respuesta;
        }
        else{
            return "ERROR AL GENERAR EL ARCHIVO PDF.";
        }
        
        return "";
    }
    
}
