<div class="modal fade" id="modalAnulacion" tabindex="1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Anular documento xml</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAnular" class="FormularioAjax login-form" action="acciones/anularXml.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" id="idsxml" name="idsxml" value="">
                    <div class="form-group">
                        <label class="control-label">Raz&oacute;n de anulaci&oacute;n</label>
                        
                        <?php $control = new razonRechazoControlador();
                        $listaRazones = $control->listar_razones_rechazo_controlador(true);
                         ?>
                        <select id="txtRazon" name="txtRazon" class="form-control" required="">
                            <option value="">Seleccione</option>
                            <?php
                            foreach ($listaRazones as $razonRechazo) {
                                echo '<option value="' . str_replace("\"","", $razonRechazo->razon) . '">' . str_replace("\"","", $razonRechazo->razon) . '</option>';
                            }
                            ?>
                        </select>
                        
                    </div>
                    <div class="tile-footer" style="text-align: end;">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-fw fa-lg
                               fa-check-circle"></i><span id="btnText">Guardar</span>
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