<?php

class tipoReembolsoModelo extends serviciosWebModelo {
    
    protected function guardar_tiporeembolso_modelo($datos){
        $respuesta = self::invocarPost('tipoReembolso/guardarTipoReembolso', $datos);
        return $respuesta;
    }
    
    
    protected function listar_tiporeembolso_modelo($esPrincipal) {
        $array = [];
        $lista = self::invocarGet('tipoReembolso/listarTipoReembolso?esPrincipal='.$esPrincipal, $array);
        return $lista;
    }
    
}