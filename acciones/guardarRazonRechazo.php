<?php
if(is_file('./Utils/configUtil.php')){
    require_once './Utils/configUtil.php';
}
else{
    require_once '../Utils/configUtil.php';
}

$contrl = new razonRechazoControlador();
$respuesta = $contrl->guardar_razon_rechazo_controlador();
echo $respuesta . "<script>$('#modalFormRazonRechazo').modal('hide');</script>";
