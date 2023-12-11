<?php

if (is_file('./Utils/configUtil.php')) {
    require_once './Utils/configUtil.php';
} else {
    require_once '../Utils/configUtil.php';
}

if (isset($_SESSION['Usuario'])) {
    $carga = new cargarXmlControlador();
    $respueta = $carga->cargar_archivo_controlador();
    echo $respueta;
}
else{
    header("Location: index");
    echo '<script>window.location.replace("index");</script>';
}
