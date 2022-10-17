<div class="modal fade" id="modalFormParametro" tabindex="1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Parametro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formParametro" class="FormularioAjax login-form" action="acciones/guardarParametro.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" id="idParametro" name="idParametro" value="">
                    <p class="text-danger">Todos los campos son obligatorios.*</p>
                    <div class="form-row">
                        <div class="form-group col-md-6 col-12">
                            <label class="control-label" for="txtNombre">Nombre:</label>
                            <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre del par&aacute;metro" required style="text-transform: uppercase;">
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label class="control-label">Valor:</label>
                            <input class="form-control" id="txtValor" name="txtValor" type="text" placeholder="Valor del par&aacute;metro" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleSelect1">Estado:</label>
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
                        <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg
                                                                                            fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;<a class="btn
                                                                                             btn-secondary" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                    </div>
                    <div class="RespuestaAjax"></div>
                </form>
            </div>
        </div>
    </div>
</div>