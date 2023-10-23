<?php

class facturaFisicaControlador extends facturaFisicaModelo {

    //aqui la logica
    public function guardar_factura_fisica_controlador() {

//        print_r($_FILES['txtArchivoFisica']);
        
        //esto es cuando cargaron un archivo
        if($_FILES['txtArchivoFisica']['size'] > 0){
            $nombreArchivo = $_FILES['txtArchivoFisica']['name'];
        }
        
        $arrayphp = json_decode($_POST["listaDetalles"]);
        //print_r($arrayphp);
        $tt = strtotime($_POST['txtFechaFactura']);
        $fecIso = date("c", $tt);

        $data = [
            "numeroFactura" => $_POST['txtNumeroFactura'],
            "fechaFactura" => $fecIso,
            "idUsuarioCarga" => $_SESSION['Usuario']->id,

            "rucProveedor" => $_POST['txtRuc'],
            "proveedor" => mb_strtoupper(trim($_POST['txtProveedor']), 'utf-8'),
            "direccionProveedor" => mb_strtoupper($_POST['txtDirecProv'], 'utf-8'),

            "tipoIdentCliente" => $_POST['txtTipoIdentCliente'],
            "identificacionCliente" => $_POST['txtIdentCliente'],
            "cliente" => mb_strtoupper($_POST['txtCliente'], 'utf-8'),
            "direccionCliente" => mb_strtoupper($_POST['txtDirCliente'], 'utf-8'),

            "formaPago" => $_POST['listFormaPago'],

            //los totales
            "descuento" => $_POST['lblDescuentoTotal'],
            "subtotalSinIva" => $_POST['lblSubtotalSinIva'],
            "subtotal" => $_POST['lblSubtotal'],
            "porcentajeIva" => $_POST['txtTipoIva'],
            "iva" => $_POST['lblIva'],
            "total" => $_POST['lblTotal'],
            
            "tipoIva" => $_POST['txtTipoIva'],
            "tarifa" => $_POST['txtTarifa'],

            "tipoDocumento" => $_POST["txtTipoDocumento"],
            //los detalles
            "listaDetalles" => $arrayphp,
            "nombreArchivo" => isset($nombreArchivo) ? $nombreArchivo : null,
        ];

        $respuesta = facturaFisicaModelo::guardar_factura_fisica_modelo($data);

        if (isset($respuesta) && $respuesta->id > 0) {
            
            if(isset($nombreArchivo)){//cuando se carga un archivo se guarda ene l path que viene en la respuesta
                //aqui se debe comprobar si las carpetas existen
                $path_file = "../" . $respuesta->pathArchivo;
                
                if (is_dir($path_file)) {
//                    echo "SIIII existe";
                } else {
                    $raux = explode("/", $respuesta->pathArchivo);
                    //dar los permisos cuando no existe
                    $pathsArray = "../".$raux[0];
                
                    for ($i = 1; $i < count($raux); $i++) {
                        $pathsArray = $pathsArray . "/" .$raux[$i];
                        //echo $pathsArray . PHP_EOL;

                        if (is_dir($pathsArray)) {
                            chmod($pathsArray, 0777);
                        } else {
                            mkdir($pathsArray, 0777, true);
                            chmod($pathsArray, 0777);
                        }
                    }
                }
                
                $path = "../".$respuesta->pathArchivo . "/" . $nombreArchivo;//aqui donde se debe guardar + el nombre del archivo
                
                if (move_uploaded_file($_FILES['txtArchivoFisica']['tmp_name'], $path)) { //Cargar archivos
                    //exito
                }
            }
            
            return '<script>swal("", "Datos almacenados correctamente", "success")
                .then((value) => {
                    $(`#lkCancel`).click();
                });</script>';
        } 
        else if(isset($respuesta)){
            return '<script>swal("", "'.$respuesta->respuesta.'", "error");</script>';
        }else {
            return '<script>swal("", "Error al almacenar los datos.", "error");</script>';
        }
        
    }

}