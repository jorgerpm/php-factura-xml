<?php
if(is_file('./Utils/configUtil.php')){
    require_once './Utils/configUtil.php';
}
else{
    require_once '../Utils/configUtil.php';
}

$parametroControlador = new parametroControlador();
$listaParametros = $parametroControlador->listarParametros();