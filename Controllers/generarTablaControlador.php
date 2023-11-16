<?php

class generarTablaControlador {
    
    const COL_INI = 7; //son las columnas estaticas iniciales, si se aumente al inicio se aumenta aqui

    public function generarTabla($listvarj, $columns) {
        
        $COL_FIN = 9; //es la cantidad de columnas finales estaticas, si se aumenta al final se aumenta aqui
        
        if(isset($_POST['conDetalles']) && $_POST['conDetalles'] == true){
            $COL_FIN = 18; //si se aumanta al final o en detalles aqui se aumenta en 1
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
                
                //aqui va lo de la version del comprobante
                if ($columns[$ind]['col'] == "version") {
                    array_push($valores, isset($docum->version) ? $docum->version : null);
                    $coincide = true;
                }
                
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
//        print_r($docum);
        $valores = [];
        if ($docum != null) {
            for ($ind = self::COL_INI; $ind < (count($columns) - $COL_FIN); $ind++) {
                $coincide = false;
                
                //aqui va lo de la version del comprobante
                if ($columns[$ind]['col'] == "version") {
                    array_push($valores, $docum->version);
                    $coincide = true;
                }
                
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
                        
                        
                        if (isset($docum->docsSustento->docSustento)) {
                            
                            $codP = -1;
                            foreach ($docum->docsSustento->docSustento as $keyImp => $valImp) {
//                                print_r($valImp);
                                if(isset($valImp->impuestoDocSustento)){
                                    if (isset($valImp->impuestoDocSustento->baseImponible)) {
                                        //$comprobar = array_search($valImp->baseImponible, $valores, false);
                                        //echo '{'.print_r($comprobar == false).'}';
                                        //if($comprobar == false){
                                        if ($columns[$ind]['col'] == 'baseImponible codigoPorcentaje:' . $valImp->impuestoDocSustento->codigoPorcentaje) {
                                            array_push($valores, $valImp->impuestoDocSustento->baseImponible);
                                            //echo 'sii:: '.$valImp->baseImponible;
                                            $coincide = true;
                                            // break;
                                        }
                                        if ($columns[$ind]['col'] == 'valorImpuesto codigoPorcentaje:' . $valImp->impuestoDocSustento->codigoPorcentaje) {
                                            array_push($valores, $valImp->impuestoDocSustento->valorImpuesto);
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
                                        if ($keyImp == 'valorImpuesto') {
                                            if ($columns[$ind]['col'] == 'valorImpuesto codigoPorcentaje:' . $codP) {
                                                array_push($valores, $valImp);
                                                //echo 'nooo:: '.$valImp;
                                                $coincide = true;
                                                //   break;
                                            }
                                        }
                                    }
                                }
                                
                                
                                if(isset($valImp->retencion)){
                                    foreach ($valImp->retencion as $keyImp => $valImp) {
                                        if(isset($valImp->codigoRetencion)){
                                            if ($columns[$ind]['col'] == 'baseImponible codigoRetencion:' . $valImp->codigoRetencion) {
                                                array_push($valores, $valImp->baseImponible);
                                                $coincide = true;
                                                // break;
                                            }
                                            if ($columns[$ind]['col'] == 'valorRetenido codigoRetencion:' . $valImp->codigoRetencion) {
                                                array_push($valores, $valImp->valorRetenido);
                                                $coincide = true;
                                                // break;
                                            }
                                        }
                                        else{
//                                            echo $keyImp .'=='.$valImp;echo "<br/>";
                                            if ($keyImp == 'codigoRetencion') {
                                                $codP = $valImp;
                                            }
                                            if ($keyImp == 'baseImponible') {
                                                //$comprobar = array_search($valImp, $valores, false);
                                                //  echo '['.print_r($comprobar).']';
                                                //if($comprobar == false){
                                                if ($columns[$ind]['col'] == 'baseImponible codigoRetencion:' . $codP) {
                                                    array_push($valores, $valImp);
                                                    //echo 'nooo:: '.$valImp;
                                                    $coincide = true;
                                                    //   break;
                                                }
                                            }
                                            if ($keyImp == 'valorRetenido') {
                                                if ($columns[$ind]['col'] == 'valorRetenido codigoRetencion:' . $codP) {
                                                    array_push($valores, $valImp);
                                                    //echo 'nooo:: '.$valImp;
                                                    $coincide = true;
                                                    //   break;
                                                }
                                            }
                                            
                                        }
                                    } 
                                }
                                
                                
                                
                                
                            }
                            //if ($coincide) {break;}
//                                                            break;
                        }
                        else{
                            if (isset($docum->impuestos->impuesto)) {

                                $codP = -1;
                                foreach ($docum->impuestos->impuesto as $keyImp => $valImp) {
                                    
    //                                print_r($valImp);
                                    if(isset($valImp->codigoRetencion)){
                                        if ($columns[$ind]['col'] == 'baseImponible codigoRetencion:' . $valImp->codigoRetencion) {
                                            array_push($valores, $valImp->baseImponible);
                                            $coincide = true;
                                            // break;
                                        }
                                        if ($columns[$ind]['col'] == 'valorRetenido codigoRetencion:' . $valImp->codigoRetencion) {
                                            array_push($valores, $valImp->valorRetenido);
                                            $coincide = true;
                                            // break;
                                        }
                                    }
                                    else{
//                                            echo $keyImp .'=='.$valImp;echo "<br/>";
                                        if ($keyImp == 'codigoRetencion') {
                                            $codP = $valImp;
                                        }
                                        if ($keyImp == 'baseImponible') {
                                            //$comprobar = array_search($valImp, $valores, false);
                                            //  echo '['.print_r($comprobar).']';
                                            //if($comprobar == false){
                                            if ($columns[$ind]['col'] == 'baseImponible codigoRetencion:' . $codP) {
                                                array_push($valores, $valImp);
                                                //echo 'nooo:: '.$valImp;
                                                $coincide = true;
                                                //   break;
                                            }
                                        }
                                        if ($keyImp == 'valorRetenido') {
                                            if ($columns[$ind]['col'] == 'valorRetenido codigoRetencion:' . $codP) {
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
    
    
    private function generarTablaNotaCredito($docum, $columns, $COL_FIN) {
        $valores = [];
        if ($docum != null) {
            for ($ind = self::COL_INI; $ind < (count($columns) - $COL_FIN); $ind++) {
                $coincide = false;
                
                //aqui va lo de la version del comprobante
                if ($columns[$ind]['col'] == "version") {
                    array_push($valores, $docum->version);
                    $coincide = true;
                }
                
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
