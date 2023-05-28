<?php require_once 'Template/Modals/modalUsuario.php'; ?>
<main class="app-content">
    <div class="app-title" style="height: 50px">
        <div>
            <span class="tamañoTitulo"><i class="fa fa-user-o"></i> Gestión de usuarios</span>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item">Administraci&oacute;n</li>
            <li class="breadcrumb-item"><a href="#">Gestión usuarios</a></li>
        </ul>
    </div>
</div>
<div class="row espacio">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">

                <div>
                    <p><button class="btn btn-primary btn-sm fa" type="button" onclick="openModalUsuario(null);"><i class="fas fa-plus-circle"></i> Nuevo</button></p>
                </div>
                <div>
                    <p><button style="display: none;" id="btnBuscar" name="btnBuscar" class="btn btn-primary btn-sm fa" type="button" onclick="window.location.href = ''">buscar</button></p>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <!-- th>Código</th -->
                                <th>ID empleado</th>
                                <th>Nombre</th>
                                
                                <th>C&eacute;dula</th>
                                <th>Cargo</th>
                                
                                <th>Usuario</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php require_once './acciones/listarUsuarios.php';
                            foreach ($listaUsuarios as $usuario) {
                                ?>
                                <tr>
                                    <!-- td><php echo $usuario->id ?></td -->
                                    <td><?php echo $usuario->idEmpleado ?></td>
                                    <td><?php echo $usuario->nombre ?></td>
                                    
                                    <td><?php echo $usuario->cedula ?></td>
                                    <td><?php echo $usuario->cargo ?></td>
                                    
                                    <td><?php echo $usuario->usuario ?></td>
                                    <td><?php echo $usuario->correo ?></td>
                                    <td><?php echo $usuario->nombreRol ?></td>
                                    <td><?php echo ($usuario->idEstado == 1) ? "ACTIVO" : "INACTIVO"; ?></td>
                                    <td>
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <button class="btn btn-info fa fa-edit" type="button" onclick='openModalUsuario(variableUsuario = <?php echo json_encode($usuario); ?>);'></button>
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

<script src="./Assets/js/functions_usuarios.js"></script>