<?php
class firmaDigitalModelo extends serviciosWebModelo {
    
    protected function guardar_firma_digital_modelo($datos){
        $respuesta = self::invocarPost('firmadigital/guardarFirmaDigital', $datos);
        return $respuesta;
    }
    
    
    protected function listar_firmas_modelo($idUsuario, $idRol) {
        $array = [];
        $listaFirmas = self::invocarGet('firmadigital/listarFirmas?idUsuario='.$idUsuario.'&idRol='.$idRol, $array);
        return $listaFirmas;
    }
    
    protected function solicitar_clave_firma_modelo($idUsuario){
        $array = [];
        $respuesta = self::invocarGet('firmadigital/solicitarClaveFirma?idUsuario='.$idUsuario, $array);
        return $respuesta;
    }
}