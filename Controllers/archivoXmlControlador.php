<?php

class archivoXmlControlador extends archivoXmlModelo {

    public function listar_archivos_controlador($post, $regsPagina) {

        if (isset($post) && isset($post['dtFechaIni']) && isset($post['dtFechaFin'])) {
            $respuesta = archivoXmlModelo::listar_archivos($post['dtFechaIni'], $post['dtFechaFin'],
                            isset($post['listUsers']) ? $post['listUsers'] : null,
                            isset($post['txtClaveAcceso']) && $post['txtClaveAcceso'] != '' ? $post['txtClaveAcceso'] : null,
                            isset($post['txtRuc']) && $post['txtRuc'] != '' ? $post['txtRuc'] : null,
                            isset($post['txtTipoDoc']) && $post['txtTipoDoc'] != '' ? $post['txtTipoDoc'] : null,
                            $post['txtDesde'], $regsPagina,
                            isset($post['txtEstadoSistema']) ? $post['txtEstadoSistema'] : null,
                            isset($post['seleccionados']) ? $post['seleccionados'] : false,
                    isset($post['conDetalles']) ? $post['conDetalles'] : false,
                    isset($post['idReembolso']) ? $post['idReembolso'] : null);
        } else {
            $respuesta = archivoXmlModelo::listar_archivos(date("Y-m-d"), date("Y-m-d"), ($_SESSION['Rol']->principal == 0) ? $_SESSION['Usuario']->id : null,
                            null, null, null, 0, $regsPagina, null, false, false, null);
        }

        if (!isset($respuesta)) {
            $respuesta = [];
        }

        return $respuesta;
    }

