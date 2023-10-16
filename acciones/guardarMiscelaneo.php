<?php

if (is_file('./Utils/configUtil.php')) {
    require_once './Utils/configUtil.php';
} else {
    require_once '../Utils/configUtil.php';
}

if (isset($_SESSION['Usuario'])) {
//    echo $_POST["idXml"];
    $contrl = new cargarXmlControlador();
    $respuesta = $contrl->guardar_miscelaneo_controlador();
    echo $respuesta . "<script>$('#modalFormMiscelaneo').modal('hide');</script>";
}
else{
    echo '<script>window.location.replace("index");</script>';
}