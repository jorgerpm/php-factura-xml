<div class="modal fade" id="modalAprobarReembolso" tabindex="1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 90%;">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Aprobar reembolsos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formModalPdf" class="FormularioAjax login-form" action="acciones/firmarPdf.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
                    
                    <embed id="archivoPdf" src="" type="application/pdf" 
                           width="100%" height="450px"  />
                    
                    <input id="txtIdDocReembolso" name="txtIdDocReembolso" style="width: 100%" type="hidden"/>
                    <input id="txtUrlDocReembolso" name="txtUrlDocReembolso" style="width: 100%" type="hidden"/>
                    <input id="txtTerceraFirma" name="txtTerceraFirma" style="width: 100%" type="hidden"/>
                    
                    <div class="tile-footer" style="text-align: end;">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label">Estado:</label>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control disable-selection btn-sm" 
                                        id="selectEstado" name="selectEstado" onchange="mostrarRazonRechazo()">
                                    <option value="">Seleccione estado</option>
                                    <option value="APROBADO" >APROBADO</option>
                                    <option value="RECHAZADO" >RECHAZADO</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input class="form-control" id="txtRazonRechazo" name="txtRazonRechazo" placeholder="RAZ&Oacute;N RECHAZO"
                                       style="text-transform: uppercase;" type="hidden"/>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary" type="button" onclick="validarSeleccion()">
                                    <i class="fa fa-fw fa-lg
                                       fa-check-circle"></i><span id="btnText">Firmar y guardar</span>
                                </button>
                                &nbsp;&nbsp;&nbsp;
                                <a class="btn btn-secondary" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                            </div>
                        </div>
                    </div>
                    <div class="RespuestaAjax"></div>
                </form>
            </div>
        </div>
    </div>
</div>