<?php

if (is_file('./Utils/configUtil.php')) {
    require_once './Utils/configUtil.php';
} else {
    require_once '../Utils/configUtil.php';
}

if (isset($_SESSION['Usuario'])) {
    $contrl = new proveedorControlador();
    $respuesta = $contrl->buscar_proveedor_porruc_controlador();
    echo json_encode($respuesta);
}
else{
    echo '<script>window.location.replace("index");</script>';
}