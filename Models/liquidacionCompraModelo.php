<?php

class liquidacionCompraModelo extends serviciosWebModelo {
    
    protected function cargar_liquidacioncompra_modelo($data){
        $respuesta = self::invocarPost('liquidacioncompra/cargarLiquidacion', $data);
        return $respuesta;
    }
    
    
    protected function firmar_liquidacioncompra_modelo($data){
        $respuesta = self::invocarPost('liquidacioncompra/firmarLiquidacion', $data);
        return $respuesta;
    }
    
}