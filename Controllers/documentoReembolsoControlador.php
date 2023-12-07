<?php

class documentoReembolsoControlador extends documentoReembolsoModelo {

    public function listar_documentos_controlador($post, $regsPagina) {

        if (isset($post) && isset($post['dtFechaIni']) && isset($post['dtFechaFin'])) {
            
            $respuesta = documentoReembolsoModelo::listar_documentos_modelo($post['dtFechaIni'], $post['dtFechaFin'],
                            isset($post['listUsers']) ? $post['listUsers'] : null,
                            isset($post['txtEstadoSistema']) ? $post['txtEstadoSistema'] : null,
                    $post['txtDesde'], $regsPagina,
                    isset($post['txtNumeroRC']) ? $post['txtNumeroRC'] : null,
                    isset($post['txtTipoReembolso']) ? $post['txtTipoReembolso'] : null,
                    isset($post['txtNumeroReembolso']) ? $post['txtNumeroReembolso'] : null,
                    isset($post['txtNumeroLC']) ? $post['txtNumeroLC'] : null,
                            );
        } else {
            $respuesta = documentoReembolsoModelo::listar_documentos_modelo(date("Y-m-d"), date("Y-m-d"), 
                    ($_SESSION['Rol']->principal == 0) ? $_SESSION['Usuario']->id : null,
                            null, 0, $regsPagina, null, null, null, null);
        }

        if (!isset($respuesta)) {
            $respuesta = [];
        }

        return $respuesta;
    }

    public function aprobar_documento_reembolso_controlador() {
        
        if(isset($_POST['selectEstado']) && $_POST['selectEstado'] != "" 
                && $_POST['selectEstado'] != "null" && $_POST['selectEstado'] != null){
            //aqui se necesita el archivo en base64.
            $pathArchivo = "../". $_POST['txtUrlDocReembolso']; 
            $ifp = file_get_contents($pathArchivo);
            $fileBase64 = base64_encode($ifp);

            $data = array(
                "id" => $_POST['txtIdDocReembolso'],
                "usuarioAutoriza" => $_SESSION['Usuario']->nombre,
                "razonRechazo" => mb_strtoupper($_POST['txtRazonRechazo'], 'utf-8'),
                "estado" => $_POST["selectEstado"],
                "archivoBase64" => $fileBase64,
                "idUsuarioAutoriza" => $_SESSION['Usuario']->id,
                "claveFirma" => $_POST['txtClaveFirma'],
                "terceraFirma" => $_POST['txtTerceraFirma']
            );

            $respuesta = documentoReembolsoModelo::aprobar_documento_reembolso_modelo($data);

            if (isset($respuesta)) {

                if($respuesta->respuesta != "OK"){
                    return '<script>swal("", "'.$respuesta->respuesta.'", "error");</script>';
                }
                else{
                    $arrPath = explode("/", $pathArchivo);

                    $nuevoPath = "../".str_replace($arrPath[count($arrPath)-1], "", $respuesta->pathArchivo);

                    if (is_dir($nuevoPath)) {
                        chmod($nuevoPath, 0777);
                    } else {
                        mkdir($nuevoPath, 0777, true);
                        chmod($nuevoPath, 0777);
                    }
                    
                    //primero se elimina el archivo anterior para despues crear el nuevo
                    //eliminar el archivo anterior qe esta en $pathArchivo
                    //esto es por el tema de permisos, si no tiene el permiso adecuado no sobreescribe al archivo mas abajo.
                    //por eso primero se debe borrar el archivo antiguo para que se cree el nuevo archivo desde cero y con los permisos correctos
                    ////se respalda en los correos
                    //if(copy($pathArchivo, "/tmp/".$arrPath[count($arrPath)-1])){
                        //si se movio
                    //}
                    //no es necesario copiar el archivo a un temp, ya que se tiene el respando en los correos que se envia
                    unlink($pathArchivo);

                    //aqui se toma el nuevo path para crear el nuevo archivo
                    $output_file = "../".$respuesta->pathArchivo;

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
        } else {
            return '<script>swal("", "Seleccione el estado.", "warning");</script>';
        }
    }
    
    
    public function enviar_correo_justificacion_controlador() {

//        $urlDocRemb = $_POST['txtUrlDocReembolso'];
//        $nombreSistema = explode("/", $_SERVER["REQUEST_URI"])[1]; //de esta manera se puede obtener el contexto del sistema
//        $pathArchivo = ".." .explode($nombreSistema, $urlDocRemb)[1];
        $pathArchivo = "../" . $_POST['txtUrlDocReembolso'];
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
//echo $_FILES['txtArchivoJust']['type'];
        $fileP12 = file_get_contents($_FILES['txtArchivoJust']['tmp_name']);
        $archivoB64 = base64_encode($fileP12);


        $data = [
            'id' => $_POST['idReembJust'],
            'justificacionBase64' => $archivoB64,
            'tipoJustificacionBase64' => $_FILES['txtArchivoJust']['type'],
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
