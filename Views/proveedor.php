<?php require_once 'Template/Modals/modalProveedor.php'; ?>
<main class="app-content">
    <div class="app-title" style="height: 50px">
        <div>
            <span class="tamañoTitulo"><i class="fa fa-truck"></i> Gestión de proveedores</span>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Gestión de proveedores</a></li>
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
                        <table class="table table-hover table-bordered" id="tablaProveedores">
                            <thead>
                                <tr>
                                    <!--th>Código</th-->
                                    <th>RUC</th>
                                    <th>Nombre</th>
                                    <th>Código JD</th>
                                    <th></th>
                                </tr>
                            </thead>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="./Assets/js/functions_proveedores.js"></script>

<!-- Data table plugin-->
<script type="text/javascript" src="./Assets/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="./Assets/js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
        $('#tablaProveedores').DataTable({
        //scrollY: '34vh',
        //scrollCollapse: true,
        language: {
            lengthMenu: 'Mostrar _MENU_ registros por p&aacute;gina',
//            zeroRecords: 'No existen registros',
//            info: 'Mostrando p&aacute;gina _PAGE_ de _PAGES_',
//            infoEmpty: 'No existen registros',
//            infoFiltered: '(filtrados de los _MAX_ registros totales)',
            search: 'Buscar por nombre: ',
            paginate:{
                previous: '&laquo',
                next: '&raquo;',
            },
        },
        lengthMenu: [
            [10, 25, 50, 100], //cantidad
            [10, 25, 50, 100],//texto que se muestra
        ],
        processing: true, //indica el texto processing cuando se esta cargando la tabla
        serverSide: true,
        ajax: {
            url: './acciones/listarProveedores.php',
            type: 'POST',
        },
    });
    </script>