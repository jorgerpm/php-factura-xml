<?php include 'Template/Modals/modalEstado.php'; ?>
<main class="app-content">
    <div class="app-title" style="height: 50px">
        <div>
            <span class="tamañoTitulo"><i class="fa fa-th-list"></i> Estados</span>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item">Administraci&oacute;n</li>
            <li class="breadcrumb-item active"><a href="#">Gesti&oacute;n de estados</a></li>
        </ul>
    </div>
    <div class="row espacio">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                    <div>
                        <p><button class="btn btn-primary btn-sm fa" type="button" onclick="openModalEstado(null);"><i class="fas fa-plus-circle"></i> Nuevo</button></p>
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
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require_once './acciones/listarEstados.php';
                                foreach ($listaEstados as $estado) {
                                    ?>
                                    <tr>
                                        <td><?php echo $estado->id; ?></td>
                                        <td><?php echo $estado->nombre; ?></td>
                                        <td>
                                            <div class="btn-group mr-2" role="group" aria-label="First group">
                                                <button class="btn btn-info fa fa-edit" type="button" onclick='openModalEstado(variableEstado = <?php echo json_encode($estado); ?>);'></button>
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
<script src="./Assets/js/functions_estados.js"></script>
