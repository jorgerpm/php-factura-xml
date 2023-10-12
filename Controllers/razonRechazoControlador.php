<?php

class razonRechazoControlador extends razonRechazoModelo {

    public function listar_razones_rechazo_controlador() {

        $listaParametros = razonRechazoModelo::listar_razones_rechazo_modelo();
        if(!isset($listaParametros)) {
            $listaParametros = [];
        }
        return $listaParametros;
    }

    
    public function guardar_razon_rechazo_controlador() {
        $idRazon = $_POST['idRazon'];
        $txtRazon = $_POST['txtRazon'];
        $cbxEstado = $_POST['cbxListaEstado'];

        if (isset($txtRazon) && isset($cbxEstado)) {
            $datos = [
                "id" => $idRazon,
                "razon" => mb_strtoupper($txtRazon, 'utf-8'),
                "idEstado" => mb_strtoupper($cbxEstado, 'utf-8'),
                "idUsuarioModifica"=> $_SESSION['Usuario']->id,
            ];

            $respuesta = razonRechazoModelo::guardar_razon_rechazo_modelo($datos);

            if (isset($respuesta) && $respuesta->id > 0) {
                return '<script>swal("", "Datos almacenados correctamente", "success")
                    .then((value) => {
                        $(`#btnBuscar`).click();
                    });</script>';
            } else {
                return '<script>swal("", "Error al almacenar los datos.", "error");</script>';
            }
            
        } else {
            return '<script>swal("", "Complete los campos requeridos del formulario.", "error");</script>';
        }
    }
    

}
