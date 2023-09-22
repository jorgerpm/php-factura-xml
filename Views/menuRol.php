<main class="app-content">
    <div class="app-title" style="height: 50px">
        <div>
            <span class="tamañoTitulo"><i class="tamañoTitulo fa fa-unlock"></i> Asignaci&oacute;n de permisos</span>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item">Administraci&oacute;n</li>
            <li class="breadcrumb-item active"><a href="#">Asignaci&oacute;n de permisos</a></li>
        </ul>
    </div>
    <div class="row espacio">
        <div class="col-md-12 col-12">
            <div class="tile">
                <?php
                    //require_once './acciones/listarArchivos.php';
                    $menuRolControlador = new menuRolControlador();
                    
                    if(isset($_GET['select'])){
                        $idRolUsuario = $_GET['select'];
                        $listaMenuPorRol = $menuRolControlador->listarMenusRolPorRol($idRolUsuario);
                    } else{
                        
                    }
                ?>
                <div>
                    <p><button style="display: none;" id="btnBuscar" name="btnBuscar" class="btn btn-primary btn-sm fa" type="button" onclick="window.location.href = ''">buscar</button></p>
                </div>
                <!--<form id="formMenuRol" class="FormularioAjax login-form" action="acciones/actualizarPermisos.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">-->
                <form name="f1" id="formMenuRol" action="">
                    <div class="btn-group mb-4" role="group">
                        <select class="form-control" name="select" onchange="this.form.submit()" id="cbxListaRol" required="">
                            <option class="menuRol" value="" >Seleccione un rol</option>
                            <?php require_once './acciones/listarRoles.php';
                            foreach($listaRoles as $rol) { ?>
                            <option class="menuRol" value="<?php echo $rol->id; ?>" <?php if(isset($_GET['select']) && $_GET['select'] == $rol->id) echo "selected"; ?> ><?php echo $rol->nombre; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <?php require_once './acciones/listarMenus.php';
                    foreach ($listaMenus as $menu) {
                        if ($menu->idMenu == null) {
                            $menuPadre = $menu->id;
                            $arrayAux = [];
                            foreach ($listaMenus as $menuHijo) {
                                if ($menuHijo->idMenu == $menuPadre) {
                                array_push($arrayAux, $menuHijo);
                                }
                            }
                            if (count($arrayAux) > 0) { ?>
                                <div class="">
                                    <ul  id="myUL">
                                        <li>
                                            <div class="caret toggle" >
                                                <label>
                                                    <input type="checkbox" onchange='checkAll(vari = <?php echo json_encode($arrayAux); ?>, this);' name="<?php echo $menu->id; ?>" id="<?php echo $menu->id; ?>">
                                                    <span class="button-indecator"></span>
                                                </label>
                                                <label class="caretAux" style="font-size: 16px">
                                                    <?php echo $menu->titulo; ?></label>
                                                . . . <i class="fa fa-caret-right"></i>
                                            </div>
                                        
                                            <ul class="nested" style="padding-left:50px; background:none">
                                            <?php foreach ($arrayAux as $menuHijoAux) { ?>
                                                <li>
                                                    <div class="toggle">
                                                        <label>
                                                            <input class="<?php echo $menu->id; ?>" type="checkbox" name="<?php echo $menuHijoAux->id; ?>" id="<?php echo $menuHijoAux->id; ?>" 
                                                            <?php if(isset($listaMenuPorRol)){
                                                                foreach ($listaMenuPorRol as $menuRol) {
                                                                    if($menuRol->idMenu == $menuHijoAux->id) {
                                                                        echo "checked";
                                                                    }
                                                                }
                                                            }?>><span class="button-indecator"></span>
                                                        </label>
                                                        <label style="font-size: 16px"><?php echo " " . $menuHijoAux->titulo; ?></label>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            <?php }else { ?>
                                <div class="toggle">
                                    <label>
                                        <input type="checkbox" name="<?php echo $menu->id ?>" id="<?php echo $menu->id ?>" <?php if(isset($listaMenuPorRol)){
                                            foreach ($listaMenuPorRol as $menuRol) {
                                                if($menuRol->idMenu == $menu->id) {
                                                    echo "checked";
                                                }
                                            }
                                        } ?>><span class="button-indecator"></span>
                                    </label>
                                    <label style="font-size: 16px"><?php echo " " . $menu->titulo; ?></label>
                                </div>
                            <?php }
                        }
                    } ?>
                    <div>
                        <button class="btn btn-primary" type="button" onclick="actualizarPermisos(this);">
                            <i class="fa fa-floppy-o"></i><span id="btnText">Actualizar permisos</span></button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</main>
<?php 
echo '<script></script>' ?>
<script src="./Assets/js/functions_menu_rol.js"></script>

<script type="text/javascript">
var toggler = document.getElementsByClassName("caret");

var i;

for (i = 0; i < toggler.length; i++) {
  toggler[i].addEventListener("click", function() {
    this.parentElement.querySelector(".nested").classList.toggle("active");
    this.classList.toggle("caret-down");
  });
}
</script>