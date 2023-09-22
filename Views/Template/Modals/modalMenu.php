<div class="modal fade" id="modalFormMenu" tabindex="1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Gesti&oacute;n de men&uacute;</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formMenu" class="FormularioAjax login-form" action="acciones/guardarMenu.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" id="idMenu" name="idMenu" value="">
                    <p class="text-danger">Todos los campos son obligatorios.*</p>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label">T&iacute;tulo</label>
                            <input class="form-control" id="txtTitulo" name="txtTitulo" type="text" placeholder="T&iacute;tulo del men&uacute;" required="" style="text-transform: uppercase;">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Link</label>
                            <input class="form-control" id="txtLink" name="txtLink" type="text" placeholder="Link del men&uacute;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Im&aacute;gen</label>
                        <input class="form-control" id="txtImagen" name="txtImagen" type="text" placeholder="Im&aacute;gen del men&uacute;">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="exampleSelect1">Estado</label>
                            <?php require_once './acciones/listarEstados.php'; ?>
                            <select class="form-control" id="cbxListaMenu" name="cbxListaMenu" required="">
                                <?php
                                foreach ($listaEstados as $estado) {
                                    echo '<option value="' . $estado->id . '">' . $estado->nombre . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleSelect1">Men&uacute;</label>
                            <select class="form-control" id="cbxListaEstado" name="cbxListaEstado" required="">
                                <option value="0">seleccione</option>
                            </select>
                        </div>
                    </div>
                    <div class="tile-footer" style="text-align: end;">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg
                                                                                            fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;<a class="btn
                                                                                             btn-secondary" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                    </div>
                    <div class="RespuestaAjax"></div>
                </form>
            </div>
        </div>
    </div>
</div>