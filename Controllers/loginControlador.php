<?php

class loginControlador extends loginModelo {

    public function ingresar_sistema_controlador() {
        if (isset($_POST['usuario']) && isset($_POST['clave'])) {

            $array = [
                'usuario' => $_POST['usuario'],
                'clave' => $_POST['clave']
            ];

            $respuesta = loginModelo::ingresar_sistema_modelo($array);
            
            if (isset($respuesta) && $respuesta->id > 0) {
                //se envia a buscar el rol
                $rolControl = new rolControlador();
                $rolDto = $rolControl->buscar_rol_porId_controlador($respuesta->idRol);
                //se guarda en sesion el rol
                $_SESSION['Rol'] = $rolDto;
                
                $_SESSION['Usuario'] = $respuesta;
                
                $_SESSION['tiempo'] = time();
                
                return '<script>window.location.href = "home"</script>';
            } elseif (isset($respuesta)) {
//                print_r($respuesta);
                unset($_SESSION['Usuario']); //destruye la sesión
                if($respuesta->respuesta != 'OK'){
                    return '<script>swal("", "'.$respuesta->respuesta.'", "warning");</script>';
                }
                else{
                    return '<script>swal("", "Usuario y clave incorrectas.", "warning");</script>';
                }
            } else {
                return '<script>swal("", "No existe conexion a la base de datos.", "error");</script>';
            }
        } else {
            return '<script>swal("", "Los datos son requeridos.", "warning");</script>';
        }
    }

}
