<?php

class cargarXmlModelo extends serviciosWebModelo {

    protected function cargar_archivo_modelo($data) {
        $respp = serviciosWebModelo::invocarPost('archivoXml/guardarXmlDB', $data);
        return $respp;
    }
    
    public function cargar_archivo_sri_modelo($data) {
        $respp = serviciosWebModelo::invocarPost('archivoXml/cargarArchivoSri', $data);
        return $respp;
    }

}
