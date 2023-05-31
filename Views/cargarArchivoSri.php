<main class="app-content">
    <div class="app-title" style="height: 50px">
        <div>
            <span class="tamañoTitulo"><i class="fa fa-upload"></i> Cargar archivo del sri</span>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="#">Cargar archivo del sri</a></li>
        </ul>
    </div>
    <!-- Cargar archivo txt -->
    <div class="container tile espacio">		
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="inputFileTxt" class="btn btn-primary btn-sm">Seleccione el archivo .txt</label>
                            <input type="file" name="" class="btn btn-primary btn-sm" id="inputFileTxt" accept=".txt" style="display:none" required="">
                        </div>
                        <div class="col-sm-4">
                            <label id="archivoTxt" style="word-break:break-word;"></label>
                        </div>
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-primary btn-sm" onclick="cargaArchivoSri();" title="Muestra el contenido del archivo">
                                <i class="fa fa-upload1"></i> Mostrar registros</button>
                        </div>
                    </div>
                    
                </div>
                

                <div class="form-group">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead id="headSri">
                                <tr>
                                    
                                    <th>#</th>
                                    <th><input id="chkTodos" type="checkbox" class="" onchange="selectTodos(this)"/></th>
                                    <th>RESULTADO</th>
                                    <th>Estado sistema</th>
                                    
                                    <!-- <th>COMPROBANTE</th>
                                    <th>SERIE_COMPROBANTE</th>
                                    <th>RUC_EMISOR</th>
                                    <th>RAZON_SOCIAL_EMISOR</th>
                                    <th>FECHA_EMISION</th>
                                    <th>FECHA_AUTORIZACION</th>
                                    
                                    <th>TIPO_EMISION</th>
                                    <th>IDENTIFICACION_RECEPTOR</th>
                                    <th>CLAVE_ACCESO</th>
                                    <th>NUMERO_AUTORIZACION</th>
                                    <th>IMPORTE_TOTAL</th> -->
                                </tr>
                            </thead>
                            <tbody id="dataSri">
                                
                            </tbody>
                        </table>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-3">
                            <button class="btn btn-primary" type="button" onclick="enviarFacturasServer(<?php echo $_SESSION['Usuario']->id; ?>)">CARGAR FACTURAS</button>
                        </div>
                        <div class="col-md-3">
                            <!-- select style="/*position:absolute; right:0;bottom:0;*/" class="form-control disable-selection btn-sm" 
                                        id="txtTipoPdf" name="txtTipoPdf">
                                    
                                    <option value="">Seleccione</option>
                                    
                                    <option value="01" <php echo ((isset($_POST['txtTipoPdf']) && $_POST['txtTipoPdf'] == "01") ? 'selected' : ''); ?> >LIQUIDACION DE GASTO DE VIAJES</option>
                                    <option value="02" ?php echo ((isset($_POST['txtTipoPdf']) && $_POST['txtTipoPdf'] == "02") ? 'selected' : ''); ?> >REEMBOLSO DE GASTOS</option>
                                    
                                </select -->
                        </div>
                        <div class="col-md-3">
                            <!-- button class="btn btn-primary" type="button" 
                                    onclick="ejecutarReporteFirma(listaClavesAcceso)" >GENERAR PDF</button>
                            <!-- button class="btn btn-primary" type="button" 
                                    onclick="enviarSeleccionados(<php echo $_SESSION['Usuario']->id; ?>)">GENERAR PDF</button -->
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    
                </div>
                <div class="RespuestaAjax"></div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'Template/Modals/modalPdf.php'; ?>

<script src="./Assets/js/functions_cargaArchivoSri.js"></script>

