<?php

class razonRechazoModelo extends serviciosWebModelo {
    
    protected function guardar_razon_rechazo_modelo($datos){
        $respuesta = self::invocarPost('razonRechazo/guardarRazonRechazo', $datos);
        return $respuesta;
    }
    
    
    protected function listar_razones_rechazo_modelo() {
        $array = [];
        $listaParametros = self::invocarGet('razonRechazo/listarRazonesRechazo', $array);
        return $listaParametros;
    }
    
}