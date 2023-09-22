<?php
class usuarioModelo extends serviciosWebModelo {
    
    protected function guardar_usuario_modelo($datos){
        $respuesta = self::invocarPost('usuario/guardarUsuario', $datos);
        return $respuesta;
    }
    
    
    protected function listar_usuarios() {
        $array = [];
        $listaUsuarios = self::invocarGet('usuario/listarUsuarios', $array);
        return $listaUsuarios;
    }
    
    protected function recuperar_clave_modelo($correo){
        $array = [];
        $respuesta = self::invocarGet('usuario/recuperarClave?correo='.$correo, $array);
        return $respuesta;
    }
    
    
    protected function listar_usuarios_rol_modelo($idRol) {
        $array = [];
        $listaUsuarios = self::invocarGet('usuario/listarUsuariosPorRol?idRol='.$idRol, $array);
        return $listaUsuarios;
    }
    
    
    protected function cambiar_clave_modelo($datos){
        $respuesta = self::invocarPost('usuario/cambiarClave', $datos);
        return $respuesta;
    }
    
    protected function listar_usuarios_activos_modelo() {
        $array = [];
        $listaUsuarios = self::invocarGet('usuario/listarUsuariosActivos', $array);
        return $listaUsuarios;
    }
}