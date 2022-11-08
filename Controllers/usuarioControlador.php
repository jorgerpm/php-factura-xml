<?php

class usuarioControlador extends usuarioModelo {

    public function listarUsuarios() {
        $listaUsuarios = usuarioModelo::listar_usuarios();
        if (!isset($listaUsuarios)) {
            $listaUsuarios = [];
        }
        return $listaUsuarios;
    }

    public function cambiar_clave() {
        $id = $_SESSION['Usuario']->id;
        $txtNombre = $_SESSION['Usuario']->nombre;
        $txtUsuario = $_SESSION['Usuario']->usuario;
        $claveActual = $_SESSION['Usuario']->clave;
        $txtCorreo = $_SESSION['Usuario']->correo;
        $cbxListaRol = $_SESSION['Usuario']->idRol;
        $cbxListaEstado = $_SESSION['Usuario']->idEstado;

        $txtClaveActual = $_POST['txtClaveActual'];
        $txtClaveNueva = $_POST['txtClaveNueva'];
        $txtRepetirClave = $_POST['txtRepetirClave'];

        if ($txtClaveActual == $claveActual) {
            if ($txtClaveNueva == $txtRepetirClave) {
                $datos = [
                    "id" => $id,
                    "nombre" => $txtNombre,
                    "usuario" => $txtUsuario,
                    "clave" => md5($txtClaveNueva),
                    "correo" => $txtCorreo,
                    "idEstado" => $cbxListaEstado,
                    "idRol" => $cbxListaRol
                ];

                $respuesta = usuarioModelo::guardar_usuario_modelo($datos);

                echo '<script>swal("", "Contraseña actualizada correctamente", "success")
                    .then((value) => {
                        window.location.href="logout";
                    });</script>';
            } else {
                echo '<script>swal("", "Las nuevas contraseñas no coinciden", "error");</script>';
            }
        } else {
            echo '<script>swal("", "Las contraseña ingresada no coincide con la registrada", "error");</script>';
        }
    }

    //aqui la logica
    public function guardar_usuario_controlador() {
        $id = $_POST['idUsuario'];
        $txtNombre = $_POST['txtNombre'];
        $txtUsuario = $_POST['txtUsuario'];
        $txtClave = $_POST['txtClave'];
        $txtClaveOriginal = $_POST['txtClaveAux'];
        $txtCorreo = $_POST['txtCorreo'];
        $cbxListaRol = $_POST['cbxListaRol'];
        $cbxListaEstado = $_POST['cbxListaEstado'];
        
        $nuevaClave = $txtClaveOriginal;
        
        if($txtClave != $txtClaveOriginal) {
            $nuevaClave = md5($txtClave);
        }
        
        if (isset($txtNombre) && isset($txtUsuario) && isset($txtClave) && isset($txtCorreo) && isset($cbxListaRol) && isset($cbxListaEstado)) {
            $datos = [
                "id" => $id,
                "nombre" => strtoupper($txtNombre),
                "usuario" => $txtUsuario,
                "clave" => $nuevaClave,
                "correo" => $txtCorreo,
                "idEstado" => $cbxListaEstado,
                "idRol" => $cbxListaRol
            ];

            $respuesta = usuarioModelo::guardar_usuario_modelo($datos);

            if ($respuesta->id > 0) {
                return '<script>swal("", "Datos almacenados correctamente", "success")
                    .then((value) => {
                        $(`#btnBuscar`).click();
                    });
                    $(`#modalFormUsuario`).modal("hide");
                    </script>';
            } else {
                return '<script>swal("", "ERROR AL ALMACENAR LOS DATOS. '.$respuesta->respuesta.'", "error");</script>';
            }
        } else {
            return '<script>swal("", "Complete los campos requeridos del formulario.", "error");</script>';
        }
    }

    public function recuperar_clave_controlador() {
        $correo = $_POST['correo'];
        $respuesta = usuarioModelo::recuperar_clave_modelo($correo);
        if (isset($respuesta)) {
            if ($respuesta->respuesta == "ENVIO EXITOSO") {
                return '<script>swal("", "Se envió una nueva clave al correo ingresado.", "success");</script>';
            } elseif(isset($respuesta->respuesta)) {
                return '<script>swal("", " . Error en el envío del correo. . ", "error");</script>';
            }else{
                return '<script>swal("", "Error en el envío del correo.", "error");</script>';
            }
        } else {
            return '<script>swal("", "Error en el envío del correo.", "error");</script>';
        }
    }

}
