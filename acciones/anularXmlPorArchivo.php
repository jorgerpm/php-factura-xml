<?php

if (is_file('./Utils/configUtil.php')) {
    require_once './Utils/configUtil.php';
} else {
    require_once '../Utils/configUtil.php';
}

if (isset($_SESSION['Usuario'])) {
    $contrl = new archivoXmlControlador();
    $respuesta = $contrl->anular_xmls_porarchivo_controlador();
    echo $respuesta;
}
else{
    echo '<script>window.location.replace("index");</script>';
}
