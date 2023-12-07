<?php

if (is_file('./Utils/configUtil.php')) {
    require_once './Utils/configUtil.php';
} else {
    require_once '../Utils/configUtil.php';
}

if (isset($_SESSION['Usuario'])) {
    $control = new liquidacionCompraControlador();
    $respuesta = $control->firmar_liquidacioncompra_controlador();
    echo $respuesta;
}
else{
    echo '<script>window.location.replace("index");</script>';
}