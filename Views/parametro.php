<?php require_once 'Template/Modals/modalParametro.php'; ?>
<main class="app-content">
    <div class="app-title" style="height: 50px">
        <div>
            <span class="tamañoTitulo"><i class="fa fa-bookmark-o"></i> Gestión de parámetros</span>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item">Administraci&oacute;n</li>
            <li class="breadcrumb-item"><a href="#">Gestión parámetros</a></li>
        </ul>
    </div>
</div>
<div class="row espacio">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">

                <div>
                    <p><button class="btn btn-primary btn-sm fa" type="button" onclick="openModalParametro(null);"><i class="fas fa-plus-circle"></i> Nuevo</button></p>
                </div>
                <div>
                    <p><button style="display: none;" id="btnBuscar" name="btnBuscar" class="btn btn-primary btn-sm fa" type="button" onclick="window.location.href = ''">buscar</button></p>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Valor</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php require_once './acciones/listarParametros.php';
                            foreach ($listaParametros as $parametro) {
                                ?>
                                <tr>
                                    <td><?php echo $parametro->id ?></td>
                                    <td><?php echo $parametro->nombre ?></td>
                                    <td><?php echo $parametro->valor ?></td>
                                    <td><?php echo ($parametro->idEstado == 1) ? "ACTIVO" : "INACTIVO"; ?></td>

                                    <td>
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <button class="btn btn-info fa fa-edit" type="button" onclick='openModalParametro(variableParametro = <?php echo json_encode($parametro); ?>);'></button>
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
<script src="./Assets/js/functions_parametros.js"></script>