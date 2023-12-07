<div class="modal fade" id="modalFirmaLiquidacion" tabindex="1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 90%;">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Aprobar reembolsos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formModalFirmaLiquidacion" class="FormularioAjax login-form" action="acciones/firmarLiquidacionCompra.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
                    
                    <embed id="archivoPdfLC" src="" type="application/pdf" 
                           width="100%" height="450px"  />
                    
                    <input id="txtIdReembs" name="txtIdReembs" style="width: 100%" type="hidden"/>
                    <input id="txtUrlLiquidacion" name="txtUrlLiquidacion" style="width: 100%" type="hidden"/>
                    
                    
                    <div class="tile-footer" style="text-align: end;">
                        <div class="row">
                            <div class="col-md-7">
                                
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary" type="button" onclick="solicitarClaveFirmaLC()">
                                    <i class="fa fa-fw fa-lg
                                       fa-check-circle"></i><span id="btnText">Firmar y guardar</span>
                                </button>
                            </div>
                            <div class="col-md-2">
                                <a class="btn btn-secondary" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                            </div>
                        </div>
                    </div>
                    <div class="RespuestaAjax"></div>
                </form>
                <?php require_once 'modalClaveFirmaLiquidacion.php'; ?>
            </div>
        </div>
    </div>
</div>

