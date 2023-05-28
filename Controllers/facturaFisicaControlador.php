<?php

class facturaFisicaControlador extends facturaFisicaModelo {

    //aqui la logica
    public function guardar_factura_fisica_controlador() {

        $arrayphp = json_decode($_POST["listaDetalles"]);
        //print_r($arrayphp);
        $tt = strtotime($_POST['txtFechaFactura']);
        $fecIso = date("c", $tt);

        $data = [
            "numeroFactura" => $_POST['txtNumeroFactura'],
            "fechaFactura" => $fecIso,
            "idUsuarioCarga" => $_SESSION['Usuario']->id,

            "rucProveedor" => $_POST['txtRuc'],
            "proveedor" => mb_strtoupper($_POST['txtProveedor'], 'utf-8'),
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
        ];

        $respuesta = facturaFisicaModelo::guardar_factura_fisica_modelo($data);

        if (isset($respuesta) && $respuesta->id > 0) {
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