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
                        <div class="col-sm-3">
                            
                            <select id="selectTiposComprobs" class="form-control" onchange="cambiarMostrarDocs();">
                                <option value="">Todos</option>
                                <option value="Comprobante de Retención">Comprobante de Retención</option>
                                <option value="Factura">Factura</option>
                                <option value="Notas de Crédito">Notas de Crédito</option>
                            </select>
                        </div>
                        <div class="col-sm-3" style="text-align: right">
                            <label for="inputFileTxt" class="btn btn-primary btn-sm">Seleccione el archivo .txt</label>
                            <input type="file" name="" class="btn btn-primary btn-sm" id="inputFileTxt" accept=".txt" style="display:none" required="">
                        </div>
                        <div class="col-sm-3">
                            <label id="archivoTxt" style="word-break:break-word;"></label>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-primary btn-sm" onclick="cargaArchivoSri();" title="Muestra el contenido del archivo">Mostrar registros</button>
                        </div>
                    </div>
                    
                </div>
                

                <div class="form-group">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead id="headSri">
                                <tr>
                                    
                                    <th>#</th>
                                    <th><input id="chkTodos" type="checkbox" class="" onchange="selectTodosXmlSri(this)"/></th>
                                    <th>RESULTADO</th>
                                    <th>Estado sistema</th>
                                    
                                    <!--<th>COMPROBANTE</th>
                                    <th>SERIE_COMPROBANTE</th>
                                    <th>RUC_EMISOR</th>
                                    <th>RAZON_SOCIAL_EMISOR</th>
                                    <th>FECHA_EMISION</th>
                                    <th>FECHA_AUTORIZACION</th>
                                    
                                    <th>TIPO_EMISION</th>
                                    <th>IDENTIFICACION_RECEPTOR</th>
                                    <th>CLAVE_ACCESO</th>
                                    <th>NUMERO_AUTORIZACION</th>
                                    <th>IMPORTE_TOTAL</th>-->
                                </tr>
                            </thead>
                            <tbody id="dataSri">
                                
                            </tbody>
                        </table>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-4">
                            <button class="btn btn-primary" type="button" onclick="enviarFacturasServer(<?php echo $_SESSION['Usuario']->id; ?>)">CARGAR COMPROBANTES</button>
                        </div>
                        <div class="col-md-2">
                           
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



<script src="./Assets/js/functions_cargaArchivoSri.js"></script>

