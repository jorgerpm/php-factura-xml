<?php

date_default_timezone_set('America/Guayaquil');

session_start();
//este sirve para obtener la url que se pone en el internet
//esto forma de la siguiente manera
//http://ip:puerto/nombreSistema
$context = $_SERVER["CONTEXT_PREFIX"];
if($context == '' || $context == null){
	$context = "/".explode("/", $_SERVER["PHP_SELF"])[1];
}
$_SESSION['URL_SISTEMA'] = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"].$context."/";

//esta seccion es para verificar el tiempo de inacntividad en la pagina, 
//se controla con la sesion, si ya pasa el tiempo configurado se termina la session y
//se redirecciona a la pagina de login
if (isset($_SESSION['tiempo'])) {
//    echo "si existe...";
    $vida_session = time() - $_SESSION['tiempo'];
    
    if(is_file('./Utils/constantesUtil.php')){
        require_once './Utils/constantesUtil.php';
    }
    else{
        require_once '../Utils/constantesUtil.php';
    }
    
    if($vida_session > constantesUtil::$TIEMPO_SESION){
        //Removemos sesión.
        session_unset();
        //Destruimos sesión.
        session_destroy();              
        //Redirigimos pagina.
//        header("Location: index");        
        echo '<script>window.location.replace("index");</script>';
        
        exit();
    }
    else{
        $_SESSION['tiempo'] = time();
    }
    
}
else{
//    echo "no existe...";
}
//hasta aca el tiempo de session

spl_autoload_register(function($class) {
//    $parts = explode('_', $class);
//    $path = implode(DIRECTORY_SEPARATOR, $parts);
    if (strpos($class, "Controlador")) {
        $pathClass = 'Controllers/' . $class . '.php';
    } elseif (strpos($class, "Modelo")) {
        $pathClass = 'Models/' . $class . '.php';
    } elseif (strpos($class, "Util")) {
        $pathClass = 'Utils/' . $class . '.php';
    } else {
        $pathClass = $class . '.php';
    }

    if (is_file('./' . $pathClass)) {
        require_once './' . $pathClass;
    } else {
        require_once '../' . $pathClass;
    }
});
