<?php
if(is_file('./Utils/configUtil.php')){
    require_once './Utils/configUtil.php';
}
else{
    require_once '../Utils/configUtil.php';
}


$estadoControlador = new estadoControlador();
$listaEstados = $estadoControlador->listar_estados();