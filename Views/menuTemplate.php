<!DOCTYPE html>
<html lang="en" translate="no">
    <head>
        <meta name="description" content="Sistema para carga de facturas xml">
        
        <title>Sistema para carga de facturas xml</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Main CSS-->
        <link rel="stylesheet" type="text/css" href="./Assets/css/main-modificado.css">
        <link rel="stylesheet" type="text/css" href="./Assets/css/estilosExtra.css">
        <!-- estilos para plugin datatable -->
        <link rel="stylesheet" type="text/css" href="./Assets/css/jquery.dataTables.min.css1">
        <link rel="stylesheet" type="text/css" href="./Assets/css/colReorder.dataTables.min.css">
        <!-- Font-icon css-->
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        
        <script src="./Assets/js/jquery-3.3.1.min.js"></script>
    </head>
    <body class="app sidebar-mini" lang="es" translate="no">
        <div class="loader"></div>
        <!-- Barra de navegaciój-->
        <header class="app-header"><a class="app-header__logo" href="home">Inicio</a>
            <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
            <!-- menú derecho de barra de navegación-->
            
            <ul class="app-nav">
                <div class="app-nav__item" style="text-align: right">
                <?php echo $_SESSION['Usuario']->nombre;?>
            </div>
                <!-- User Menu-->
                <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
                    <ul class="dropdown-menu settings-menu">
                        <li><a class="dropdown-item" href="cambiarContraseña"><i class="fa fa-key fa-lg"></i>Cambio contraseña</a></li>
                        <li><a class="dropdown-item" href="logout"><i class="fa fa-sign-out fa-lg"></i> Salir</a></li>
                    </ul>
                </li>
            </ul>
        </header>
        <!-- Sidebar menu-->
        <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
        <aside class="app-sidebar">
            <div class="app-sidebar__user fa fa-user-circle" style="text-align:center">
                <span class="app-sidebar__user-name tamañoTitulo"><?php echo $_SESSION['Rol']->nombre ?></span>
                <!--<p class="app-sidebar__user-designation">Frontend Developer</p>-->
            </div>
            <ul class="app-menu">
                <?php require_once './acciones/listarMenuPorRol.php';
                foreach ($listaMenuPorRol as $menu) {
                    if ($menu->idMenu == null) {
                        $menuPadre = $menu->id;
                        $arrayAux = [];
                        foreach ($listaMenuPorRol as $menuHijo) {
                            if ($menuHijo->idMenu == $menuPadre) {
                            array_push($arrayAux, $menuHijo);
                            }
                        }
                        if (count($arrayAux) > 0) { ?>
                            <li class="treeview">
                                <a class="app-menu__item" href="<?php echo $menu->link; ?>" data-toggle="treeview">
                                    <i class="app-menu__icon fa <?php echo $menu->imagen; ?>"></i>
                                    <span class="app-menu__label"><?php echo $menu->titulo; ?></span>
                                    <i class="treeview-indicator fa fa-angle-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                <?php foreach ($arrayAux as $menuHijoAux) { ?>
                                    <li style="padding-left: 5px">
                                        <a class="treeview-item" style="padding: 7px 0 7px 20px" href="<?php echo $menuHijoAux->link; ?>">
                                            <i class="icon fa <?php echo $menuHijoAux->imagen; ?>"></i><?php echo $menuHijoAux->titulo; ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                </ul>
                            </li>
                        <?php }else { ?>
                            <li><a class="app-menu__item" href="<?php echo $menu->link; ?>"><i class="app-menu__icon fa <?php echo $menu->imagen; ?>"></i><span class="app-menu__label"><?php echo $menu->titulo; ?></span></a></li>
                        <?php }
                    }
                } ?>
            </ul>
        </aside>