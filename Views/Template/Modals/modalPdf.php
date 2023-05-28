<div class="modal fade" id="modalPdf" tabindex="1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 90%;">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Firmar pdf</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formModalPdf" class="FormularioAjax login-form" action="acciones/firmarPdf.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">

                    <embed id="archivoPdf" src="" type="application/pdf" 
                           width="100%" height="450px"  />

                    <input type="hidden" id="txtClaves" name="txtClaves" style="width: 100%"/>
                    <input type="hidden" id="txtTiposGasto" name="txtTiposGasto" style="width: 100%"/>
                    <input type="hidden" id="txtListaAsistentes" name="txtListaAsistentes" style="width: 100%"/>
                    <input type="hidden" id="txtTipoReembolso" name="txtTipoReembolso" style="width: 100%"/>

                    <div class="tile-footer" style="text-align: end;">
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div id="uno" class="col-md-2">
                                <label id="lblAprobador" class="control-label">Aprobador:</label>
                            </div>
                            <div id="dos" class="col-md-2">
                                <?php if (isset($_POST['txtTipoReembolso'])) {
                                    
                                } ?>
                                <?php
                                $usCont = new usuarioControlador();
                                $usersAprobs = $usCont->listar_usuarios_rol_controlador(3);
                                ?>
                                <select class="form-control" id="txtAprobador" name="txtAprobador" required="">
                                    <option value="">- seleccione -</option>
                                    <?php
                                    foreach ($usersAprobs as $usap) {
                                        echo '<option value="' . $usap->id . '">' . $usap->nombre . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">

                                <button id="btnActionForm" class="btn btn-primary" type="button" onclick="enviarFirmar(listaClavesAcceso)">
                                    <i class="fa fa-fw fa-lg
                                       fa-check-circle"></i><span id="btnText">Firmar y enviar</span>
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