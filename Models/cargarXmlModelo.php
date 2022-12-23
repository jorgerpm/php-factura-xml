<?php

class cargarXmlModelo extends serviciosWebModelo {

    protected function cargar_archivo_modelo($data) {
        $respp = serviciosWebModelo::invocarPost('archivoXml/guardarXmlDB', $data);
        return $respp;
    }

}
