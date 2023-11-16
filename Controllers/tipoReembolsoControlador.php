<?php

class tipoReembolsoControlador extends tipoReembolsoModelo {

    public function listar_tiporeembolso_controlador($esPrincipal) {

        $lista = tipoReembolsoModelo::listar_tiporeembolso_modelo($esPrincipal);
        if(!isset($lista)) {
            $lista = [];
        }
        return $lista;
    }

    
    public function guardar_tiporeembolso_controlador() {
        
        $txtSecuencial = $_POST['txtSecuencial'];
        $txtNomenclatura = $_POST['txtNomenclatura'];

        if (isset($txtSecuencial) && isset($txtNomenclatura)) {
            $datos = [
                "id" => $_POST['idTipoReembolso'],
                "tipo" => mb_strtoupper($_POST['txtTipo'], 'utf-8'),
                "secuencial" => $txtSecuencial,
                "nomenclatura" => mb_strtoupper($txtNomenclatura, 'utf-8'),
                "idUsuarioModifica"=> $_SESSION['Usuario']->id,
                "esPrincipal" => $_POST['txtEsPrincipal'],
            ];

            $respuesta = tipoReembolsoModelo::guardar_tiporeembolso_modelo($datos);

            if (isset($respuesta) && $respuesta->id > 0) {
                return '<script>swal("", "Datos almacenados correctamente", "success")
                    .then((value) => {
                        $(`#btnBuscar`).click();
                    });
                    $("#modalTipoReembolso").modal("hide");</script>';
            } else {
                return '<script>swal("", "Error al almacenar los datos.", "error");</script>';
            }
            
        } else {
            return '<script>swal("", "Complete los campos requeridos del formulario.", "error");</script>';
        }
    }

}
