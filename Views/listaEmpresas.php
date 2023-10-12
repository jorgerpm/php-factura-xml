<?php require_once 'Template/Modals/modalEmpresa.php'; ?>
<main class="app-content">
    <div class="app-title" style="height: 50px">
        <div>
            <span class="tamañoTitulo"><i class="fa fa-bookmark-o"></i> Empresas</span>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item">Administraci&oacute;n</li>
            <li class="breadcrumb-item"><a href="#">Empresas</a></li>
        </ul>
    </div>
</div>
<div class="row espacio">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">

                <div>
                    <p><button class="btn btn-primary btn-sm fa" type="button" onclick="openModalEmpresa(null);"><i class="fas fa-plus-circle"></i> Nuevo</button></p>
                </div>
                <div>
                    <p><button style="display: none;" id="btnBuscar" name="btnBuscar" class="btn btn-primary btn-sm fa" type="button" onclick="window.location.href = ''">buscar</button></p>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th>RUC</th>
                                <th>Raz&oacute;n social</th>
                                <th>Nombre comercial</th>
                                <th>Direcci&oacute;n</th>
                                <th>Tel&eacute;fono</th>
                                <th>E-mail</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $control = new empresaControlador();
                            $listaEmpr = $control->listar_empresas_controlador();
                            foreach ($listaEmpr as $empresa) {
                                ?>
                                <tr>
                                    <td><?php echo $empresa->ruc ?></td>
                                    <td><?php echo $empresa->razonSocial ?></td>
                                    <td><?php echo $empresa->nombreComercial ?></td>
                                    <td><?php echo $empresa->direccion ?></td>
                                    <td><?php echo $empresa->telefono ?></td>
                                    <td><?php echo $empresa->email ?></td>
                                    <td><?php echo ($empresa->idEstado == 1) ? "ACTIVO" : "INACTIVO"; ?></td>

                                    <td>
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <button class="btn btn-info fa fa-edit" type="button" onclick='openModalEmpresa(variableParametro = <?php echo json_encode($empresa); ?>);'></button>
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
<script src="./Assets/js/functions_empresa.js"></script>