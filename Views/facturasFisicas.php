<?php
//if(isset($_GET['numeroRC'])){
//    $solCont = new solicitudControlador();
//    $solicitudGet = $solCont->buscar_solicitud_por_numero($_GET['numeroRC']);
//} 
?>
<main class="app-content">
    <div class="app-title" style="height: 50px">
        <div>
            <span class="tamañoTitulo"><i class="fa fa-calculator"></i> Ingreso de facturas f&iacute;sicas</span>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="#">Ingreso de facturas f&iacute;sicas</a></li>
        </ul>
    </div>
    <div class="row espacio">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                    <?php
//                    $contr1sol = new solicitudControlador();
//                    $numSolicitud = $contr1sol->getUltimoCodigoSolicitud();
                    ?>

                    <form id="formFacturaFisica" autocomplete="off">
                        <div class="row" style="padding-bottom: 5px">
                            <input type="hidden" value="<?php echo isset($solicitudGet) ? $solicitudGet->id : "0" ?>" id="txtId" name="txtId">

                            <div class="col-md-2 col-sm-2 col-12">
                                <label>RUC:</label>
                            </div>
                            <div class="col-md-2 col-sm-2 col-12">
                                <input id="txtRuc" name="txtRuc" class="form-control btn-sm" style="text-transform: uppercase;" value="<?php echo isset($solicitudGet) ? $solicitudGet->codigoRC : ""; ?>" required="" 
                                       pattern="^[a-zA-Z0-9]*" />
                            </div>
                            <div class="col-md-2 col-sm-2 col-12">
                                <label>Proveedor:</label>
                            </div>
                            <div class="col-md-2 col-sm-2 col-12">
                                <input id="txtProveedor" name="txtProveedor" class="form-control btn-sm" style="text-transform: uppercase;" value="<?php echo isset($numSolicitud) ? $numSolicitud->codigoSolicitud : (isset($solicitudGet) ? $solicitudGet->codigoSolicitud : "") ?>" required=""
                                       pattern="^[a-zA-Z0-9]([a-zA-Z0-9 ]*)" minlength="4"/>
                            </div>
                            <div class="col-md-2 col-sm-2 col-12">
                                <label>Fecha factura:</label>
                            </div>
                            <div class="col-md-2 col-sm-2 col-12">
                                <input id="txtFechaFactura" name="txtFechaFactura" class="form-control btn-sm" type="date" value="<?php echo isset($solicitudGet) ? date("Y-m-d", $solicitudGet->fechaSolicitud / 1000) : date("Y-m-d"); ?>" required="">
                            </div>
                        </div>
                        
                        <div class="row" style="padding-bottom: 5px">
                            <div class="col-md-2 col-sm-2 col-12">
                                <label class="control-label">Direcci&oacute;n:</label>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <input id="txtDirecProv" name="txtDirecProv" class="form-control btn-sm" style="text-transform: uppercase;" value="<?php echo isset($solicitudGet) ? $solicitudGet->montoAprobado : "" ?>" required=""
                                       pattern="^[a-zA-Z0-9]([a-zA-Z0-9 ]*)" minlength="4" />
                            </div>
                            <div class="col-md-2 col-sm-2 col-12">
                                <label class="control-label">N&uacute;mero factura:</label>
                            </div>
                            <div class="col-md-2 col-sm-2 col-12">
                                <input id="txtNumeroFactura" name="txtNumeroFactura" class="form-control btn-sm" style="text-transform: uppercase;" value="<?php echo isset($solicitudGet) ? $solicitudGet->estadoRC : "" ?>" required=""
                                       pattern="[0-9]{3}-[0-9]{3}-[0-9]{9}" placeholder="000-000-000000000">
                            </div>
                        </div>
                        
                        <div class="row" style="padding-bottom: 5px">
                            <div class="col-md-2 col-sm-2 col-12"></div>
                            <div class="col-md-6 col-sm-6 col-12"></div>
                            <div class="col-md-2 col-sm-2 col-12">
                                <label class="control-label">Tipo documento:</label>
                            </div>
                            <div class="col-md-2 col-sm-2 col-12">
                                <select class="form-control btn-sm" id="txtTipoDocumento" name="txtTipoDocumento" required="">
                                    <option value="">Seleccione</option>
                                    <option value="01">FACTURA</option>
                                    <option value="NV">NOTA DE VENTA</option>
                                </select>
                            </div>
                        </div>
                        

                        <hr/>

                        <div class="row" style="padding-bottom: 5px">
                            <div class="col-md-2 col-sm-2 col-12">
                                <label class="control-label">Tipo Identificaci&oacute;n cliente:</label>
                            </div>
                            <div class="col-md-2 col-sm-2 col-12">
                                <select class="form-control btn-sm" id="txtTipoIdentCliente" name="txtTipoIdentCliente" required="">
                                    <option value="">Seleccione</option>
                                    <option value="04">RUC</option>
                                    <option value="05">CÉDULA</option>
                                    <option value="06">PASAPORTE</option>
                                    <option value="07">VENTA A CONSUMIDOR FINAL</option>
                                    <option value="08">IDENTIFICACIÓN DELEXTERIOR</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-2 col-12">
                                <label class="control-label">Identificaci&oacute;n cliente:</label>
                            </div>
                            <div class="col-md-2 col-sm-2 col-12">
                                <input id="txtIdentCliente" name="txtIdentCliente" class="form-control btn-sm" style="text-transform: uppercase;" value="<?php echo isset($solicitudGet) ? $solicitudGet->solicitadoPorRC : "" ?>" required=""
                                       pattern="^[a-zA-Z0-9]*" />
                            </div>
                            <div class="col-md-2 col-sm-2 col-12">
                                <label class="control-label">Nombre cliente:</label>
                            </div>
                            <div class="col-md-2 col-sm-2 col-12">
                                <input id="txtCliente" name="txtCliente" class="form-control btn-sm" style="text-transform: uppercase;" value="<?php echo isset($solicitudGet) ? $solicitudGet->unidadNegocioRC : "" ?>" required=""
                                       pattern="^[a-zA-Z0-9]([a-zA-Z0-9 ]*)" minlength="4" />
                            </div>
                        </div>


                        <div class="row" style="padding-bottom: 5px">
                            <div class="col-md-2 col-sm-2 col-12">
                                <label class="control-label">Direcci&oacute;n cliente:</label>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <input id="txtDirCliente" name="txtDirCliente" class="form-control btn-sm" style="text-transform: uppercase;" value="<?php echo isset($solicitudGet) ? $solicitudGet->autorizadoPorRC : ""; ?>" required=""
                                       pattern="^[a-zA-Z0-9]([a-zA-Z0-9 ]*)" minlength="4" />
                            </div>
                            
                            <div class="col-md-2 col-sm-2 col-12">
                                <label class="control-label">Forma de pago:</label>
                            </div>
                            <div class="col-md-2 col-sm-2 col-12">
                                <select class="form-control btn-sm" id="listFormaPago" name="listFormaPago" required="">
                                    <option value="">Seleccione</option>
                                    <option value="01">SIN UTILIZACION DEL SISTEMA FINANCIERO</option>
                                    <option value="15">COMPENSACIÓN DE DEUDAS</option>
                                    <option value="16">TARJETA DE DÉBITO</option>
                                    <option value="17">DINERO ELECTRÓNICO</option>
                                    <option value="18">TARJETA PREPAGO</option>
                                    <option value="19">TARJETA DE CRÉDITO</option>
                                    <option value="20">OTROS CON UTILIZACIÓN DEL SISTEMA FINANCIERO</option>
                                    <option value="21">ENDOSO DE TÍTULOS</option>
                                </select>
                            </div>
                        </div>

                        

                        <div class="row">
                            <div class="col-md-2 col-sm-2 col-12">
                                <button class="btn btn-primary btn-sm fa" type="button" onclick="agregarFila();" id="btnAniadir">
                                    <i class="fa fa-plus"></i> A&ntilde;adir producto</button>
                            </div>
                            <div class="col-md-7"></div>
                            <div class="col-md-3" style="text-align: end;">
                                
                            </div>
                        </div>


                        <br>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" id="tblDetSolicitud" name="tblDetSolicitud">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">X</th>
                                        <th style="width: 5%">Cantidad</th>
                                        <!-- th>C&oacute;digo producto</th -->
                                        <th>Descripci&oacute;n</th>
