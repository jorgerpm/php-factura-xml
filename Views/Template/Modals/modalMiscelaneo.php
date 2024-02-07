<div class="modal fade" id="modalFormMiscelaneo" tabindex="1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Ingresar miscel&aacute;neos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formMiscelaneo" class="FormularioAjax login-form" action="acciones/guardarMiscelaneo.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
                    
                    <p class="text-danger">Todos los campos son obligatorios.*</p>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6 col-12">
                            <label class="control-label" for="txtFecha">Fecha:</label>
                            <input class="form-control" id="txtFecha" name="txtFecha" type="date" required />
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label class="control-label" for="txtRuc">RUC:</label>
                            <input class="form-control" id="txtRuc" name="txtRuc" required value="<?php echo $_SESSION['Usuario']->cedula ?>" readonly=""/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6 col-12">
                            <label class="control-label" for="txtConcepto">Concepto:</label>
                            <input class="form-control" id="txtConcepto" name="txtConcepto" required style="text-transform: uppercase;" />
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label class="control-label" for="txtValor">Valor:</label>
                            <input class="form-control" id="txtValor" name="txtValor" type="number" step="any" required />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6 col-12">
                            <label class="control-label" for="txtObservacion">Observaci&oacute;n:</label>
                            <input class="form-control" id="txtObservacion" name="txtObservacion"  style="text-transform: uppercase;" />
                        </div>
                        <div class="form-group col-md-6 col-12">
                            
                            <input type="file" name="inputFileXml" class="btn btn-primary" id="inputFileXml" >
                        </div>
                    </div>
                    
                    <div class="tile-footer" style="text-align: end;">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle">
                            </i><span id="btnText">Guardar</span>
                        </button>&nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                    </div>
                    <div class="RespuestaAjax"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var inputFileXml = $("#inputFileXml");
    inputFileXml.on('change', function (e) {
        if(e.target.files[0].size > 5000000){
            swal('','El archivo supera los 5MB.','warning');
            inputFileXml.val(null);
        }
    });
</script>