<?php
if(is_file('./Utils/configUtil.php')){
    require_once './Utils/configUtil.php';
}
else{
    require_once '../Utils/configUtil.php';
}


if(isset($_SESSION['Usuario'])){
    //$val = json_encode($_POST["listaDetalles"]);
    //echo $val;
    //$ff = json_decode($val);
    $control = new facturaFisicaControlador();
    $respuesta = $control->guardar_factura_fisica_controlador();
    echo $respuesta;
    
    
}
else{
    echo '<script>window.location.replace("index")</script>';
}

