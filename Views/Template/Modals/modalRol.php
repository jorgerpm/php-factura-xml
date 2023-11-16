<div class="modal fade" id="modalFormRol" tabindex="1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Gesti&oacute;n de rol</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formRol" class="FormularioAjax login-form" action="acciones/guardarRol.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" id="idRol" name="idRol" value="">
                    <p class="text-danger">Todos los campos son obligatorios.*</p>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Nombre:</label>
                            <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre del rol" required="" style="text-transform: uppercase;">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleSelect1">Estado:</label>
                            <?php require_once './acciones/listarEstados.php'; ?>
                            <select class="form-control" id="listStatus" name="listStatus" required="">
                                <?php
                                foreach ($listaEstados as $estado) {
                                    echo '<option value="' . $estado->id . '">' . $estado->nombre . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="control-label">Listar de todos los usuarios:</label>
                            <div class="toggle">
                                <label>
                                    <input type="checkbox" name="chkPrincipal" id="chkPrincipal"><span class="button-indecator"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label">Aprobador?:</label>
                            <div class="toggle">
                                <label>
                                    <input type="checkbox" name="chkAutorizador" id="chkAutorizador" /><span class="button-indecator"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label">Ver datos contador?:</label>
                            <div class="toggle">
                                <label>
                                    <input type="checkbox" name="chkDatosContable" id="chkDatosContable" /><span class="button-indecator"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Seleccione los tipos documentos a consultar:</label>
                    </div>

                    <div class="form-row">
                        <div class="col-md-2"> 
                            <label class="control-label">Factura:</label>
                            <div class="toggle" style="margin-top: 20px">
                                <label>
                                    <input type="checkbox" name="bFactura" id="bFactura" checked=""/><span class="button-indecator"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label">Retenci&oacute;n:</label>
                            <div class="toggle" style="margin-top: 20px">
                                <label>
                                    <input type="checkbox" name="bRetencion" id="bRetencion" checked=""/><span class="button-indecator"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label">Nota cr&eacute;dito:</label>
                            <div class="toggle">
                                <label>
                                    <input type="checkbox" name="bNotaCredito" id="bNotaCredito" checked=""/><span class="button-indecator"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label">Nota d&eacute;bito:</label>
                            <div class="toggle">
                                <label>
                                    <input type="checkbox" name="bNotaDebito" id="bNotaDebito" checked=""/><span class="button-indecator"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label">Gu&iacute;a remisi&oacute;n:</label>
                            <div class="toggle">
                                <label>
                                    <input type="checkbox" name="bGuiaRemision" id="bGuiaRemision" checked=""/><span class="button-indecator"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Empresas:</label>
                            <table style="width: 100%" class="table table-bordered">
                                <thead><tr>
                                <th>Selec.</th>
                                <th>RUC</th>
                                <th>Raz&oacute;n social</th>
                                </tr></thead>
                                <tbody>
                            <?php
                            $contEm = new empresaControlador();
                            $listEmp = $contEm->listar_empresas_controlador();
                            
                            foreach ($listEmp as $empresa) {
                                echo '<tr>';
                                echo '<td style="text-align: center;"><input id="'.$empresa->id,'" type="checkbox" name="'.$empresa->id.'" '
                                        . 'onclick="ingresarEmpresaLista(this);" /></td>';
                                //para que funcion enel echo debe estar encerrado entre ".." (comillas dobles, no simples)
                                //sin concatenar con punto
                                echo "<td>$empresa->ruc</td>";
                                echo "<td>$empresa->razonSocial</td>";
                                echo '</tr>';
                            }
                            ?>
                                </tbody>
                            </table>
                            <input id="txtListaEmpresas" name="txtListaEmpresas" type="hidden" />
                        </div>
                    </div>
                    

                    <br/>
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