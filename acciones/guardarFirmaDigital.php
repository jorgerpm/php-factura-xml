<?php
if(is_file('./Utils/configUtil.php')){
    require_once './Utils/configUtil.php';
}
else{
    require_once '../Utils/configUtil.php';
}

$control = new firmaDigitalControlador();
$respuesta = $control->guardar_firma_digital_controlador();
echo $respuesta . "<script>$('#modalFirmaDigital').modal('hide');</script>";
