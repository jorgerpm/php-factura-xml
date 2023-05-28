<main class="app-content">
    <div class="app-title" style="height: 50px">
        <div>
            <span class="tamañoTitulo"><i class="fa fa-upload"></i> Cargar documentos xml</span>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="#">Cargar documentos xml</a></li>
        </ul>
    </div>
    <!-- Cargar archivo xml -->
    <div class="container tile espacio">		
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="form-group">
                    
                    <div class="row">
                        <div class="col-sm-2">
                            <label for="txtTipoDoc" class="control-label">Tipo documento</label>
                        </div>
                        <div class="col-sm-3">
                            <select style="/*position:absolute; right:0;bottom:0;*/" class="form-control disable-selection btn-sm" 
                                        id="txtTipoDoc" name="txtTipoDoc">
                                    
                                    <option value="">Seleccione</option>
                                    
                                    <option value="01" <?php echo ((isset($_POST['txtTipoDoc']) && $_POST['txtTipoDoc'] == "01") ? 'selected' : ''); ?> >FACTURA</option>
                                    <option value="06" <?php echo ((isset($_POST['txtTipoDoc']) && $_POST['txtTipoDoc'] == "06") ? 'selected' : ''); ?> >GUIA_REMISION</option>
                                    <option value="04" <?php echo ((isset($_POST['txtTipoDoc']) && $_POST['txtTipoDoc'] == "04") ? 'selected' : ''); ?> >NOTA_CREDITO</option>
                                    <option value="05" <?php echo ((isset($_POST['txtTipoDoc']) && $_POST['txtTipoDoc'] == "05") ? 'selected' : ''); ?> >NOTA_DEBITO</option>
                                    <option value="07" <?php echo ((isset($_POST['txtTipoDoc']) && $_POST['txtTipoDoc'] == "07") ? 'selected' : ''); ?> >RETENCION</option>
                                    
                                </select>
                        </div>
                        <div class="col-sm-7">
                        </div>
                    </div>
                    <br/>
                    
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="inputFileXml" class="btn btn-primary">Seleccione archivo xml</label>
                            <input type="file" name="" class="btn btn-primary" id="inputFileXml" accept=".xml" style="display:none" required="">
                        </div>
                        <div class="col-sm-8">
                            <label id="archivoXml" style="word-break:break-word;"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-12">
                            <label for="inputFilePdf" class="btn btn-primary">Seleccione archivo Ride</label>
                            <input type="file" name="" class="btn btn-primary" id="inputFilePdf" accept=".pdf" style="display:none" required="">
                        </div>
                        <div class="col-sm-8">
                            <label id="archivoPdf" style="word-break:break-word;"></label>
                        </div>
                    </div>
                    
                </div>
                <button type="button" class="btn btn-primary" onclick="uploadFile();"><i class="fa fa-upload"></i> Cargar archivos</button>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-8">
                            <ul id="listaDeArchivos">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="RespuestaAjax"></div>
            </div>
        </div>
    </div>
</main>

<script src="./Assets/js/functions_alertas.js"></script>
