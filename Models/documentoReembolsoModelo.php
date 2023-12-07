<?php

class documentoReembolsoModelo extends serviciosWebModelo {
    
    protected function guardar_estado_modelo($datos){
        $respuesta = self::invocarPost('documentoreembolsos/listarArchivosXml', $datos);
        return $respuesta;
    }
    
    
    protected function listar_documentos_modelo($fechaIni, $fechaFin, $idUser, $estadoSistema, $desde, $hasta,
            $numeroRC, $tipoReembolso, $numeroReembolso, $numeroLC) {
//        $dateIni = strtotime($fechaIni) * 1000;
//        $dateFin = strtotime($fechaFin) * 1000;
        $array = [];
        $listaArchivos = self::invocarGet('documentoreembolsos/listarDocumentos?fechaInicio='.$fechaIni.'&fechaFinal='.$fechaFin.'&idUsuarioCarga='.$idUser.
                '&estadoSistema='.$estadoSistema.'&desde='.$desde.'&hasta='.$hasta."&numeroRC=".$numeroRC."&tipoReembolso=".$tipoReembolso.
                '&numeroReembolso='.$numeroReembolso.'&numeroLC='.$numeroLC, $array);
        return $listaArchivos;
    }
    
    
    protected function aprobar_documento_reembolso_modelo($data){
        $respuesta = self::invocarPost('documentoreembolsos/aprobarDocumentoReembolsos', $data);
        return $respuesta;
    }
    
    protected function enviar_correo_justificacion_modelo($data){
        $respuesta = self::invocarPost('documentoreembolsos/enviarCorreoJustificacion', $data);
        return $respuesta;
    }
    
    protected function cargar_justificacion_modelo($data){
        $respuesta = self::invocarPost('documentoreembolsos/cargarJustificacion', $data);
        return $respuesta;
    }
    
}