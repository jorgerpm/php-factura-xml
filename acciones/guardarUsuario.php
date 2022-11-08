<?php
if(is_file('./Utils/configUtil.php')){
    require_once './Utils/configUtil.php';
}
else{
    require_once '../Utils/configUtil.php';
}

$usuarioCont = new usuarioControlador();
$respuesta = $usuarioCont->guardar_usuario_controlador();
echo $respuesta;