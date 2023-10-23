<?php
if(is_file('./Utils/configUtil.php')){
    require_once './Utils/configUtil.php';
}
else{
    require_once '../Utils/configUtil.php';
}

$control = new firmaDigitalControlador();
$respuesta = $control->validar_firma_nueva_controlador();
print_r($respuesta);
