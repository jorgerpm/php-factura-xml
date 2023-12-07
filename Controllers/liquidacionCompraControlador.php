<?php

class liquidacionCompraControlador extends liquidacionCompraModelo {
    
    public function cargar_liquidacioncompra_controlador() {
        //$fileP12 = file_get_contents($_FILES['txtArchivoLQ']['tmp_name']);
        $extFile = pathinfo($_FILES['txtArchivoLQ']['name'], PATHINFO_EXTENSION);
        
        if($extFile == "pdf"){
            
            $nuevoPath = "../Archivos_subidos/liquidacioncompra/";
                    
            if (is_dir($nuevoPath)) {
                chmod($nuevoPath, 0777);
            } else {
                mkdir($nuevoPath, 0777, true);
                chmod($nuevoPath, 0777);
            }

            $path = "Archivos_subidos/liquidacioncompra/".$_POST['numeroReembolsoLC'] . "." . $extFile;
                    //$_FILES['txtArchivoLQ']['type'];

            if (move_uploaded_file($_FILES['txtArchivoLQ']['tmp_name'], "../".$path)) { //Cargar archivos

                $data = [
                    'idReembolso' => $_POST['idReembLQ'],
                    'numero' => $_POST['numeroLC'],
                    'pathArchivo' => $path,
                    'estado' => "PENDIENTE",
                    'idUsuarioModifica' => $_SESSION['Usuario']->id,
                ];

                $respuesta = liquidacionCompraModelo::cargar_liquidacioncompra_modelo($data);

                if (isset($respuesta) && $respuesta->respuesta == "OK") {
                    return "<script>swal('','Archivo cargado correctamente.','info')
                        .then((value) => {
                                    $(`#btnSearch`).click();
                                });</script>";
                }
                else if(isset($respuesta)){
                    //eliimnar el archivo
                    unlink("../".$path);
                    return "<script>swal('','Error: ".$respuesta->respuesta."','error');</script>";
                }
                else{
                    unlink("../".$path);
                    return "<script>swal('','Error al cargar el archivo y al enviar el correo.','error');</script>";
                }

            }
            else{
                return "<script>swal('','No se pudo guardar el archivo en disco.','error');</script>";
            }
        }else{
            return "<script>swal('','Solo se puede cargar archivos de tipo PDF.','warning');</script>";
        }
        
    }
    
    
    public function firmar_liquidacioncompra_controlador() {
        
        //aqui se necesita el archivo en base64.
        $pathArchivo = "../". $_POST['txtUrlLiquidacion']; 
        
        if(is_file($pathArchivo)){

            $ifp = file_get_contents($pathArchivo);
            $fileBase64 = base64_encode($ifp);

            $data = array(
                "idReembolso" => $_POST['txtIdReembs'],
                "archivoBase64" => $fileBase64,
                "idUsuarioModifica" => $_SESSION['Usuario']->id,
                "claveFirma" => $_POST['txtClaveFirmaLC'],
            );

            $respuesta = liquidacionCompraModelo::firmar_liquidacioncompra_modelo($data);

            if (isset($respuesta)) {

                if($respuesta->respuesta != "OK"){
                    return '<script>swal("", "'.$respuesta->respuesta.'", "error");</script>';
                }
                else{
                    
                    unlink($pathArchivo);

                    //aqui se toma el nuevo path para crear el nuevo archivo
                    $output_file = $pathArchivo;

                    $ifp = fopen($output_file, 'wb' );
                    fwrite( $ifp, base64_decode( $respuesta->archivoBase64 ) );
                    fclose( $ifp );

                    return '<script>swal("", "Datos almacenados correctamente", "success")
                            .then((value) => {
                                $(`#btnSearch`).click();
                            });</script>';

                }
            } else {
                return '<script>swal("", "Error al firmar los documentos.", "error");</script>';
            }
        } else {
            return '<script>swal("", "No existe el archivo en '.$pathArchivo.'.", "warning");</script>';
        }
    }
    
}
