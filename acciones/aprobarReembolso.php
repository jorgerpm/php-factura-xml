<?php

if (is_file('./Utils/configUtil.php')) {
    require_once './Utils/configUtil.php';
} else {
    require_once '../Utils/configUtil.php';
}

if (isset($_SESSION['Usuario'])) {
    $control = new documentoReembolsoControlador();
    $respuesta = $control->aprobar_documento_reembolso_controlador();
    echo $respuesta;
}
else{
    echo '<script>window.location.replace("index");</script>';
}