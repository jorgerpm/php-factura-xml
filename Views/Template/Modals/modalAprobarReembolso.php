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
                                </select>
                            </div>
                            <div class="col-md-4">
                                
                                <?php $control = new razonRechazoControlador();
                                $listaRazones = $control->listar_razones_rechazo_controlador("true");
                                 ?>
                                <select id="txtRazonRechazo" name="txtRazonRechazo" class="form-control" hidden="">
                                    <option value="">Seleccione</option>
                                    <?php
                                    foreach ($listaRazones as $razonRechazo) {
                                        echo '<option value="' . str_replace("\"","", $razonRechazo->razon) . '">' . str_replace("\"","", $razonRechazo->razon) . '</option>';
                                    }
                                    ?>
                                </select>
                                
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