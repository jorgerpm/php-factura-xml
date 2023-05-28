<?php
class facturaFisicaModelo extends serviciosWebModelo {
    
    protected function guardar_factura_fisica_modelo($datos){
        $respuesta = self::invocarPost('facturafisica/guardarFacturaFisica', $datos);
        return $respuesta;
    }
    
}