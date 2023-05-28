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
                isset($_POST['seleccion']) ? $_POST['seleccion'] : ""
                
            
                );
        
        if(isset($reporteDto) && $reporteDto->respuesta == "OK"){
            
            if($_POST['reporte'] == "SIFIRMA"){
            
                $output_file = $reporteDto->pathArchivo;
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