    public function anular_xmls_controlador() {
        $data = array();
        $idsxml = explode(";", $_POST['idsxml']);
        foreach ($idsxml as $id) {
            if ($id !== '') {
                $data[] = array(
                    "id" => $id,
                    "razonAnulacion" => mb_strtoupper($_POST['txtRazon'], 'utf-8'),
                    "idUsuarioCarga" => $_SESSION['Usuario']->id,
                );
            }
        }

        $respuesta = archivoXmlModelo::anular_xmls_modelo($data);

        if (isset($respuesta)) {
            return '<script>swal("", "Documentos anulados correctamente", "success")
                    .then((value) => {
                        $(`#btnSearch`).click();
                    });</script>';
        } else {
            return '<script>swal("", "Error al anular los documentos.", "error");</script>';
        }
    }
    
    
    public function listar_xml_cargados_controlador($post, $regsPagina) {

        $fechaIni=date("Y-m-d");
        $nuevafecha = strtotime('-12 months', strtotime($fechaIni));
        $nuevafecha = date('Y-m-d' , $nuevafecha);
        
         $respuesta = archivoXmlModelo::listar_archivos($nuevafecha, date("Y-m-d"), 
                 //($_SESSION['Rol']->principal == 0) ? $_SESSION['Usuario']->id : null,
                 isset($_POST['cbxListUser']) ? $_POST['cbxListUser'] : ($_SESSION['Rol']->id == 1 ? null : $_SESSION['Usuario']->id),
                            null, null, null, 0, $regsPagina, "CARGADO", false, false, null);
        

        if (!isset($respuesta)) {
            $respuesta = [];
        }

        return $respuesta;
    }
    
    
    public function anular_xmls_porarchivo_controlador() {
        
        $fileP12 = file_get_contents($_FILES['fileAnular']['tmp_name']);
        $archivoB64 = base64_encode($fileP12);
        
        $data = [
                "archivoAnularB64" => $archivoB64,
                "usuarioAnula" => $_SESSION['Usuario']->usuario,
            ];

        $respuesta = archivoXmlModelo::anular_xmls_porarchivo_modelo($data);

        if (isset($respuesta) && $respuesta->respuesta == "OK") {
            return '<script>swal("", "Documentos anulados correctamente", "success")
                    .then((value) => {
                        $(`#btnSearch`).click();
                    });</script>';
        } 
        else if(isset($respuesta)){
            return '<script>swal("", "'.$respuesta->respuesta.'", "error");</script>';
        }
        else {
            return '<script>swal("", "Error al anular los documentos.", "error");</script>';
        }
    }
    
    
    public function crear_columnas($respuesta) {


        $columns = [];
        array_push($columns, ['col' => 'Estado sistema', 'wid' => '100px']);
        array_push($columns, ['col' => 'Usuario carga', 'wid' => '100px']);
        array_push($columns, ['col' => 'Fecha de emisión', 'wid' => '100px']);
        array_push($columns, ['col' => 'Fecha de autorización', 'wid' => '100px']);
        array_push($columns, ['col' => 'Estado SRI', 'wid' => '100px']);
        array_push($columns, ['col' => 'Número de autorización', 'wid' => '100px']);
        array_push($columns, ['col' => 'Ambiente', 'wid' => '100px']);

        $columnsAux = [];
        
        //esta es para la version del comprobanta
        array_push($columnsAux, ['col' => 'version', 'wid' => '100px']);
        
        foreach ($respuesta as $respe) {
            if (isset($respe->comprobante)) {
                $listvarj = json_decode($respe->comprobante);
                $docum = null;
                if (isset($listvarj->factura)) {
                    $docum = $listvarj->factura;
                }
                if (isset($listvarj->comprobanteRetencion)) {
                    $docum = $listvarj->comprobanteRetencion;
                }
                if (isset($listvarj->notaCredito)) {
                    $docum = $listvarj->notaCredito;
                }

                if ($docum != null) {                    
                    
                    foreach ($docum->infoTributaria as $key => $val) {
                        array_push($columnsAux, ['col' => $key, 'wid' => '100px']);
                    }
                    if (isset($docum->infoFactura)) {
                        foreach ($docum->infoFactura as $key => $val) {
                            if (!isset($val->pago) && !isset($val->totalImpuesto)) {
                                array_push($columnsAux, ['col' => $key, 'wid' => '100px']);
                            } elseif (isset($val->totalImpuesto)) {
                                foreach ($val->totalImpuesto as $keyImp => $valImp) {
                                    if (isset($valImp->codigoPorcentaje)) {
                                        array_push($columnsAux, ['col' => 'baseImponible codigoPorcentaje:' . $valImp->codigoPorcentaje, 'wid' => '100px']);
                                        array_push($columnsAux, ['col' => 'valor codigoPorcentaje:' . $valImp->codigoPorcentaje, 'wid' => '100px']);
                                    } elseif ($keyImp == 'codigoPorcentaje') {
                                        array_push($columnsAux, ['col' => 'baseImponible codigoPorcentaje:' . $valImp, 'wid' => '100px']);
                                        array_push($columnsAux, ['col' => 'valor codigoPorcentaje:' . $valImp, 'wid' => '100px']);
                                    }
                                }
                            }
                        }
                    }
                    if (isset($docum->infoCompRetencion)) {
                        foreach ($docum->infoCompRetencion as $key => $val) {
                            if (!isset($val->pago) && !isset($val->totalImpuesto)) {
                                array_push($columnsAux, ['col' => $key, 'wid' => '100px']);
                            } 
                        }
                        if(isset($docum->impuestos)){
                            foreach ($docum->impuestos as $key => $val){
                                foreach ($val as $keyImp => $valImp) {
                                    if (isset($valImp->codigoRetencion)) {
                                        array_push($columnsAux, ['col' => 'baseImponible codigoRetencion:' . $valImp->codigoRetencion, 'wid' => '100px']);
                                        array_push($columnsAux, ['col' => 'valorRetenido codigoRetencion:' . $valImp->codigoRetencion, 'wid' => '100px']);
                                    } elseif ($keyImp == 'codigoRetencion') {
                                        array_push($columnsAux, ['col' => 'baseImponible codigoRetencion:' . $valImp, 'wid' => '100px']);
                                        array_push($columnsAux, ['col' => 'valorRetenido codigoRetencion:' . $valImp, 'wid' => '100px']);
                                    }
                                }
                            }
                        }
                    }
                    //esto para las retenciones
                    if (isset($docum->docsSustento)) {
                        foreach ($docum->docsSustento as $key => $val) {
                            if (isset($val->impuestosDocSustento)) {
                                foreach ($val->impuestosDocSustento as $keyImp => $valImp) {
                                    if (isset($valImp->codigoPorcentaje)) {
                                        array_push($columnsAux, ['col' => 'baseImponible codigoPorcentaje:' . $valImp->codigoPorcentaje, 'wid' => '100px']);
                                        array_push($columnsAux, ['col' => 'valorImpuesto codigoPorcentaje:' . $valImp->codigoPorcentaje, 'wid' => '100px']);
                                    } elseif ($keyImp == 'codigoPorcentaje') {
                                        array_push($columnsAux, ['col' => 'baseImponible codigoPorcentaje:' . $valImp, 'wid' => '100px']);
                                        array_push($columnsAux, ['col' => 'valorImpuesto codigoPorcentaje:' . $valImp, 'wid' => '100px']);
                                    }
                                }
                            }
                            
                            if (isset($val->retenciones)) {
                                foreach ($val->retenciones as $keyx => $valx) {
                                    foreach ($valx as $keyImp => $valImp) {
                                        if (isset($valImp->codigoRetencion)) {
                                            array_push($columnsAux, ['col' => 'baseImponible codigoRetencion:' . $valImp->codigoRetencion, 'wid' => '100px']);
                                            array_push($columnsAux, ['col' => 'valorRetenido codigoRetencion:' . $valImp->codigoRetencion, 'wid' => '100px']);
                                        } elseif ($keyImp == 'codigoRetencion') {
                                            array_push($columnsAux, ['col' => 'baseImponible codigoRetencion:' . $valImp, 'wid' => '100px']);
                                            array_push($columnsAux, ['col' => 'valorRetenido codigoRetencion:' . $valImp, 'wid' => '100px']);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    //hasta aca retenciones
                    
                    
                    if (isset($docum->infoNotaCredito)) {
                        foreach ($docum->infoNotaCredito as $key => $val) {
                            if (!isset($val->pago) && !isset($val->totalImpuesto)) {
                                array_push($columnsAux, ['col' => $key, 'wid' => '100px']);
                            } elseif (isset($val->totalImpuesto)) {
                                foreach ($val->totalImpuesto as $keyImp => $valImp) {
                                    if (isset($valImp->codigoPorcentaje)) {
                                        array_push($columnsAux, ['col' => 'baseImponible codigoPorcentaje:' . $valImp->codigoPorcentaje, 'wid' => '100px']);
                                        array_push($columnsAux, ['col' => 'valor codigoPorcentaje:' . $valImp->codigoPorcentaje, 'wid' => '100px']);
                                    } elseif ($keyImp == 'codigoPorcentaje') {
                                        array_push($columnsAux, ['col' => 'baseImponible codigoPorcentaje:' . $valImp, 'wid' => '100px']);
                                        array_push($columnsAux, ['col' => 'valor codigoPorcentaje:' . $valImp, 'wid' => '100px']);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $ind = 0;
        foreach ($columnsAux as $col) {
//            if($ind == 0){
//                array_push($columns, ['col' => $col['col'], 'wid'=>'100px']);
//            }
//            else{
            $coincide = false;
            foreach ($columns as $coll) {
                if ($coll['col'] == $col['col']) {
                    $coincide = true;
                    break;
                }
            }
//            }
            if (!$coincide) {
                array_push($columns, ['col' => $col['col'], 'wid' => '100px']);
            }
            $ind++;
        }

        array_push($columns, ['col' => 'Tipo de documento', 'wid' => '100px']);
        array_push($columns, ['col' => 'Código JD proveedor', 'wid' => '100px']);
        
        array_push($columns, ['col' => 'Usuario anula', 'wid' => '100px']);
        array_push($columns, ['col' => 'Fecha anula', 'wid' => '100px']);
        array_push($columns, ['col' => 'Razón anulación', 'wid' => '100px']);
                                        
        array_push($columns, ['col' => 'Archivo xml', 'wid' => '100px']);
        array_push($columns, ['col' => 'Archivo RIDE', 'wid' => '100px']);
        
        
        
        if(isset($_POST['conDetalles']) && $_POST['conDetalles'] == true){
            array_push($columns, ['col' => 'detalle', 'wid' => '100px']);
            array_push($columns, ['col' => 'precio_unitario', 'wid' => '100px']);
            //para retenciones
            array_push($columns, ['col' => 'cod_DocSustento', 'wid' => '100px']);
            array_push($columns, ['col' => 'num_DocSustento', 'wid' => '100px']);
            array_push($columns, ['col' => 'fecha_EmisionDocSustento', 'wid' => '100px']);
            array_push($columns, ['col' => 'codigo_Retencion', 'wid' => '100px']);
            array_push($columns, ['col' => 'base_Imponible', 'wid' => '100px']);
            array_push($columns, ['col' => 'porcentaje_Retener', 'wid' => '100px']);
            array_push($columns, ['col' => 'valor_Retenido', 'wid' => '100px']);
        }

        return $columns;
    }

}
