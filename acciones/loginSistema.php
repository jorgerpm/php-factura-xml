<?php
if(is_file('./Utils/configUtil.php')){
    require_once './Utils/configUtil.php';
}
else{
    require_once '../Utils/configUtil.php';
}


$loginSist = new loginControlador();
$respuetsa = $loginSist->ingresar_sistema_controlador();
echo $respuetsa;
