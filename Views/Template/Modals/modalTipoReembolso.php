<div class="modal fade" id="modalTipoReembolso" tabindex="1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Tipos de reembolso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formTipoReembolso" class="FormularioAjax login-form" action="acciones/guardarTipoReembolso.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
                    
                    <input type="hidden" id="idTipoReembolso" name="idTipoReembolso" value="">
                    <input type="hidden" id="txtEsPrincipal" name="txtEsPrincipal" value="">
                    
                    <p class="text-danger">Todos los campos son obligatorios.*</p>
                    <div class="form-row">
                        <div class="form-group col-md-12 col-12">
                            <label class="control-label" for="txtTipo">Tipo de reembolso:</label>
                            <input class="form-control" id="txtTipo" name="txtTipo" type="text" placeholder="" required style="text-transform: uppercase;" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="txtSecuencial">Secuencial:</label>
                        <input class="form-control" id="txtSecuencial" name="txtSecuencial" type="number" placeholder="" required >
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="txtNomenclatura">Nomenclatura:</label>
                        <input class="form-control" id="txtNomenclatura" name="txtNomenclatura" type="text" placeholder="" required style="text-transform: uppercase;">
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