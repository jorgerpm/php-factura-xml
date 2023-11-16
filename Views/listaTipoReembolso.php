<?php require_once 'Template/Modals/modalTipoReembolso.php'; ?>
<main class="app-content">
    <div class="app-title" style="height: 50px">
        <div>
            <span class="tamañoTitulo"><i class="fa fa-bookmark-o"></i> Tipos de reembolso</span>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item">Administraci&oacute;n</li>
            <li class="breadcrumb-item"><a href="#">Tipos de reembolso</a></li>
        </ul>
    </div>
</div>
<div class="row espacio">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">

                <div>
                    <p><button style="display: none;" id="btnBuscar" name="btnBuscar" class="btn btn-primary btn-sm fa" type="button" onclick="window.location.href = ''">buscar</button></p>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Tipo reembolso</th>
                                <th>Secuencial</th>
                                <th>Nomenclatura</th>
                                <th>Usuario modifica</th>
                                <th>Fecha modifica</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $control = new tipoReembolsoControlador();
                            $lista = $control->listar_tiporeembolso_controlador(null);
                            foreach ($lista as $tipoReembolso) {
                                ?>
                                <tr>
                                    <td><?php echo $tipoReembolso->id ?></td>
                                    <td><?php echo $tipoReembolso->tipo ?></td>
                                    <td><?php echo $tipoReembolso->secuencial ?></td>
                                    <td><?php echo $tipoReembolso->nomenclatura ?></td>
                                    <td><?php echo $tipoReembolso->usuario->nombre ?></td>
                                    <td><?php echo date("d/m/Y H:i:s", $tipoReembolso->fechaModifica / 1000); ?></td>

                                    <td>
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <button class="btn btn-info fa fa-edit" type="button" onclick='openModalTipoReembolso(variableParametro = <?php echo json_encode($tipoReembolso); ?>);'></button>
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
<script src="./Assets/js/functions_tipoReembolso.js"></script>