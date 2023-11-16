<div class="modal fade" id="modalDatosReemb" tabindex="1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Datos para reembolso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formDatosReemb" class="login-form" action="" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
                    
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="control-label">Motivo del viaje:</label>
                            <input class="form-control" id="txtMotivoViaje" name="txtMotivoViaje" type="text" required="" style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Periodo del viaje:</label>
                            <input class="form-control" id="txtPeriodoViaje" name="txtPeriodoViaje" type="text" required="" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="control-label">Lugar del viaje:</label>
                            <input class="form-control" id="txtLugarViaje" name="txtLugarViaje" type="text" required="" style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-6">
                            <label id="lblValorEntregado" class="control-label">Valor entregado:</label>
                            <input class="form-control" id="txtValorEntregado" name="txtValorEntregado" type="number" step="any" required="" style="text-transform: uppercase;">
                        </div>
                    </div>
                    
                    
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="control-label">N&uacute;mero RC:</label>
                            <input class="form-control" id="txtNumeroRC" name="txtNumeroRC" type="text" required="" style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label id="lblObservaciones" class="control-label">Observaciones:</label>
                        <input class="form-control" id="txtObservaciones" name="txtObservaciones" type="text" style="text-transform: uppercase;">
                    </div>
                    
                    <div class="form-group">
                        <label id="lblSeleccion" class="control-label">Selección:</label>
                        
                        <select class="form-control" id="txtSeleccion" name="txtSeleccion" required="" onchange="cambiarValor()">
                                
                                <option value="">- seleccione -</option>
                                <?php 
                                $control = new tipoReembolsoControlador();
                                $lista2 = $control->listar_tiporeembolso_controlador("false");
                                foreach ($lista2 as $tipoReembolso) {
                                    echo '<option value="'.$tipoReembolso->id.'">'.$tipoReembolso->tipo.'</option>';
                                } ?>
                                
                            </select>
                        
                    </div>
                    
                    
                    <div class="tile-footer" style="text-align: end;">
                        <button class="btn btn-primary" type="button" onclick="ejecutarReporteFirma(listaClavesAcceso);">
                            <i class="fa fa-fw fa-lg
                               fa-check-circle"></i><span id="btnText">Generar PDF</span>
                        </button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>