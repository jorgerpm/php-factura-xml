<div class="modal fade" id="modalFirmaDigital" tabindex="1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nueva firma digital</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formFirmaDigital" class="FormularioAjax login-form" action="acciones/guardarFirmaDigital.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" id="idFirmaDigital" name="idFirmaDigital" value="">
                    <p class="text-danger">Todos los campos son obligatorios.*</p>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6 col-12">
                            <label class="control-label" for="txtTipoFirma">Tipo de firma:</label>
                            <select class="form-control" id="txtTipoFirma" name="txtTipoFirma" required="" onchange="cambioTipoFirma()">
                                <option value="">- seleccione -</option>
                                <option value="0">ELECTRÓNICA</option>
                                <?php $gg=false; if($gg == true){ //para quitar esta linea?>
                                <option value="1">IMAGEN</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label class="control-label" for="txtArchivo">Archivo:</label>
                            <input class="form-control" id="txtArchivo" name="txtArchivo" type="file" required >
                        </div>
                    </div>
                    
                    
                    <div class="form-row">
                        <div class="form-group col-md-6 col-12">
                            <label class="control-label">Fecha caduca:</label>
                            <input class="form-control" id="txtFecha" name="txtFecha" type="date" placeholder="Fecha" required="">
                        </div>
                        <div class="form-group col-md-6 col-12">
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
                    </div>
                    
                    <?php if($_SESSION["Rol"]->id == 1){ ?>
                    <div class="form-row">
                        <div class="form-group col-md-6 col-12">
                            <label for="cbxListUser">Usuario:</label>
                            <?php require_once './acciones/listarUsuariosActivos.php'; ?>
                            <select class="form-control" id="cbxListUser" name="cbxListUser" required="">
                                <?php
                                foreach ($listaUsuarios as $user) {
                                    if($user->idEstado == 1){
                                        if($_SESSION["Rol"]->id == 1){
                                            echo '<option value="' . $user->id . '">' . $user->nombre . '</option>';
                                        }
                                        else{
                                            if($user->id == $_SESSION["Usuario"]->id){
                                                echo '<option value="' . $user->id . '" selected>' . $user->nombre . '</option>';
                                                break;
                                            }
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6 col-12"></div>
                    </div>
                    <?php } ?>
                    
                    
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