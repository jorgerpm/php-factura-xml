<?php

class documentoReembolsoControlador extends documentoReembolsoModelo {

    public function listar_documentos_controlador($post, $regsPagina) {

        if (isset($post) && isset($post['dtFechaIni']) && isset($post['dtFechaFin'])) {
            
            $respuesta = documentoReembolsoModelo::listar_documentos_modelo($post['dtFechaIni'], $post['dtFechaFin'],
                            isset($post['listUsers']) ? $post['listUsers'] : null,
                            isset($post['txtEstadoSistema']) ? $post['txtEstadoSistema'] : null,
                    $post['txtDesde'], $regsPagina,
                            );
        } else {
            $respuesta = documentoReembolsoModelo::listar_documentos_modelo(date("Y-m-d"), date("Y-m-d"), 
                    ($_SESSION['Rol']->principal == 0) ? $_SESSION['Usuario']->id : null,
                            null, 0, $regsPagina);
        }

        if (!isset($respuesta)) {
            $respuesta = [];
        }

        return $respuesta;
    }

    public function aprobar_documento_reembolso_controlador() {
        //aqui se necesita el archivo en base64.
        //    echo $_SERVER['HTTP_HOST']; //localhost:9090
    //    print_r($_SERVER);
        $urlDocRemb = $_POST['txtUrlDocReembolso'];
        $nombreSistema = explode("/", $_SERVER["REQUEST_URI"])[1]; //de esta manera se puede obtener el contexto del sistema
        $pathArchivo = ".." .explode($nombreSistema, $urlDocRemb)[1];
        //str_replace("/Controllers", "", __DIR__)
        $ifp = file_get_contents($pathArchivo);
        $fileBase64 = base64_encode($ifp);
        
        $data = array(
            "id" => $_POST['txtIdDocReembolso'],
            "usuarioAutoriza" => $_SESSION['Usuario']->nombre,
            "razonRechazo" => mb_strtoupper($_POST['txtRazonRechazo'], 'utf-8'),
            "estado" => $_POST["selectEstado"],
            "archivoBase64" => $fileBase64,
            "idUsuarioAutoriza" => $_SESSION['Usuario']->id,
        );
        
        $respuesta = documentoReembolsoModelo::aprobar_documento_reembolso_modelo($data);

        if (isset($respuesta)) {
            
            if($respuesta->respuesta != "OK"){
                return '<script>swal("", "'.$respuesta->respuesta.'", "error");</script>';
            }
            else{
                $arrPath = explode("/", $pathArchivo);

                $nuevoPath = str_replace($arrPath[count($arrPath)-1], "", $pathArchivo) . $_POST["selectEstado"];

                if (is_dir($nuevoPath)) {
                    chmod($nuevoPath, 0777);
                } else {
                    mkdir($nuevoPath, 0777, true);
                    chmod($nuevoPath, 0777);
                }

                $output_file = $nuevoPath . "/" . $arrPath[count($arrPath)-1];
                $ifp = fopen($output_file, 'wb' );
                fwrite( $ifp, base64_decode( $respuesta->archivoBase64 ) );
                fclose( $ifp ); 

                return '<script>swal("", "Datos almacenados correctamente", "success")
                        .then((value) => {
                            $(`#btnSearch`).click();
                        });</script>';
                
            }
        } else {
            return '<script>swal("", "Error al guardar los documentos.", "error");</script>';
        }
    }

    
    
    public function guardar_datos_contabilidad_controlador() {

        $data = [
            "id" => $_POST['idReemb'],
            "justificativos" => isset($_POST['justificativos']) ? mb_strtoupper($_POST['justificativos'], 'utf-8') : null,
            "batchIngresoLiquidacion" => isset($_POST['batchIngresoLiquidacion']) ? mb_strtoupper($_POST['batchIngresoLiquidacion'], 'utf-8') : null,
            "batchDocumentoInterno" => isset($_POST['batchDocumentoInterno']) ? mb_strtoupper($_POST['batchDocumentoInterno'], 'utf-8') : null,
            "p3" => isset($_POST['p3']) ? mb_strtoupper($_POST['p3'], 'utf-8') : null,
            "p4" => isset($_POST['p4']) ? mb_strtoupper($_POST['p4'], 'utf-8') : null,
            "p5" => isset($_POST['p5']) ? mb_strtoupper($_POST['p5'], 'utf-8') : null,
            "phne" => isset($_POST['phne']) ? mb_strtoupper($_POST['phne'], 'utf-8') : null,
            "cruce1" => isset($_POST['cruce1']) ? mb_strtoupper($_POST['cruce1'], 'utf-8') : null,
            "cruce2" => isset($_POST['cruce2']) ? mb_strtoupper($_POST['cruce2'], 'utf-8') : null,
            "tipoDocumento" => isset($_POST['tipoDocumento']) ? mb_strtoupper($_POST['tipoDocumento'], 'utf-8') : null,
            "numeroDocumento" => isset($_POST['numeroDocumento']) ? mb_strtoupper($_POST['numeroDocumento'], 'utf-8') : null,
            "numeroRetencion" => isset($_POST['numeroRetencion']) ? mb_strtoupper($_POST['numeroRetencion'], 'utf-8') : null,
        ];
            
        $respuesta = documentoReembolsoModelo::guardar_datos_contabilidad_modelo($data);


        if (isset($respuesta) && $respuesta->respuesta == "OK") {
            return "<script>swal('','Datos almacenados correctamente.','info')
                .then((value) => {
                            $(`#btnSearch`).click();
                        });</script>;</script>";
        }
        else{
            return "<script>swal('','Error: ".$respuesta->respuesta."','error');</script>";
        }

        
    }
    
    
    
    public function enviar_correo_justificacion_controlador() {

        $urlDocRemb = $_POST['txtUrlDocReembolso'];
        $nombreSistema = explode("/", $_SERVER["REQUEST_URI"])[1]; //de esta manera se puede obtener el contexto del sistema
        $pathArchivo = ".." .explode($nombreSistema, $urlDocRemb)[1];
        //str_replace("/Controllers", "", __DIR__)
        $ifp = file_get_contents($pathArchivo);
        $fileBase64 = base64_encode($ifp);
        
        $data = [
            "id" => $_POST['idReembolso'],
            "archivoBase64" => $fileBase64,
        ];
            
        $respuesta = documentoReembolsoModelo::enviar_correo_justificacion_modelo($data);

        if (isset($respuesta) && $respuesta->respuesta == "OK") {
            return "OK";
        }
        else{
            return isset($respuesta) ? $respuesta->respuesta : "Error enviando el correo.";
        }

        
    }
    
    
    
    
    public function cargar_justificacion_controlador() {

        $fileP12 = file_get_contents($_FILES['txtArchivoJust']['tmp_name']);
        $archivoB64 = base64_encode($fileP12);


        $data = [
            'id' => $_POST['idReembJust'],
            'justificacionBase64' => $archivoB64,
        ];

        $respuesta = documentoReembolsoModelo::cargar_justificacion_modelo($data);

        if (isset($respuesta) && $respuesta->respuesta == "OK") {
            return "<script>swal('','Archivo cargado correctamente y correo enviado.','info')
                .then((value) => {
                            $(`#btnSearch`).click();
                        });</script>";
        }
        else if(isset($respuesta)){
            return "<script>swal('','Error: ".$respuesta->respuesta."','error');</script>";
        }
        else{
            return "<script>swal('','Error al cargar el archivo y al enviar el correo.','error');</script>";
        }
    }
    
}
