<?php require_once 'Template/Modals/modalFirmaDigital.php'; ?>
<main class="app-content">
    <div class="app-title" style="height: 50px">
        <div>
            <span class="tamañoTitulo"><i class="fa fa-bookmark-o"></i> Gestión de firmas digital</span>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item">Administraci&oacute;n</li>
            <li class="breadcrumb-item"><a href="#">Gestión de firmas digital</a></li>
        </ul>
    </div>
</div>
<div class="row espacio">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">

                <div>
                    <p><button class="btn btn-primary btn-sm fa" type="button" onclick="openModal(null);"><i class="fas fa-plus-circle"></i> Nuevo</button></p>
                </div>
                <div>
                    <p><button style="display: none;" id="btnBuscar" name="btnBuscar" class="btn btn-primary btn-sm fa" type="button" onclick="window.location.href = ''">buscar</button></p>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Fecha caduca</th>
                                <th>Usuario</th>
                                <th>Tipo de firma</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php require_once './acciones/listarFirmasDigital.php';
                            if(isset($listaFirmas)){
                            foreach ($listaFirmas as $firma) {
                                ?>
                                <tr>
                                    <td><?php echo $firma->id ?></td>
                                    <td><?php echo Date("d/m/Y", ($firma->fechaCaducaLong/1000)) ?></td>
                                    <td><?php echo $firma->usuario->nombre ?></td>
                                    <td><?php echo $firma->tipoFirma == 0 ? "ELECTRÓNICA" : "IMAGEN"; ?></td>
                                    <td><?php echo ($firma->idEstado == 1) ? "ACTIVO" : "INACTIVO"; ?></td>

                                    <td>
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <button class="btn btn-info fa fa-edit" type="button" onclick='openModal(variableParametro = <?php echo json_encode($firma); ?>);'></button>
                                        </div>
                                    </td>
                                </tr>
<?php } 
                            }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
<script src="./Assets/js/functions_firmaDigital.js"></script>