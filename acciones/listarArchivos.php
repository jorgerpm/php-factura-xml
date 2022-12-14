<?php
if (is_file('./Utils/configUtil.php')) {
    require_once './Utils/configUtil.php';
} else {
    require_once '../Utils/configUtil.php';
}

$archiCont = new archivoXmlControlador();
$respuesta = $archiCont->listar_archivos_controlador($_POST, 10000);
$columns = $archiCont->crear_columnas($respuesta);

$csv = [];

$colus = "";
foreach ($columns as $cols){
    //array_push($colus, $cols['col']);
    $colus = $colus.$cols['col'].";";
}
$colus = $colus."~";

array_push($csv, $colus);




if (count($respuesta) > 0) {
    foreach ($respuesta as $listaArchivoXml) {
        $filas = [];
        array_push($filas, $listaArchivoXml->nombreUsuario);
        array_push($filas, date("d/m/Y", $listaArchivoXml->fechaEmision / 1000));
        array_push($filas, date("d/m/Y", $listaArchivoXml->fechaAutorizacion / 1000));
        array_push($filas, $listaArchivoXml->estado);
        array_push($filas, $listaArchivoXml->numeroAutorizacion);
        array_push($filas, $listaArchivoXml->ambiente);
        
        $listvarj = json_decode($listaArchivoXml->comprobante);

        $docum = null;
        if (isset($listvarj->factura)) {
            $docum = $listvarj->factura;
        }
        if ($docum != null) {
            $valores = [];

            for ($ind = 6; $ind < (count($columns) - 4); $ind++) {
                $coincide = false;
                foreach ($docum->infoTributaria as $key => $val) {
                    if ($columns[$ind]['col'] == $key) {
                        array_push($valores, $val);
                        $coincide = true;
                        break;
                    }
                }
                if ($coincide) {
                    
                } else {
                    foreach ($docum->infoFactura as $key => $val) {
                        if (!isset($val->pago) && !isset($val->totalImpuesto)) {
                            if ($columns[$ind]['col'] == $key) {
                                array_push($valores, $val);
                                $coincide = true;
                                break;
                            }
                        }
                    }
                    if ($coincide) {
                        
                    } else {
                        if(isset($docum->infoFactura->totalConImpuestos->totalImpuesto)){
                            $codP=-1;
                            foreach ($docum->infoFactura->totalConImpuestos->totalImpuesto as $keyImp => $valImp) {
                                if(isset($valImp->baseImponible)){
                                    if ($columns[$ind]['col'] == 'baseImponible codigoPorcentaje:'.$valImp->codigoPorcentaje) {
                                        array_push($valores, $valImp->baseImponible);
                                        $coincide = true;
                                       
                                    }
                                    if ($columns[$ind]['col'] == 'valor codigoPorcentaje:'.$valImp->codigoPorcentaje) {
                                        array_push($valores, $valImp->valor);
                                        $coincide = true;
                                    }
                                }
                                else {
                                    if($keyImp == 'codigoPorcentaje'){
                                        $codP = $valImp;
                                    }
                                    if($keyImp == 'baseImponible'){
                                        if ($columns[$ind]['col'] == 'baseImponible codigoPorcentaje:'.$codP) {
                                            array_push($valores, $valImp);
                                            $coincide = true;
                                        }
                                    }
                                    if($keyImp == 'valor'){
                                        if ($columns[$ind]['col'] == 'valor codigoPorcentaje:'.$codP) {
                                            array_push($valores, $valImp);
                                            $coincide = true;
                                        }
                                    }
                                }
                            }
                        }
                        if ($coincide) {

                        } else {
                            array_push($valores, '0');
                        }
                    }
                }
            }

            foreach ($valores as $vals) {
                
                array_push($filas, $vals);
                
            }
        }
        
        array_push($filas, $listaArchivoXml->tipoDocumento);
        array_push($filas, $listaArchivoXml->codigoJDProveedor);
        array_push($filas, $listaArchivoXml->urlArchivo . "/" . $listaArchivoXml->nombreArchivoXml);
        array_push($filas, ($listaArchivoXml->nombreArchivoPdf != null) ? $listaArchivoXml->urlArchivo . "/" . $listaArchivoXml->nombreArchivoPdf : '');
        

        //al final se agregar fila por fila
        $filAux="";
        foreach ($filas as $dd){
            $filAux = $filAux.$dd.";";
        }
        $filAux = $filAux."~";
        
        array_push($csv, $filAux);
    }
    
    //echo '<br>';
    print_r($csv);
//    echo json_encode($csv);
    //echo '<br>';
}

