<?php

class empresaModelo extends serviciosWebModelo {
    
    protected function guardar_empresa_modelo($datos){
        $respuesta = self::invocarPost('empresa/guardarEmpresa', $datos);
        return $respuesta;
    }
    
    
    protected function listar_empresas_modelo() {
        $array = [];
        $listaParametros = self::invocarGet('empresa/listarEmpresas', $array);
        return $listaParametros;
    }
    
}