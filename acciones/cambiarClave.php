<?php
if(is_file('./Utils/configUtil.php')){
    require_once './Utils/configUtil.php';
}
else{
    require_once '../Utils/configUtil.php';
}

$usuarioControlador = new usuarioControlador();
$respuesta = $usuarioControlador->cambiar_clave();