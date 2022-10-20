<?php include 'Template/Modals/modalMenu.php'; ?>
<main class="app-content">
    <div class="app-title" style="height: 50px">
        <div>
            <h1><i class="fa fa-dashboard"></i> Menús</h1>
            <p>Editar y crear menús</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item">Administraci&oacute;n</li>
            <li class="breadcrumb-item active"><a href="#">Gesti&oacute;n de men&uacute;s</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                    <div>
                        <p><button class="btn btn-primary btn-sm fa" type="button" onclick="openModalMenu(null);"><i class="fas fa-plus-circle"></i> Nuevo</button></p>
                    </div>
                    <div>
                        <p><button style="display: none;" id="btnBuscar" name="btnBuscar" class="btn btn-primary btn-sm fa" type="button" onclick="window.location.href = ''">buscar</button></p>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Título</th>
                                    <th>Link</th>
                                    <th>Imagen</th>
                                    <th>idMenu</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php require_once './acciones/listarMenus.php';
                                foreach ($listaMenus as $menu) {
                                    ?>
                                    <tr>
                                        <td><?php echo $menu->id ?></td>
                                        <td><?php echo $menu->titulo ?></td>
                                        <td><?php echo $menu->link ?></td>
                                        <td><?php echo $menu->imagen ?></td>
                                        <td><?php echo $menu->idMenu ?></td>
                                        <td><?php echo $menu->idEstado ?></td>
                                        <td>
                                            <div class="btn-group mr-2" role="group" aria-label="First group">
                                                <button class="btn btn-info fa fa-edit" type="button" onclick='openModalMenu(variableMenu = <?php echo json_encode($menu); ?>);'></button>
                                            </div>
                                        </td>
                                    </tr>
<?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="./Assets/js/functions_menus.js"></script>