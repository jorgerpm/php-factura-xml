<?php

class firmaDigitalControlador extends firmaDigitalModelo {

    public function listarFirmas() {
        $listaFirmas = firmaDigitalModelo::listar_firmas_modelo($_SESSION["Usuario"]->id, $_SESSION["Rol"]->id);
        if(!isset($listaFirmas)) {
            $listaFirmas = [];
        }
        return $listaFirmas;
    }

    //aqui la logica
    public function guardar_firma_digital_controlador() {
        $idFirma = $_POST['idFirmaDigital'];
//        $txtNombre = $_POST['txtArchivo'];
//        $txtClave = $_POST['txtClave'];
        $txtFecha = $_POST['txtFecha'];
        $cbxListaEstado = $_POST['cbxListaEstado'];

        
        
        if (isset($txtFecha) && $txtFecha != null && /*isset($txtClave) &&*/ isset($cbxListaEstado)) {
            
            //echo $_FILES["txtArchivo"]["name"];
            
            $fileP12 = file_get_contents($_FILES['txtArchivo']['tmp_name']);
            $archivoB64 = base64_encode($fileP12);
            
            //echo $archivoB64;
            
            
            $datos = [
                "id" => $idFirma,
                "archivo" => $archivoB64,
//                "clave" => $txtClave,
                "fechaCaducaLong" => strtotime($txtFecha) * 1000,
                "idEstado" => mb_strtoupper($cbxListaEstado, 'utf-8'),
                "idUsuario" => isset($_POST["cbxListUser"]) ? $_POST["cbxListUser"] : $_SESSION['Usuario']->id,
                "tipoFirma" => $_POST['txtTipoFirma'],
            ];

            $respuesta = firmaDigitalModelo::guardar_firma_digital_modelo($datos);

            if (isset($respuesta) && $respuesta->id > 0) {
                return '<script>swal("", "Datos almacenados correctamente", "success")
                    .then((value) => {
                        $(`#btnBuscar`).click();
                    });</script>';
            } else {
                return '<script>swal("", "Error al almacenar los datos.", "error");</script>';
            }
            
        } elseif($txtFecha == null || $txtFecha == "") { 
            return '<script>swal("", "No existe datos en la fecha de la firma. Primero debe validar la firma.", "warning");</script>';
        }else {
            return '<script>swal("", "Complete los campos requeridos del formulario.", "warning");</script>';
        }
    }
    
    public function solicitar_clave_firma_controlador(){
        
        $respuesta = firmaDigitalModelo::solicitar_clave_firma_modelo($_SESSION['Usuario']->id);
        
        return $respuesta;
    }
    
    public function validar_firma_nueva_controlador() {

        if($_FILES['txtArchivo']['size'] > 0 && isset($_POST['txtClave'])){
        
            
            $fileP12 = file_get_contents($_FILES['txtArchivo']['tmp_name']);
            $archivoB64 = base64_encode($fileP12);
            
            $datos = [
                "archivo" => $archivoB64,
                "clave" => $_POST['txtClave'],
            ];

            $respuesta = firmaDigitalModelo::validar_firma_nueva_modelo($datos);

            if (isset($respuesta) && $respuesta->respuesta == "OK") {
                return json_encode($respuesta);
            } elseif(isset($respuesta)) {
                return '<script>swal("", "Error al validar la firma. '.$respuesta->respuesta.'", "error");</script>';
            }
            
        } else {
            return '<script>swal("", "Debe seleccionar el archivo .p12 y también ingresar la clave de la firma.", "warning");</script>';
        }
    }

}