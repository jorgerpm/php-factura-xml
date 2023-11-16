<?php

class empresaControlador extends empresaModelo {

    public function listar_empresas_controlador() {

        $listaParametros = empresaModelo::listar_empresas_modelo();
        if(!isset($listaParametros)) {
            $listaParametros = [];
        }
        return $listaParametros;
    }

    
    public function guardar_empresa_controlador() {
        $idEmpresa = $_POST['idEmpresa'];
        $txtRuc = $_POST['txtRuc'];
        $txtRazonSocial = $_POST['txtRazonSocial'];
        $cbxEstado = $_POST['cbxListaEstado'];

        if (isset($txtRuc) && isset($txtRazonSocial) && isset($cbxEstado)) {
            $datos = [
                "id" => $idEmpresa,
                "ruc" => $txtRuc,
                "razonSocial" => mb_strtoupper($txtRazonSocial, 'utf-8'),
                
                "nombreComercial" => isset($_POST['txtNombreComercial']) ? mb_strtoupper($_POST['txtNombreComercial'], 'utf-8') : null,
                "direccion" => isset($_POST['txtDireccion']) ? mb_strtoupper($_POST['txtDireccion'], 'utf-8') : null,
                "telefono" => isset($_POST['txtTelefono']) ? mb_strtoupper($_POST['txtTelefono'], 'utf-8') : null,
                "email" => isset($_POST['txtEmail']) ? mb_strtolower($_POST['txtEmail'], 'utf-8') : null,
                
                "idEstado" => mb_strtoupper($cbxEstado, 'utf-8'),
                "idUsuarioModifica"=> $_SESSION['Usuario']->id,
            ];

            $respuesta = empresaModelo::guardar_empresa_modelo($datos);

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

    public function listar_empresas_rol_controlador() {

        $listaEmp = empresaModelo::listar_empresas_rol_modelo($_SESSION["Rol"]->id);
        if(!isset($listaEmp)) {
            $listaEmp = [];
        }
        return $listaEmp;
    }    

}
