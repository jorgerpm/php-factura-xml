<div class="modal fade" id="modalDatosConta" tabindex="1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Datos para contador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formDatosConta" class="FormularioAjax login-form" action="acciones/guardarDatosContabilidad.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
                    
                    <input id="idReemb" name="idReemb" type="hidden">
                    
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="control-label">No.Batch del ingreso de liquidación:</label>
                            <input class="form-control" id="batchIngresoLiquidacion" name="batchIngresoLiquidacion" type="text" required="" style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">No. Batch documentos internos:</label>
                            <input class="form-control" id="batchDocumentoInterno" name="batchDocumentoInterno" type="text" required="" style="text-transform: uppercase;">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="control-label">P3:</label>
                            <input class="form-control" id="p3" name="p3" type="text" required="" style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">P4:</label>
                            <input class="form-control" id="p4" name="p4" type="text" step="any" required="" style="text-transform: uppercase;">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="control-label">P5:</label>
                            <input class="form-control" id="p5" name="p5" type="text" required="" style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">PH/NE:</label>
                            <input class="form-control" id="phne" name="phne" type="text" required="" style="text-transform: uppercase;">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="control-label">Cruce:</label>
                            <input class="form-control" id="cruce1" name="cruce1" type="text" required="" style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Cruce2:</label>
                            <input class="form-control" id="cruce2" name="cruce2" type="text" required="" style="text-transform: uppercase;">
                        </div>
                    </div>
                    
                    
                    
                    
                    
                    <div id="divTipoGastos">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="control-label">JUSTIFICATIVOS:</label>
                                <input class="form-control" id="justificativos" name="justificativos" type="text" required="" style="text-transform: uppercase;">
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">TIPO DOCUMENTO:</label>
                                <input class="form-control" id="tipoDocumento" name="tipoDocumento" type="text" required="" style="text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="control-label">NÚMERO DE DOCUMENTO:</label>
                                <input class="form-control" id="numeroDocumento" name="numeroDocumento" type="text" required="" style="text-transform: uppercase;">
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">NÚMERO DE RETENCIÓN:</label>
                                <input class="form-control" id="numeroRetencion" name="numeroRetencion" type="text" required="" style="text-transform: uppercase;">
                            </div>
                        </div>
                    </div>
                    
                    <div class="tile-footer" style="text-align: end;">
                        <button id="btnActionForm" class="btn btn-primary" type="submit" >
                            <i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span>
                        </button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                    </div>
                    
                    <div class="RespuestaAjax"></div>
                    
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    
$('.formDatosConta').submit(function (e) {
    const LOADING = document.querySelector('.loader');
    LOADING.style = 'display: flex;';
    
    e.preventDefault(); //no se envíe el submit todavía
    
    var form = $(this);

    var accion = form.attr('action');
    var metodo = form.attr('method');
    var respuesta = form.children('.RespuestaAjax');

    var formdata = new FormData(this);

    $.ajax({
        type: metodo,
        url: accion,
        data: formdata ? formdata : form.serialize(),
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            
            LOADING.style = 'display: none;';
                
            //if(!data.includes("window.location.href"))
            
            respuesta.html(data);
        },
        error: function (error) {
            LOADING.style = 'display: none;';
            
            respuesta.html(error);
        }
    });
});
</script>