<?php
if(is_file('./Utils/configUtil.php')){
    require_once './Utils/configUtil.php';
}
else{
    require_once '../Utils/configUtil.php';
}

$contrl = new empresaControlador();
$respuesta = $contrl->guardar_empresa_controlador();
echo $respuesta . "<script>$('#modalFormEmpresa').modal('hide');</script>";
