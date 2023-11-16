<?php

if (is_file('./Utils/configUtil.php')) {
    require_once './Utils/configUtil.php';
} else {
    require_once '../Utils/configUtil.php';
}

if (isset($_SESSION['Usuario'])) {
    $contrl = new tipoReembolsoControlador();
    $respuesta = $contrl->guardar_tiporeembolso_controlador();
    echo $respuesta;
}
else{
    echo '<script>window.location.replace("index");</script>';
}

