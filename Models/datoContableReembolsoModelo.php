<?php

class datoContableReembolsoModelo extends serviciosWebModelo {
    
    protected function guardar_datos_contabilidad_modelo($data){
        $respuesta = self::invocarPost('datocontablereembolso/guardarDatosContabilidad', $data);
        return $respuesta;
    }

    protected function buscar_dato_contable_modelo($idReembolso){
        $data = [];
        $respuesta = self::invocarGet('datocontablereembolso/buscarDatoContableReembolso?idReembolso='.$idReembolso, $data);
        return $respuesta;
    }
}