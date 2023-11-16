<?php

class razonRechazoModelo extends serviciosWebModelo {
    
    protected function guardar_razon_rechazo_modelo($datos){
        $respuesta = self::invocarPost('razonRechazo/guardarRazonRechazo', $datos);
        return $respuesta;
    }
    
    
    protected function listar_razones_rechazo_modelo($estado) {
        $array = [];
        $listaParametros = self::invocarGet('razonRechazo/listarRazonesRechazo?estado='.$estado, $array);
        return $listaParametros;
    }
    
}