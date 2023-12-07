<?php

class rolControlador extends rolModelo {

    public function listarRoles() {
        $listaRoles = rolModelo::listar_roles();
        if(!isset($listaRoles)) {
            $listaRoles = [];
        }
        return $listaRoles;
    }

    //aqui la logica
    public function guardar_rol_controlador() {
        $idRol = $_POST['idRol'];
        $txtNombre = $_POST['txtNombre'];
        $chkPrincipal = isset($_POST['chkPrincipal']) ? true : false;
//        $chkPrincipal = ($chkPrincipal == null) ? false : true;
        $listStatus = $_POST['listStatus'];

        if (isset($txtNombre) && isset($listStatus)) {
            $datos = [
                "id" => $idRol,
                "nombre" => mb_strtoupper($txtNombre, 'utf-8'),
                "principal" => $chkPrincipal,
                "idEstado" => $listStatus,
                "autorizador" => (isset($_POST['chkAutorizador']) ? true : false),
                
                "bFactura" => (isset($_POST['bFactura']) ? true : false),
                "bRetencion" => (isset($_POST['bRetencion']) ? true : false),
                "bNotaCredito" => (isset($_POST['bNotaCredito']) ? true : false),
                "bNotaDebito" => (isset($_POST['bNotaDebito']) ? true : false),
                "bGuiaRemision" => (isset($_POST['bGuiaRemision']) ? true : false),
                "datosContable" => (isset($_POST['chkDatosContable']) ? true : false),
                "idUsuarioModifica" => $_SESSION["Usuario"]->id,
                "listaIdEmpresas" => $_POST["txtListaEmpresas"],
                "cargaliquidacion" => (isset($_POST['chkCargaLiquidacion']) ? true : false),
            ];

            $respuesta = rolModelo::guardar_rol_modelo($datos);

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

    public function buscar_rol_porId_controlador($idRol) {
        $rolDto = rolModelo::buscar_rol_porId_modelo($idRol);
        return $rolDto;
    }
}
