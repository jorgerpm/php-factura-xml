<?php require_once 'Template/Modals/modalProveedor.php'; ?>
<main class="app-content">
    <div class="app-title" style="height: 50px">
        <div>
            <span class="tamañoTitulo"><i class="fa fa-truck"></i> Gestión de proveedores</span>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Gestión proveedores</a></li>
        </ul>
    </div>
    </div>
    <div class="row espacio">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <div>
                            <p><button class="btn btn-primary btn-sm fa" type="button" onclick="openModalProveedor(null);"><i class="fas fa-plus-circle"></i> Nuevo</button></p>
                        </div>
                        <div>
                            <p><button style="display: none;" id="btnBuscar" name="btnBuscar" class="btn btn-primary btn-sm fa" type="button" onclick="window.location.href = ''">buscar</button></p>
                        </div>
                        <table class="table table-hover table-bordered" id="sampleTable">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>RUC</th>
                                    <th>Nombre</th>
                                    <th>Código JD</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php require_once './acciones/listarProveedores.php';
                                foreach ($listaProveedores as $proveedor) { ?>
                                    <tr>
                                        <td><?php echo $proveedor->id ?></td>
                                        <td><?php echo $proveedor->ruc ?></td>
                                        <td><?php echo $proveedor->nombre ?></td>
                                        <td><?php echo $proveedor->codigoJD ?></td>
                                        <td>
                                            <div class="btn-group mr-2" role="group" aria-label="First group">
                                                <button class="btn btn-info fa fa-edit" type="button" onclick='openModalProveedor(variableProveedor = <?php echo json_encode($proveedor); ?>);'></button>
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
<script src="./Assets/js/functions_proveedores.js"></script>