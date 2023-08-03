<?php
if(is_file('./Utils/configUtil.php')){
    require_once './Utils/configUtil.php';
}
else{
    require_once '../Utils/configUtil.php';
}

if(isset($_SESSION['Usuario'])){

    $control = new firmaDigitalControlador();
    $respuesta = $control->solicitar_clave_firma_controlador();
    echo $respuesta;

}else{
    echo 'window.location.replace("index");';
}



