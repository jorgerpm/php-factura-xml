<?php

if (is_file('./Utils/configUtil.php')) {
    require_once './Utils/configUtil.php';
} else {
    require_once '../Utils/configUtil.php';
}

if (isset($_SESSION['Usuario'])) {
    
    if(isset($_POST['listaArchivosXml'])){
//        require_once("../ZipArchive.php");
        $zip = new ZipArchive();
        $filename = "Archivos_subidos/ZIP/archivosXmlZip".date('Y-m-d')."_".strtotime(date('Y-m-d H:i:s')).".zip";
            
        if ($zip->open("../".$filename, ZipArchive::CREATE) !== TRUE) {
            exit("No se puede abrir el archivo zip <$filename>\n");
        }
            
        foreach ($_POST['listaArchivosXml'] as $urlArchivo){
            //echo $urlArchivo;
            
            $arr = explode("/", $urlArchivo);
            $nombreArchivo = $arr[count($arr)-1];
            
            $zip->addFile("../".$urlArchivo, $nombreArchivo);
        }
        
//        echo "numficheros: " . $zip->numFiles . "\n";
//        echo "estado:" . $zip->status . "\n";
        $zip->close();
        
        echo $_SESSION["URL_SISTEMA"] . $filename;
    }
    
}
else{
    echo '<script>window.location.replace("index");</script>';
}

