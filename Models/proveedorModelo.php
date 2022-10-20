<?php
class proveedorModelo extends serviciosWebModelo {
    
    public function guardar_proveedor_modelo($datos){
        $respuesta = self::invocarPost('proveedor/guardarProveedor', $datos);
        return $respuesta;
    }
    
    
    public function listar_proveedores($start, $length, $valBusq) {
        $array = [];
        $listaProveedores = self::invocarGet('proveedor/listarProveedores?desde='.$start.'&hasta='.$length.'&valBusq='.$valBusq, $array);
        return $listaProveedores;
    }
}