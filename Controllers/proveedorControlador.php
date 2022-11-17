<?php

class proveedorControlador extends proveedorModelo {

    public function listarProveedores($post) {
        $start = $post['start']; //desde el numero de registro que empieza
        $length = $post['length']; //el numero de registros a buscar
        $valBusq = $post['search']['value']; //este es el valor que se ingresa en la busqueda
        
        if(empty($valBusq)){
            $respuesta = proveedorModelo::listar_proveedores($start, $length, null);
        }
        elseif(strlen($valBusq) >=3 ){
            $respuesta = proveedorModelo::listar_proveedores($start, $length, urlencode($valBusq));
        }
        
        if(!isset($respuesta)) {
            $returnLista = array();
        }
        else{
            $listaProveedores = array();
            foreach ($respuesta as $proveedor){
                //$columnas[0] = $proveedor->id;
                $columnas[0] = $proveedor->ruc;
                $columnas[1] = $proveedor->nombre;
                $columnas[2] = $proveedor->codigoJD;
                $columnas[3] = '<div class="btn-group mr-2" role="group" aria-label="First group">
                                                <button class="btn btn-info fa fa-edit" type="button" onclick=\'openModalProveedor(variableProveedor = '. json_encode($proveedor).');\'></button>
                                            </div>';

                $listaProveedores[] = $columnas;
            }
            
            $returnLista = array(
			"draw"            => isset ( $post['draw'] ) ? intval( $post['draw'] ) : 0,
			"recordsTotal"    => $proveedor->totalRegistros,
			"recordsFiltered" => $proveedor->totalRegistros,
			"data"            => $listaProveedores
    //[["1","2","3","4","5","6","7"]]
		);
        }
        return $returnLista;
    }

    //aqui la logica
    public function guardar_proveedor_controlador() {
        $idProveedor = $_POST['idProveedor'];
        $txtNombre = $_POST['txtNombre'];
        $txtRuc = $_POST['txtRuc'];
        $txtCodigoJD = $_POST['txtCodigoJD'];

        if (isset($txtNombre) && isset($txtRuc) && isset($txtCodigoJD)) {
            $datos = [
                "id" => $idProveedor,
                "nombre" => strtoupper($txtNombre),
                "ruc" => strtoupper($txtRuc),
                "codigoJD" => strtoupper($txtCodigoJD)
            ];

            $respuesta = proveedorModelo::guardar_proveedor_modelo($datos);

            if ($respuesta->id > 0) {
                return '<script>swal("", "Datos almacenados correctamente", "success")
                    .then((value) => {
                        $(`#btnBuscar`).click();
                    });</script>';
            } else {
                return '<script>swal("", "Error al almacenar los datos.", "error");</script>';
            }
            
        } else {
            return '<script>swal("", "Complete los campos requeridos del formulario.", "error");</script>';
        }
    }

}
