<?php

class datoContableReembolsoControlador extends datoContableReembolsoModelo {
    
    public function guardar_datos_contabilidad_controlador() {

        $data = [
            "idReembolso" => $_POST['idReemb'],
            "justificativos" => isset($_POST['justificativos']) ? mb_strtoupper($_POST['justificativos'], 'utf-8') : null,
            "batchIngresoLiquidacion" => isset($_POST['batchIngresoLiquidacion']) ? mb_strtoupper($_POST['batchIngresoLiquidacion'], 'utf-8') : null,
            "batchDocumentoInterno" => isset($_POST['batchDocumentoInterno']) ? mb_strtoupper($_POST['batchDocumentoInterno'], 'utf-8') : null,
            "p3" => isset($_POST['p3']) ? mb_strtoupper($_POST['p3'], 'utf-8') : null,
            "p4" => isset($_POST['p4']) ? mb_strtoupper($_POST['p4'], 'utf-8') : null,
            "p5" => isset($_POST['p5']) ? mb_strtoupper($_POST['p5'], 'utf-8') : null,
            "phne" => isset($_POST['phne']) ? mb_strtoupper($_POST['phne'], 'utf-8') : null,
            "cruce1" => isset($_POST['cruce1']) ? mb_strtoupper($_POST['cruce1'], 'utf-8') : null,
            "cruce2" => isset($_POST['cruce2']) ? mb_strtoupper($_POST['cruce2'], 'utf-8') : null,
            "tipoDocumento" => isset($_POST['tipoDocumento']) ? mb_strtoupper($_POST['tipoDocumento'], 'utf-8') : null,
            "numeroDocumento" => isset($_POST['numeroDocumento']) ? mb_strtoupper($_POST['numeroDocumento'], 'utf-8') : null,
            "numeroRetencion" => isset($_POST['numeroRetencion']) ? mb_strtoupper($_POST['numeroRetencion'], 'utf-8') : null,
            "idUsuarioModifica" => $_SESSION["Usuario"]->id,
        ];
            
        $respuesta = datoContableReembolsoModelo::guardar_datos_contabilidad_modelo($data);

        if (isset($respuesta) && $respuesta->respuesta == "OK") {
            return "<script>swal('','Datos almacenados correctamente.','info')
                .then((value) => {
                            $(`#btnSearch`).click();
                        });</script>;</script>";
        }
        elseif(isset ($respuesta->respuesta)){
            return "<script>swal('','Error: ".$respuesta->respuesta."','error');</script>";
        }
        else{
            return "<script>swal('','Error','error');</script>";
        }

        
    }

    public function buscar_dato_contable_controlador() {
        $respuesta = datoContableReembolsoModelo::buscar_dato_contable_modelo($_POST["idReembolso"]);
        return json_encode($respuesta);
    }
}
