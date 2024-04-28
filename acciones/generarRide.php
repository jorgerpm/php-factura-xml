<?php

if (is_file('./Utils/configUtil.php')) {
    require_once './Utils/configUtil.php';
} else {
    require_once '../Utils/configUtil.php';
}

if (isset($_SESSION['Usuario'])) {
    
    $cont = new reporteControlador();
    $resp = $cont->generarRideXml_controller();
            
    echo json_encode($resp);
    
}
else{
    echo '<script>window.location.replace("index");</script>';
}