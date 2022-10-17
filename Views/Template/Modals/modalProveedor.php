<div class="modal fade" id="modalFormProveedor" tabindex="1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Gesti&oacute;n de proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formProveedor" class="FormularioAjax login-form" action="acciones/guardarProveedor.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" id="idProveedor" name="idProveedor" value="">
                    <p class="text-danger">Todos los campos son obligatorios.*</p>
                    <div class="form-group">
                        <label class="control-label">RUC:</label>
                        <input class="form-control" id="txtRuc" name="txtRuc" type="text" placeholder="Ruc del proveedor" required="" style="text-transform: uppercase;">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Nombre:</label>
                        <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre del proveedor" required="" style="text-transform: uppercase;">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12 col-12">
                            <label class="control-label">C&oacute;digo JD:</label>
                            <input class="form-control" id="txtCodigoJD" name="txtCodigoJD" type="text" placeholder="C&oacute;digo JD del proveedor" required="" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="tile-footer" style="text-align: end;">
                        <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg
                                                                                            fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;<a class="btn
                                                                                             btn-secondary" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                    </div>
                    <div class="RespuestaAjax"></div>
                </form>
            </div>
        </div>
    </div>
</div>