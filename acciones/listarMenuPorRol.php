<?php
if(is_file('./Utils/configUtil.php')){
    require_once './Utils/configUtil.php';
}
else{
    require_once '../Utils/configUtil.php';
}

$idRolUsuario = $_SESSION['Usuario']->idRol;
$menuControlador = new menuControlador();
$listaMenuPorRol = $menuControlador->listarMenusPorRol($idRolUsuario);