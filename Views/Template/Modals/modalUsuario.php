<div class="modal fade" id="modalFormUsuario" tabindex="1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formUsuario" class="FormularioAjax login-form" action="acciones/guardarUsuario.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" id="idUsuario" name="idUsuario" value="">
                    <p class="text-danger">Todos los campos son obligatorios.*</p>
                    <input name="txtClaveAux" id="txtClaveAux" value="" hidden="">
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label">ID empleado:</label>
                            <input class="form-control" id="idEmpleado" name="idEmpleado" type="text" placeholder="ID emplead" required="" style="text-transform: uppercase;">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">C&eacute;dula:</label>
                            <input class="form-control" id="txtCedula" name="txtCedula" type="text" placeholder="Cédula" required="">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Nombre:</label>
                            <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre y apellido" required="" style="text-transform: uppercase;">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Cargo:</label>
                            <input class="form-control" id="txtCargo" name="txtCargo" type="text" placeholder="Cargo" required="" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="form-row">
                        
                        <div class="form-group col-md-6">
                            <label class="control-label">Usuario:</label>
                            <input class="form-control" id="txtUsuario" name="txtUsuario" type="text" placeholder="Nombre de usuario" required="">
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label class="control-label">Clave:</label>
                            <div class="input-group">
                                <input class="form-control" id="txtClave" name="txtClave" type="password" placeholder="CLAVE" required="" 
                                   pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,20}$"
                                   minlength="8" maxlength="20">
                                <div class="input-group-append">
            <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
          </div>
                            </div>
                            <label class="control-label">M&iacute;nimo 8 caracteres. M&aacute;ximo 20. Al menos una letra mayúscula. Al menos una letra min&uacute;scula. 
Al menos un dígito. Y al menos uno de los siguientes caracteres ! @ $ % & * ?</label>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Correo:</label>
                            <input class="form-control" id="txtCorreo" name="txtCorreo" type="email" placeholder="Correo electrónico" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="listaRol">Rol:</label>
                            <?php require_once './acciones/listarRoles.php'; ?>
                            <select class="form-control" id="cbxListaRol" name="cbxListaRol" required="">
                                <?php
                                foreach ($listaRoles as $rol) {
                                    echo '<option value="' . $rol->id . '">' . $rol->nombre . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="listaEstado">Estado:</label>
                            <?php require_once './acciones/listarEstados.php'; ?>
                            <select class="form-control" id="cbxListaEstado" name="cbxListaEstado" required="">
                                <?php
                                foreach ($listaEstados as $estado) {
                                    echo '<option value="' . $estado->id . '">' . $estado->nombre . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6"></div>
                    </div>
                    
                    <div class="tile-footer" style="text-align: end;">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span>
                        </button>&nbsp;&nbsp;&nbsp;

                        <a class="btn btn-secondary" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                    </div>
                    <div class="RespuestaAjax"></div>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
function mostrarPassword(){
		var cambio = document.getElementById("txtClave");
		if(cambio.type == "password"){
			cambio.type = "text";
			$('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		}else{
			cambio.type = "password";
			$('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
	} 
	
	$(document).ready(function () {
	//CheckBox mostrar contraseña
	$('#ShowPassword').click(function () {
		$('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
	});
});
</script>