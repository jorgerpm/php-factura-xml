<div class="modal fade" id="modalFormEmpresa" tabindex="1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Gesti&oacute;n empresa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEmpresa" class="FormularioAjax login-form" action="acciones/guardarEmpresa.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" id="idEmpresa" name="idEmpresa" value="">
                    <p class="text-danger">Todos los campos son obligatorios.*</p>
                    <div class="form-row">
                        <div class="form-group col-md-6 col-12">
                            <label class="control-label" for="txtRuc">RUC:</label>
                            <input class="form-control" id="txtRuc" name="txtRuc" type="text" placeholder="" required style="text-transform: uppercase;"
                                   minlength="13" maxlength="13"  pattern="^[0-9]*">
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label class="control-label" for="txtRazonSocial">Raz&oacute;n social:</label>
                            <input class="form-control" id="txtRazonSocial" name="txtRazonSocial" type="text" placeholder="" required style="text-transform: uppercase;">
                        </div>
                    </div>
                    
                    
                    <div class="form-row">
                        <div class="form-group col-md-6 col-12">
                            <label class="control-label" for="txtNombreComercial">Nombre comercial:</label>
                            <input class="form-control" id="txtNombreComercial" name="txtNombreComercial" type="text" placeholder="" style="text-transform: uppercase;">
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label class="control-label" for="txtTelefono">Tel&eacute;fono:</label>
                            <input class="form-control" id="txtTelefono" name="txtTelefono" type="number" placeholder="" >
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6 col-12">
                            <label class="control-label" for="txtDireccion">Direcci&oacute;n:</label>
                            <input class="form-control" id="txtDireccion" name="txtDireccion" type="text" placeholder="" style="text-transform: uppercase;">
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label class="control-label" for="txtEmail">E-mail:</label>
                            <input class="form-control" id="txtEmail" name="txtEmail" type="email" placeholder="">
                        </div>
                    </div>
                    
                    
                    
                    <div class="form-group">
                        <label for="cbxListaEstado">Estado:</label>
                        <?php require_once './acciones/listarEstados.php'; ?>
                        <select class="form-control" id="cbxListaEstado" name="cbxListaEstado" required="">
                            <?php
                            foreach ($listaEstados as $estado) {
                                echo '<option value="' . $estado->id . '">' . $estado->nombre . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="tile-footer" style="text-align: end;">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-fw fa-lg fa-check-circle"></i>
                            <span id="btnText">Guardar</span>
                        </button>&nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="#" data-dismiss="modal">
                            <i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                    </div>
                    <div class="RespuestaAjax"></div>
                </form>
            </div>
        </div>
    </div>
</div>