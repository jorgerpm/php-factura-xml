<?php

class generarTablaControlador {
    
    const COL_INI = 7;
//    const COL_FIN = 7;

    public function generarTabla($listvarj, $columns) {
        
        $COL_FIN = 7;
        
        if(isset($_POST['conDetalles']) && $_POST['conDetalles'] == true){
            $COL_FIN = 9;
        }

        $valores = [];

        $docum = null;
        if (isset($listvarj->factura)) {
            $docum = $listvarj->factura;
            $valores = $this->generarTablaFactura($docum, $columns, $COL_FIN);
        }
        if (isset($listvarj->comprobanteRetencion)) {
            $docum = $listvarj->comprobanteRetencion;
            $valores = $this->generarTablaRetencion($docum, $columns, $COL_FIN);
        }
        if (isset($listvarj->notaCredito)) {
            $docum = $listvarj->notaCredito;
            $valores = $this->generarTablaNotaCredito($docum, $columns, $COL_FIN);
        }


        return $valores;
    }

    private function generarTablaFactura($docum, $columns, $COL_FIN) {
        $valores = [];
        if ($docum != null) {
            for ($ind = self::COL_INI; $ind < (count($columns) - $COL_FIN); $ind++) {
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
                        //print_r($docum->infoFactura->totalConImpuestos->totalImpuesto);
                        if (isset($docum->infoFactura->totalConImpuestos->totalImpuesto)) {
                            $codP = -1;
                            foreach ($docum->infoFactura->totalConImpuestos->totalImpuesto as $keyImp => $valImp) {

                                if (isset($valImp->baseImponible)) {
                                    //$comprobar = array_search($valImp->baseImponible, $valores, false);
                                    //echo '{'.print_r($comprobar == false).'}';
                                    //if($comprobar == false){
                                    if ($columns[$ind]['col'] == 'baseImponible codigoPorcentaje:' . $valImp->codigoPorcentaje) {
                                        array_push($valores, $valImp->baseImponible);
                                        //echo 'sii:: '.$valImp->baseImponible;
                                        $coincide = true;
                                        // break;
                                    }
                                    if ($columns[$ind]['col'] == 'valor codigoPorcentaje:' . $valImp->codigoPorcentaje) {
                                        array_push($valores, $valImp->valor);
                                        //echo 'sii:: '.$valImp->baseImponible;
                                        $coincide = true;
                                        // break;
                                    }
                                } else {
                                    if ($keyImp == 'codigoPorcentaje') {
                                        $codP = $valImp;
                                    }
                                    if ($keyImp == 'baseImponible') {
                                        //$comprobar = array_search($valImp, $valores, false);
                                        //  echo '['.print_r($comprobar).']';
                                        //if($comprobar == false){
                                        if ($columns[$ind]['col'] == 'baseImponible codigoPorcentaje:' . $codP) {
                                            array_push($valores, $valImp);
                                            //echo 'nooo:: '.$valImp;
                                            $coincide = true;
                                            //   break;
                                        }
                                    }
                                    if ($keyImp == 'valor') {
                                        if ($columns[$ind]['col'] == 'valor codigoPorcentaje:' . $codP) {
                                            array_push($valores, $valImp);
                                            //echo 'nooo:: '.$valImp;
                                            $coincide = true;
                                            //   break;
                                        }
                                    }
                                }
                            }
                            //if ($coincide) {break;}
//                                                            break;
                        }
                        if ($coincide) {
                            
                        } else {
                            array_push($valores, '0');
                        }
                    }
                }
            }
        }

        return $valores;
    }
    
    
    
    private function generarTablaRetencion($docum, $columns, $COL_FIN) {
        $valores = [];
        if ($docum != null) {
            for ($ind = self::COL_INI; $ind < (count($columns) - $COL_FIN); $ind++) {
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
                    foreach ($docum->infoCompRetencion as $key => $val) {
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
//                        //print_r($docum->infoFactura->totalConImpuestos->totalImpuesto);
//                        if (isset($docum->infoCompRetencion->totalConImpuestos->totalImpuesto)) {
//                            $codP = -1;
//                            foreach ($docum->infoCompRetencion->totalConImpuestos->totalImpuesto as $keyImp => $valImp) {
//
//                                if (isset($valImp->baseImponible)) {
//                                    //$comprobar = array_search($valImp->baseImponible, $valores, false);
//                                    //echo '{'.print_r($comprobar == false).'}';
//                                    //if($comprobar == false){
//                                    if ($columns[$ind]['col'] == 'baseImponible codigoPorcentaje:' . $valImp->codigoPorcentaje) {
//                                        array_push($valores, $valImp->baseImponible);
//                                        //echo 'sii:: '.$valImp->baseImponible;
//                                        $coincide = true;
//                                        // break;
//                                    }
//                                    if ($columns[$ind]['col'] == 'valor codigoPorcentaje:' . $valImp->codigoPorcentaje) {
//                                        array_push($valores, $valImp->valor);
//                                        //echo 'sii:: '.$valImp->baseImponible;
//                                        $coincide = true;
//                                        // break;
//                                    }
//                                } else {
//                                    if ($keyImp == 'codigoPorcentaje') {
//                                        $codP = $valImp;
//                                    }
//                                    if ($keyImp == 'baseImponible') {
//                                        //$comprobar = array_search($valImp, $valores, false);
//                                        //  echo '['.print_r($comprobar).']';
//                                        //if($comprobar == false){
//                                        if ($columns[$ind]['col'] == 'baseImponible codigoPorcentaje:' . $codP) {
//                                            array_push($valores, $valImp);
//                                            //echo 'nooo:: '.$valImp;
//                                            $coincide = true;
//                                            //   break;
//                                        }
//                                    }
//                                    if ($keyImp == 'valor') {
//                                        if ($columns[$ind]['col'] == 'valor codigoPorcentaje:' . $codP) {
//                                            array_push($valores, $valImp);
//                                            //echo 'nooo:: '.$valImp;
//                                            $coincide = true;
//                                            //   break;
//                                        }
//                                    }
//                                }
//                            }
//                            //if ($coincide) {break;}
////                                                            break;
//                        }
//                        if ($coincide) {
//                            
//                        } else {
                            array_push($valores, '0');
//                        }
                    }
                }
            }
        }

        return $valores;
    }
    
    
    private function generarTablaNotaCredito($docum, $columns, $COL_FIN) {
        $valores = [];
        if ($docum != null) {
            for ($ind = self::COL_INI; $ind < (count($columns) - $COL_FIN); $ind++) {
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
                    foreach ($docum->infoNotaCredito as $key => $val) {
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
                        //print_r($docum->infoFactura->totalConImpuestos->totalImpuesto);
                        if (isset($docum->infoNotaCredito->totalConImpuestos->totalImpuesto)) {
                            $codP = -1;
                            foreach ($docum->infoNotaCredito->totalConImpuestos->totalImpuesto as $keyImp => $valImp) {

                                if (isset($valImp->baseImponible)) {
                                    //$comprobar = array_search($valImp->baseImponible, $valores, false);
                                    //echo '{'.print_r($comprobar == false).'}';
                                    //if($comprobar == false){
                                    if ($columns[$ind]['col'] == 'baseImponible codigoPorcentaje:' . $valImp->codigoPorcentaje) {
                                        array_push($valores, $valImp->baseImponible);
                                        //echo 'sii:: '.$valImp->baseImponible;
                                        $coincide = true;
                                        // break;
                                    }
                                    if ($columns[$ind]['col'] == 'valor codigoPorcentaje:' . $valImp->codigoPorcentaje) {
                                        array_push($valores, $valImp->valor);
                                        //echo 'sii:: '.$valImp->baseImponible;
                                        $coincide = true;
                                        // break;
                                    }
                                } else {
                                    if ($keyImp == 'codigoPorcentaje') {
                                        $codP = $valImp;
                                    }
                                    if ($keyImp == 'baseImponible') {
                                        //$comprobar = array_search($valImp, $valores, false);
                                        //  echo '['.print_r($comprobar).']';
                                        //if($comprobar == false){
                                        if ($columns[$ind]['col'] == 'baseImponible codigoPorcentaje:' . $codP) {
                                            array_push($valores, $valImp);
                                            //echo 'nooo:: '.$valImp;
                                            $coincide = true;
                                            //   break;
                                        }
                                    }
                                    if ($keyImp == 'valor') {
                                        if ($columns[$ind]['col'] == 'valor codigoPorcentaje:' . $codP) {
                                            array_push($valores, $valImp);
                                            //echo 'nooo:: '.$valImp;
                                            $coincide = true;
                                            //   break;
                                        }
                                    }
                                }
                            }
                            //if ($coincide) {break;}
//                                                            break;
                        }
                        if ($coincide) {
                            
                        } else {
                            array_push($valores, '0');
                        }
                    }
                }
            }
        }

        return $valores;
    }

}