<!-- <th style="width:10%; text-align: center">APLICA IVA <br><input id="chkTodosIva" type="checkbox" onchange="toggle(this)"></th> -->
                                        <th style="width: 10%">Valor unitario</th>
                                        <th style="width: 10%">Descuento</th>
                                        <th style="width: 10%">Valor total</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodySol">
                                    <?php
                                    if (isset($solicitudGet)) {
                                        for ($i = 0; $i < count($solicitudGet->listaDetalles); $i++) {
                                            echo '<tr>';
                                            echo '<td><input type="number" id="txtCantidad' . ($i + 1) . '" style="width: 100%" value="' . $solicitudGet->listaDetalles[$i]->cantidad . '"></td>'
                                            . '<td><input id="txtDetalle' . ($i + 1) . '" style="width: 100%; text-transform: uppercase;" value="' . $solicitudGet->listaDetalles[$i]->detalle . '"></td>'
                                            . '<td>aqui archivo</td>'
                                            . '<td><input id="' . ($i + 1) . '" type="button" value="x" onclick="eliminarFila(this);">';
                                            echo '<input type="hidden" id="txtIdDetalle' . ($i + 1) . '" name="txtIdDetalle' . ($i + 1) . '" value="' . $solicitudGet->listaDetalles[$i]->id . '"></td>';
                                            echo '</tr>';
                                        }
                                    }
                                    ?>
                                    
                                </tbody>
                            </table>
                            
                            <table class="table table-hover table-bordered" >
                                <thead>
                                    <tr>
                                        <th style="width: 5%"></th>
                                        <th style="width: 5%"></th>
                                        <th></th>

                                        <th style="width: 10%"></th>
                                        <th style="width: 10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td style="font-weight: bold; text-align: end">DESCUENTO:</td>
                                        <td style="text-align: end"><input type="number" step="any" id="lblDescuentoTotal" name="lblDescuentoTotal" value="" required="" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td style="font-weight: bold; text-align: end">SUBTOTAL APLICA IVA:</td>
                                        <!-- <td style="text-align: end"><label id="lblSubtotal">0</label></td> -->
                                        <td style="text-align: end">
                                            <input type="number" step="any" id="lblSubtotal" name="lblSubtotal" value="" required="" onkeyup="calcularIvaTotales()"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td style="font-weight: bold; text-align: end">SUBTOTAL NO IVA:</td>
                                        <!-- <td style="text-align: end"><label id="lblSubtotalSinIva">0</label></td> -->
                                        <td style="text-align: end"><input type="number" step="any" id="lblSubtotalSinIva" name="lblSubtotalSinIva" value="" required="" onkeyup="calcularIvaTotales()" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td style="font-weight: bold; text-align: end">
                                            IVA 12%
                                            <select class="form-control btn-sm" id="txtTipoIva" required="" onchange="chdgd()"  hidden="">
                                                <!-- <option value="0">IVA 0%</option> -->
                                                <option value="2-12">IVA 12%</option>
                                                <option value="8-8">IVA 8%</option>
                                                <option value="3-14">IVA 14%</option>
                                                <!-- <option value="6-0">No Objeto de Impuesto</option>
                                                <option value="7-0">Exento de IVA</option> -->
                                            </select>
                                        </td>
                                        <!-- <td style="text-align: end"><label id="lblIva">0</label></td> -->
                                        <td style="text-align: end"><input type="number" step="any" id="lblIva" name="lblIva" value="" required="" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td style="font-weight: bold; text-align: end">TOTAL:</td>
                                        <!-- <td style="text-align: end"><label id="lblTotal">0</label></td> -->
                                        <td style="text-align: end"><input type="number" step="any" id="lblTotal" name="lblTotal" value="" required="" /></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        

                        <br>
                        <div style="text-align: center">
                            <button class="btn btn-primary" type="submit" id="btnGuardaSolic">
                                <i class="fa fa-floppy-o"></i> Guardar factura</button>
                                <button id="lkCancel" class="btn btn-secondary" onclick="window.location.href = './facturasFisicas';" data-dismiss="modal">
                                <i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</button>
                        </div>
                        <div class="RespuestaAjax" ></div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</main>

<script src="./Assets/js/functions_facturas.js"></script>