<?php

class estadoControlador extends estadoModelo {

    public function listar_estados() {
        $listarEstados = estadoModelo::listar_estados();
        if(!isset($listarEstados)) {
            $listarEstados = [];
        }
        return $listarEstados;
    }

    //aqui la logica
    public function guardar_estado_controlador() {
        $idEstado = $_POST['idEstado'];
        $txtNombre = $_POST['txtNombre'];

        if (isset($txtNombre)) {
            $datos = [
                "id" => $idEstado,
                "nombre" => mb_strtoupper($txtNombre, 'utf-8'),
            ];

            $respuesta = estadoModelo::guardar_estado_modelo($datos);

            if ($respuesta->id > 0) {
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
