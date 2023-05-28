<?php

if (is_file('./Utils/configUtil.php')) {
    require_once './Utils/configUtil.php';
} else {
    require_once '../Utils/configUtil.php';
}

if (isset($_SESSION['Usuario'])) {
    $control = new documentoReembolsoControlador();
    $respuesta = $control->guardar_datos_contabilidad_controlador();
    echo $respuesta;
}
else{
    header("Location: index");
    echo '<script>window.location.replace("index");</script>';
}

