<?php require_once 'Template/Modals/modalRazonRechazo.php'; ?>
<main class="app-content">
    <div class="app-title" style="height: 50px">
        <div>
            <span class="tamañoTitulo"><i class="fa fa-bookmark-o"></i> Razones de rechazo</span>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item">Administraci&oacute;n</li>
            <li class="breadcrumb-item"><a href="#">Razones de rechazo</a></li>
        </ul>
    </div>
</div>
<div class="row espacio">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">

                <div>
                    <p><button class="btn btn-primary btn-sm fa" type="button" onclick="openModalRazonRechazo(null);"><i class="fas fa-plus-circle"></i> Nuevo</button></p>
                </div>
                <div>
                    <p><button style="display: none;" id="btnBuscar" name="btnBuscar" class="btn btn-primary btn-sm fa" type="button" onclick="window.location.href = ''">buscar</button></p>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Razón de rechazo</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $control = new razonRechazoControlador();
                            $listaRazones = $control->listar_razones_rechazo_controlador("false");
                            foreach ($listaRazones as $razonRechazo) {
                                ?>
                                <tr>
                                    <td><?php echo $razonRechazo->id ?></td>
                                    <td><?php echo $razonRechazo->razon ?></td>
                                    <td><?php echo ($razonRechazo->idEstado == 1) ? "ACTIVO" : "INACTIVO"; ?></td>

                                    <td>
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <button class="btn btn-info fa fa-edit" type="button" onclick='openModalRazonRechazo(variableParametro = <?php echo json_encode($razonRechazo); ?>);'></button>
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
<script src="./Assets/js/functions_razonrechazo.js"></script>