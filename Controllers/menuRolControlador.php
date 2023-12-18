<?php
class menuRolControlador extends menuRolModelo {
    
    public function listarMenusRol() {
        $listaMenus = menuRolModelo::listar_menus_rol();
        if(!isset($listaMenus)) {
            $listaMenus = [];
        }
        return $listaMenus;
    }
    
    public function listarMenusRolPorRol($idRol) {
        $listaMenuRol = menuRolModelo::listar_menusRol_por_rol($idRol);
        return $listaMenuRol;
    }
    
    public function actualizarPermisos() {
        $idRol = $_POST['select'];
        //print_r($_POST);
        $listarMenu = new menuControlador();
        $respuesta = $listarMenu->listarMenus();
        $listaIdMenu = [];
        
        for($i =0; $i<count($respuesta);$i++) {
            $menu = $respuesta[$i];
            if(isset($_POST[$menu->id])){
//                echo "tiene post: ";
//                print_r($menu->id);
//                echo PHP_EOL;
                array_push($listaIdMenu, $menu->id);
                if($menu->idMenu != null) {
//                    echo $menu->idMenu.PHP_EOL;
//                    print_r($listaIdMenu);
                    $comprobar = array_search($menu->idMenu, $listaIdMenu, false);
//                    print_r($comprobar);
                    if(!isset($comprobar) || $comprobar === false){
//                        echo "no tiene".PHP_EOL;
                        array_push($listaIdMenu, $menu->idMenu);
                    }
                }
            }
        }
//        print_r($listaIdMenu);
        $datos = [];
        foreach($listaIdMenu as $idMenu) {
            array_push($datos, [
                    "idRol" => $idRol,
                    "idMenu" => $idMenu
                ]
            );
        }
        //print_r($datos);
        menuRolModelo::actualizar_permisos($datos);
        
        return '<script>swal("", "Datos actualizados correctamente", "success")
                    .then((value) => {
                        $(`#btnBuscar`).click();
                    });</script>';
    }
}
