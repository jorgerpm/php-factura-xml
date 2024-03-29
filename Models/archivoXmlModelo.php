<?php

class archivoXmlModelo extends serviciosWebModelo {
    
    public function guardar_estado_modelo($datos){
        $respuesta = self::invocarPost('archivoXml/listarArchivosXml', $datos);
        return $respuesta;
    }
    
    
    public function listar_archivos($fechaIni, $fechaFin, $idUser, $claveAcceso, $ruc, $tipoDoc, $desde, $hasta, 
            $estadoSistema, $seleccionados, $conDetalles, $idReembolso, $exportado, $rucEmpresa, $clavesSeleccionadas) {
//        $dateIni = strtotime($fechaIni) * 1000;
//        $dateFin = strtotime($fechaFin) * 1000;
//        print_r($clavesSeleccionadas);
        $array = array(
            "fechaInicio" => $fechaIni,
            "fechaFinal" => $fechaFin,
            "idUsuarioCarga" => $idUser,
            "claveAcceso" => trim($claveAcceso),
            "ruc" => urlencode($ruc),
            "tipoDocumento" => $tipoDoc,
            "estadoSistema" => $estadoSistema,
            "desde" => $desde,
            "hasta" => $hasta,
            "seleccionados" => $seleccionados,
            "conDetalles" => $conDetalles,
            "idReembolso" => $idReembolso,
            "exportado" => $exportado,
            "rucEmpresa" => $rucEmpresa,
            "idRolSesion" => $_SESSION['Rol']->id,
            "clavesSeleccionadas" => $clavesSeleccionadas,
        );
        
        $listaArchivos = self::invocarPost('archivoXml/listarPorFecha', $array);
//        $listaArchivos = self::invocarGet('archivoXml/listarPorFecha?fechaInicio='.$fechaIni.'&fechaFinal='.$fechaFin.'&idUsuarioCarga='.$idUser.
//                '&claveacceso='.trim($claveAcceso).'&ruc='.urlencode($ruc).'&tipodoc='.$tipoDoc.
//                '&estadoSistema='.$estadoSistema.'&desde='.$desde.'&hasta='.$hasta."&seleccionados=".$seleccionados.
//                "&conDetalles=".$conDetalles."&idReembolso=".$idReembolso."&exportado=".$exportado."&rucEmpresa=".$rucEmpresa
//                ."&idRolSesion=".$_SESSION['Rol']->id, $array);
        return $listaArchivos;
    }
    
    
    protected function anular_xmls_modelo($data){
        $respuesta = self::invocarPost('archivoXml/anularArchivosXml', $data);
        return $respuesta;
    }
    
    
    protected function anular_xmls_porarchivo_modelo($data){
        $respuesta = self::invocarPost('archivoXml/anularXmlPorArchivo', $data);
        return $respuesta;
    }
}