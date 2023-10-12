<?php

class parametroControlador extends parametroModelo {

    public function listarParametros() {
        $listaParametros = parametroModelo::listar_parametros();
        if(!isset($listaParametros)) {
            $listaParametros = [];
        }
        return $listaParametros;
    }

    //aqui la logica
    public function guardar_parametro_controlador() {
        $idParametro = $_POST['idParametro'];
        $txtNombre = $_POST['txtNombre'];
        $txtValor = $_POST['txtValor'];
        $cbxListaEstado = $_POST['cbxListaEstado'];

        if (isset($txtNombre) && isset($txtValor) && isset($cbxListaEstado)) {
            $datos = [
                "id" => $idParametro,
                "nombre" => mb_strtoupper($txtNombre, 'utf-8'),
                "valor" => $txtValor,
                "idEstado" => mb_strtoupper($cbxListaEstado, 'utf-8'),
                "idUsuarioModifica"=> $_SESSION['Usuario']->id,
            ];

            $respuesta = parametroModelo::guardar_parametro_modelo($datos);

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