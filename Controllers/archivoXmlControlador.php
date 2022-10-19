<?php

class archivoXmlControlador extends archivoXmlModelo {

    public function listar_archivos_controlador($post, $regsPagina) {
        if(isset($post) && isset($post['dtFechaIni']) && isset($post['dtFechaFin'])){
            $respuesta = archivoXmlModelo::listar_archivos($post['dtFechaIni'], $post['dtFechaFin'], isset($post['listUsers']) ? $post['listUsers'] : null, $post['txtDesde'], $regsPagina);
        }
        else{
            $respuesta = archivoXmlModelo::listar_archivos(date("Y-m-d"), date("Y-m-d"), ($_SESSION['Rol']->principal == 0) ? $_SESSION['Usuario']->id : null, 0, $regsPagina);
        }
        
        if(!isset($respuesta)){
            $respuesta = [];
        }
        
        return $respuesta;
    }

    public function crear_columnas($respuesta) {
        

        $columns = [];
        array_push($columns, ['col' => 'Usuario', 'wid'=>'100px']);
        array_push($columns, ['col' => 'Fecha de emisión', 'wid'=>'100px']);
        array_push($columns, ['col' => 'Fecha de autorización', 'wid'=>'100px']);
        array_push($columns, ['col' => 'Estado', 'wid'=>'100px']);
        array_push($columns, ['col' => 'Número de autorización', 'wid'=>'100px']);
        array_push($columns, ['col' => 'Ambiente', 'wid'=>'100px']);

        $columnsAux = [];
        foreach ($respuesta as $respe){
            if(isset($respe->comprobante)){
                $listvarj = json_decode($respe->comprobante);
                $docum = null;
                if (isset($listvarj->factura)) {
                    $docum = $listvarj->factura;
                }

                if ($docum != null) {
                    foreach ($docum->infoTributaria as $key => $val) {
                        array_push($columnsAux, ['col' => $key, 'wid'=>'100px']);
                    }
                    foreach ($docum->infoFactura as $key => $val) {
                        if (!isset($val->pago) && !isset($val->totalImpuesto)) {
                            array_push($columnsAux, ['col' => $key, 'wid'=>'100px']);
                        }
                        elseif(isset($val->totalImpuesto)){
                            foreach ($val->totalImpuesto as $keyImp => $valImp) {
                                if(isset($valImp->codigoPorcentaje)){
                                    array_push($columnsAux, ['col' => 'baseImponible:'.$valImp->codigoPorcentaje, 'wid'=>'100px']);
                                }
                                elseif($keyImp == 'codigoPorcentaje'){
                                    array_push($columnsAux, ['col' => 'baseImponible:'.$valImp, 'wid'=>'100px']);
                                }
                            }
                        }
                    }
                }
            }
        }
        $ind = 0;
        foreach ($columnsAux as $col){
//            if($ind == 0){
//                array_push($columns, ['col' => $col['col'], 'wid'=>'100px']);
//            }
//            else{
                $coincide = false;
                foreach ($columns as $coll){
                    if($coll['col'] == $col['col']){
                        $coincide = true;
                        break;
                    }
                }
//            }
            if(!$coincide){
                array_push($columns, ['col' => $col['col'], 'wid'=>'100px']);
            }
            $ind++;
        }
        
        array_push($columns, ['col' => 'Tipo de documento', 'wid'=>'100px']);
        array_push($columns, ['col' => 'Proveedor', 'wid'=>'100px']);
        array_push($columns, ['col' => 'Url archivo xml', 'wid'=>'100px']);
        array_push($columns, ['col' => 'Url archivo RIDE', 'wid'=>'100px']);

        return $columns;
    }

}
