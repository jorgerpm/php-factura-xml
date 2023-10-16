<?php

class cargarXmlModelo extends serviciosWebModelo {

    protected function cargar_archivo_modelo($data) {
        $respp = serviciosWebModelo::invocarPost('archivoXml/guardarXmlDB', $data);
        return $respp;
    }
    
    public function cargar_archivo_sri_modelo($data) {
        $respp = serviciosWebModelo::invocarPostConTiempo('archivoXml/cargarArchivoSri', $data, 480);
        return $respp;
    }
    
    protected function eliminar_xmlcargado_modelo($idXml){
        $array = [];
        $respuesta = self::invocarGet('archivoXml/eliminarXmlCargado?idXml='.$idXml, $array);
        return $respuesta;
    }
    
    protected function guardar_miscelaneo_modelo($data){
        $respuesta = self::invocarPost('archivoXml/guardarMiscelaneo', $data);
        return $respuesta;
    }

}
