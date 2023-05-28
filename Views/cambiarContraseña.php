<section class="login-content">
    <div class="login-box" style="height: 72vh">
        <!-- sección para iniciar sesión -->
        <form id="formUsuario" class="FormCambioClave login-form" action="acciones/cambiarClave.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
            
            <div>
                <p><button style="display: none;" id="btnBuscar" name="btnBuscar" class="btn btn-primary btn-sm fa" type="button" onclick="window.location.href=''">buscar</button></p>
            </div>
            
            <!-- Ingreso contraseña actual -->
            <div class="form-group">
                <label class="control-label">Contrase&ntilde;a actual</label>
                <input class="form-control" type="password" name="txtClaveActual" placeholder="escriba la contrase&ntilde;a actual" id="txtClaveActual" required>
            </div>

            <!-- Ingreso contraseña nueva -->
            <div class="form-group">
                <label class="control-label">Contrase&ntilde;a nueva</label>
                <input class="form-control" type="password" name="txtClaveNueva" placeholder="ingrese la contrase&ntilde;a nueva" id="txtClaveNueva" required
                       pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,20}$"
                                   minlength="8" maxlength="20">
                <label class="control-label">M&iacute;nimo 8 caracteres. M&aacute;ximo 20. Al menos una letra mayúscula. Al menos una letra min&uacute;scula. 
Al menos un dígito. Y al menos uno de los siguientes caracteres ! @ $ % & * ?</label>
            </div>

            <!-- Repetir contraseña nueva -->
            <div class="form-group">
                <label class="control-label">Repetir contrase&ntilde;a</label>
                <input class="form-control" type="password" name="txtRepetirClave" placeholder="repita la contrase&ntilde;a nueva" id="txtRepetirClave" required>
            </div>

            <!-- botón para iniciar sesión -->
            <div class="form-group btn-container">
                <button class="btn btn-primary btn-block"><i class="fa fa-exchange"></i>CAMBIAR CONTRASE&Ntilde;A</button>
            </div>
            <div class="RespuestaAjax"></div>
        </form>
    </div>
</section>