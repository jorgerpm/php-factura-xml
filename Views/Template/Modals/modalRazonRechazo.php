<div class="modal fade" id="modalFormRazonRechazo" tabindex="1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Gesti&oacute;n raz&oacute;n de rechazo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formRazonRechazo" class="FormularioAjax login-form" action="acciones/guardarRazonRechazo.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" id="idRazon" name="idRazon" value="">
                    <p class="text-danger">Todos los campos son obligatorios.*</p>
                    <div class="form-row">
                        <div class="form-group col-md-12 col-12">
                            <label class="control-label" for="txtRazon">Raz&oacute;n de rechazo:</label>
                            <input class="form-control" id="txtRazon" name="txtRazon" type="text" placeholder="" required style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cbxListaEstado">Estado:</label>
                        <?php require_once './acciones/listarEstados.php'; ?>
                        <select class="form-control" id="cbxListaEstado" name="cbxListaEstado" required="">
                            <?php
                            foreach ($listaEstados as $estado) {
                                echo '<option value="' . $estado->id . '">' . $estado->nombre . '</option>';
                            }
                            ?>
                        </select>
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