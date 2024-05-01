<main class="app-content">
    <div class="app-title" style="height: 50px">
        <div>
            <span class="tamañoTitulo"><i class="fa fa-calculator"></i> Consultar documentos electr&oacute;nicos</span>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Consultar documentos electr&oacute;nicos</a></li>
        </ul>
    </div>
</div>
<div class="row espacio">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div >
                    <?php
                    $regsPagina = 10;
                    if(isset($_POST['txtRegsPagina'])){
                        $regsPagina = $_POST['txtRegsPagina'];
                    }
                    $archiCont = new archivoXmlControlador();
                    if (isset($_POST['btnSearch'])) {
                        $respuesta = $archiCont->listar_archivos_controlador($_POST, $regsPagina);
                    } else {
                        $respuesta = $archiCont->listar_archivos_controlador(null, $regsPagina);
                    }
                    $columns = $archiCont->crear_columnas($respuesta);
                    ?>
                    <a  data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Columnas a mostrar:
                    </a>
                    <div class="collapse" style="overflow: scroll;" id="collapseExample">
                        <div class="btn-group" data-toggle="buttons">
                            <?php
                            foreach ($columns as $index => $col) {
                                $posiis = ($index+2);
                                echo '<label class="toggle-vis btn btn-primary active" data-column="' . $posiis . '">';
                                //echo '<input id="' . $col['col'] . '" type="checkbox" checked />';
                                echo '<label id="lblCol'.$posiis.'" style="color: white;" class="fa fa-check"></label><br/>';
                                echo '<a >' . $col['col'] . '</a>';
                                echo '</label>';
                            }
                            ?>
                        </div>
                    </div>


                    <form id="formListaDocsXml" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer" style="width: 100%; padding: 0px"
                          action="" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
                        
                        <div class="row" style="/*padding-top: 10px*/">
                            <div class="col-md-6">
                                <div class="row">

                                    <div class="col-md-3" style="padding-right: 0px;">
                                        <label class="btn-sm" for="listUsers">Usuario:</label>
                                    </div>
                                    <div class="col-md-3 col-12" style="/*padding: 0px 5px 0px 8px*/">
                                        <?php require_once './acciones/listarUsuariosActivos.php'; ?>
                                        <select style="/*position:absolute; right:0;bottom:0;*/" class="form-control disable-selection btn-sm" id="listUsers" name="listUsers" <?php echo ($_SESSION['Rol']->principal == 0) ? "" : "" ?>>
                                            <?php if ($_SESSION['Rol']->principal == 1) { ?>
                                                <option value="">Seleccione</option>;
                                            <?php } ?>
                                            <?php
                                            foreach ($listaUsuarios as $user) {
                                                if ($_SESSION['Rol']->principal == 1) {
                                                    echo '<option value="' . $user->id . '" ' . ((isset($_POST['listUsers']) && $_POST['listUsers'] == $user->id) ? 'selected' : '') . '>' . $user->nombre . '</option>';
                                                } else {
                                                    if ($_SESSION['Usuario']->id == $user->id) {
                                                        echo '<option value="' . $user->id . '" ' . ((isset($_POST['listUsers']) && $_POST['listUsers'] == $user->id) ? 'selected' : '') . '>' . $user->nombre . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3" style="padding-right: 0px;">
                                        <label class="control-label btn-sm" for="dtFechaIni">Fecha emisi&oacute;n desde:</label>
                                    </div>
                                    <div class="col-md-3 col-12" style="/*padding: 0px 5px 0px 5px*/">
                                        <input id="dtFechaIni" name="dtFechaIni" class="form-control btn-sm" type="date" value="<?php
                                        if (isset($_POST['dtFechaIni'])) {
                                            echo $_POST['dtFechaIni'];
                                        } else {
                                            echo date("Y-m-d");
                                        }
                                        ?>">
                                    </div>
                                </div>
                            </div>
                                
                            
                            <div class="col-md-6">
                                <div class="row">

                                    <div class="col-md-3" style="padding-right: 0px;">
                                        <label class="btn-sm" for="dtFechaFin">Fecha emisi&oacute;n hasta:</label>
                                    </div>
                                    <div class="col-md-3 col-12" style="/*padding: 0px 5px 0px 0px*/">
                                        <input id="dtFechaFin" name="dtFechaFin" class="form-control btn-sm" type="date" value="<?php
                                        if (isset($_POST['dtFechaFin'])) {
                                            echo $_POST['dtFechaFin'];
                                        } else {
                                            echo date("Y-m-d");
                                        }
                                        ?>">
                                    </div>
                                    <div class="col-md-3" style="padding-right: 0px;">
                                        <label class="btn-sm" for="txtEstadoSistema">Estado sistema:</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select style="/*position:absolute; right:0;bottom:0;*/" class="form-control disable-selection btn-sm" 
                                                id="txtEstadoSistema" name="txtEstadoSistema">

                                            <option value="">Seleccione</option>

                                            <option value="ANULADO" <?php echo ((isset($_POST['txtEstadoSistema']) && $_POST['txtEstadoSistema'] == "ANULADO") ? 'selected' : ''); ?> >ANULADO</option>
                                            <option value="APROBADO" <?php echo ((isset($_POST['txtEstadoSistema']) && $_POST['txtEstadoSistema'] == "APROBADO") ? 'selected' : ''); ?> >APROBADO</option>
                                            <option value="CARGADO" <?php echo ((isset($_POST['txtEstadoSistema']) && $_POST['txtEstadoSistema'] == "CARGADO") ? 'selected' : ''); ?> >CARGADO</option>
                                            <option value="POR_AUTORIZAR" <?php echo ((isset($_POST['txtEstadoSistema']) && $_POST['txtEstadoSistema'] == "POR_AUTORIZAR") ? 'selected' : ''); ?> >POR_AUTORIZAR</option>
                                            <option value="PROCESADO" <?php echo ((isset($_POST['txtEstadoSistema']) && $_POST['txtEstadoSistema'] == "PROCESADO") ? 'selected' : ''); ?> >PROCESADO</option>
                                            <option value="RECHAZADO" <?php echo ((isset($_POST['txtEstadoSistema']) && $_POST['txtEstadoSistema'] == "RECHAZADO") ? 'selected' : ''); ?> >RECHAZADO</option>

                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">

                                    <div class="col-md-3" style="padding-right: 0px;">
                                        <label class="btn-sm" for="txtClaveAcceso">Clave de acceso:</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input id="txtClaveAcceso" name="txtClaveAcceso" class="form-control btn-sm" type="search" value="<?php
                                        if (isset($_POST['txtClaveAcceso'])) {
                                            echo $_POST['txtClaveAcceso'];
                                        }
                                        ?>">
                                    </div>
                                    <div class="col-md-3" style="padding-right: 0px;">
                                        <label class="btn-sm" for="txtRuc">Proveedor:</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input id="txtRuc" name="txtRuc" class="form-control btn-sm" type="search" value="<?php
                                        if (isset($_POST['txtRuc'])) {
                                            echo $_POST['txtRuc'];
                                        }
                                        ?>" style="text-transform: uppercase">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="row">

                                    <div class="col-md-3" style="padding-right: 0px;">
                                        <label class="btn-sm" for="txtTipoDoc">Tipo documento:</label>
                                    </div>
                                    <div class="col-md-3">


                                        <select style="/*position:absolute; right:0;bottom:0;*/" class="form-control disable-selection btn-sm" 
                                                id="txtTipoDoc" name="txtTipoDoc">

                                            <option value="">Seleccione</option>

                                            <?php if($_SESSION['Rol']->bFactura == true) {?>
                                                <option value="01" <?php echo ((isset($_POST['txtTipoDoc']) && $_POST['txtTipoDoc'] == "01") ? 'selected' : ''); ?> >FACTURA</option>
                                                <option value="NV" <?php echo ((isset($_POST['txtTipoDoc']) && $_POST['txtTipoDoc'] == "NV") ? 'selected' : ''); ?> >NOTA_VENTA</option>
                                                <option value="MS" <?php echo ((isset($_POST['txtTipoDoc']) && $_POST['txtTipoDoc'] == "MS") ? 'selected' : ''); ?> >MISCELÁNEO</option>
                                            <?php } if($_SESSION['Rol']->bGuiaRemision) {?>
                                                <option value="06" <?php echo ((isset($_POST['txtTipoDoc']) && $_POST['txtTipoDoc'] == "06") ? 'selected' : ''); ?> >GUIA_REMISION</option>
                                            <?php } if($_SESSION['Rol']->bNotaCredito) {?>
                                                <option value="04" <?php echo ((isset($_POST['txtTipoDoc']) && $_POST['txtTipoDoc'] == "04") ? 'selected' : ''); ?> >NOTA_CREDITO</option>
                                            <?php } if($_SESSION['Rol']->bNotaDebito) {?>
                                                <option value="05" <?php echo ((isset($_POST['txtTipoDoc']) && $_POST['txtTipoDoc'] == "05") ? 'selected' : ''); ?> >NOTA_DEBITO</option>
                                            <?php } if($_SESSION['Rol']->bRetencion) {?>
                                                <option value="07" <?php echo ((isset($_POST['txtTipoDoc']) && $_POST['txtTipoDoc'] == "07") ? 'selected' : ''); ?> >RETENCION</option>
                                            <?php }?>

                                        </select>

                                    </div>
                                    <div class="col-md-3 col-12" style="padding-right: 0px;">
                                        <label class="btn-sm control-label" for="txtDescargados">Exportados:</label>
                                    </div>
                                    <div class="col-md-3 col-12" >
                                        <select class="form-control disable-selection btn-sm" id="txtDescargados" name="txtDescargados">
                                            <option value="">Seleccione</option>
                                            <option value="false" <?php echo ((isset($_POST['txtDescargados']) && $_POST['txtDescargados'] == "false") ? 'selected' : ''); ?>>NO</option>
                                            <option value="true" <?php echo ((isset($_POST['txtDescargados']) && $_POST['txtDescargados'] == "true") ? 'selected' : ''); ?>>SI</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row" style="padding-top: 10px;">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-3 col-12" style="padding-right: 0px;">
                                        <label class="btn-sm control-label" for="txtListaEmpresas">Empresa:</label>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <select id="txtListaEmpresas" name="txtListaEmpresas" class="form-control disable-selection btn-sm" >
                                            <?php 
                                            $contrEmp = new empresaControlador();
                                            $listEmpAux = $contrEmp->listar_empresas_controlador();
                                            $rle = explode(",", $_SESSION["Rol"]->listaIdEmpresas);
                                            if(count($listEmpAux) == count($rle)){
                                                echo '<option value="">Seleccione</option>';
                                            }
                                            //$listEmp = $contrEmp->listar_empresas_rol_controlador();
                                            foreach($listEmpAux as $empresa){
                                                foreach ($rle as $idEmp){
                                                    if($empresa->id == $idEmp){
                                                        echo '<option value="'.$empresa->ruc.'" '.(isset($_POST["txtListaEmpresas"]) && $_POST["txtListaEmpresas"] == $empresa->ruc ? 'selected' : '') .'>'.$empresa->razonSocial.'</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-12" style="padding-right: 0px;"></div>
                                    <div class="col-md-3 col-12" ></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-3 col-12" style="padding-right: 0px;"></div>
                                    <div class="col-md-3 col-12" ></div>
                                    <div class="col-md-3 col-12" style="/*padding: 0px 0px 0px 0px*/">
                                        <button style="/*width: 100%; position:absolute; right:0;bottom:0;*/" class="btn btn-primary btn-sm fa" id="btnSearch" name="btnSearch" type="submit" ><i class="fa fa-search"></i><span id="btnText">Buscar</span></button>
                                    </div>
                                    <div class="col-md-3 col-12">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="RespuestaAjax"></div>
                        
                        <br>


                        <div class="table-responsive">
                            <table id="sampleTableXml" class="table table-hover table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <!-- th style="resize: horizontal; overflow: auto;">Exportar</th -->
                                        <th>Exportar</th>
                                        <th style="text-align: center;">
                                            Descargar xml
                                            <input type="checkbox" onclick="marcarTodosXml(this);"/>
                                        </th>
<?php foreach ($columns as $col) { ?>
                                        <th class="<?php echo $col['col']; ?>" style="width: <?php echo $col['wid']; ?>;"><?php echo $col['col']; ?></th>
                                    <?php } ?>
                                    </tr>
                                </thead>
                                <tbody id='bodyDataXml'>
<?php
if (count($respuesta) > 0) {
    
    foreach ($respuesta as $listaArchivoXml) {
        ?>
                                    <tr style="<?php echo $listaArchivoXml->exportado === true ? 'color: blue;' : '' ?>">
                                        <td>
                                            <input type="checkbox" id="<?php echo $listaArchivoXml->claveAcceso; ?>" />
                                        </td>
                                        
                                        <!-- para la descarga -->
                                        <td style="text-align: center;">
                                            <?php if($listaArchivoXml->nombreArchivoXml != null){?>
                                            <input class="agregarXml" type="checkbox" 
                                                   onclick="addArchivoXml('<?php echo $listaArchivoXml->urlArchivo."/".$listaArchivoXml->nombreArchivoXml; ?>', this);" />
                                            <?php } ?>
                                        </td>
                                        
                                        <td style="white-space: nowrap;"><?php echo $listaArchivoXml->estadoSistema; ?></td>
                                        <td style="white-space: nowrap;"><?php echo $listaArchivoXml->nombreUsuario; ?></td>
                                        <td style="white-space: nowrap;"><?php echo date("d/m/Y", $listaArchivoXml->fechaEmision / 1000); ?></td>
                                        <td style="white-space: nowrap;"><?php echo date("d/m/Y", $listaArchivoXml->fechaAutorizacion / 1000); ?></td>
                                        <td style="white-space: nowrap;"><?php echo $listaArchivoXml->estadoSri; ?></td>
                                        <td style="white-space: nowrap;"><?php echo $listaArchivoXml->numeroAutorizacion; ?></td>
                                        <td style="white-space: nowrap;"><?php echo $listaArchivoXml->ambiente; ?></td>

                                        <?php
                                        $listvarj = json_decode($listaArchivoXml->comprobante);
                                        
                                        $tabla = new generarTablaControlador();
                                        $valores = $tabla->generarTabla($listvarj, $columns);
                                        
// print_r($listvarj);

                                            foreach ($valores as $vals) {
                                                echo '<td style="white-space: nowrap;">';
                                                print_r($vals);
                                                echo "</td>";
                                            }
                                        
                                        ?>


                    <!--td><?php /* echo $listaArchivoXml->comprobante */ ?></td-->

                                                <!--td><php echo $listaArchivoXml->xmlBase64 ?></td>
                                                <td><php echo $listaArchivoXml->pdfBase64 ?></td-->                                    
                                            <!--td><php echo $listaArchivoXml->ubicacionArchivo ?></td-->
                                        <td style="white-space: nowrap;"><?php echo $listaArchivoXml->tipoDocumentoTexto; ?></td>
                                        <td style="white-space: nowrap;"><?php echo $listaArchivoXml->codigoJDProveedor; ?></td>
                                        
                                        <td style="white-space: nowrap;"><?php echo $listaArchivoXml->usuarioAnula; ?></td>
                                        <td style="white-space: nowrap;"><?php echo $listaArchivoXml->fechaAnula != null ? date("d/m/Y H:i:s", $listaArchivoXml->fechaAnula / 1000) : ""; ?></td>
                                        <td style="white-space: nowrap;"><?php echo $listaArchivoXml->razonAnulacion; ?></td>
                                        <td style="white-space: nowrap;"><?php echo $listaArchivoXml->numeroReembolso; ?></td>
                                        <td style="white-space: nowrap;"><?php echo $listaArchivoXml->tipoReembolso; ?></td>
                                        
                                        <td style="white-space: nowrap;">
                                            <?php if ($listaArchivoXml->nombreArchivoXml != null) { ?>
                                            <a target="_blank" href="<?php echo $listaArchivoXml->urlArchivo . "/" . $listaArchivoXml->nombreArchivoXml ?>"><i class="fa fa-fw fa-lg fa-download"></i><?php echo "XML";/*$listaArchivoXml->urlArchivo . "/" . $listaArchivoXml->nombreArchivoXml*/ ?></a>
                                            <?php } ?>
                                        </td>
                                        <td style="white-space: nowrap;">
                                <?php if ($listaArchivoXml->nombreArchivoPdf != null) { ?>
                                                <a target="_blank" href="<?php echo $listaArchivoXml->urlArchivo . "/" . $listaArchivoXml->nombreArchivoPdf ?>"><i class="fa fa-fw fa-lg fa-download"></i><?php echo "RIDE";/*$listaArchivoXml->urlArchivo . "/" . $listaArchivoXml->nombreArchivoPdf*/ ?></a>
                                                <button type="button" 
                                                        onclick="generarRide(<?php echo "'".$listaArchivoXml->urlArchivo . "/" . $listaArchivoXml->nombreArchivoXml."','".$listaArchivoXml->tipoDocumento.
                                                                "','".$listaArchivoXml->fechaAutorizacion."','".$listaArchivoXml->numeroAutorizacion."'"?>)"  style="color: white; background-color: transparent; border: none; padding: 0;">.</button>
                                    <?php } ?>
                                        </td>


                                    </tr>
                                        <?php
                                        
                                    }
                                } else {
                                    echo '<tr><td colspan="'.count($columns).'">No existen registros.</td></tr>';
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
<?php include 'Template/paginador.php'; ?>
                        
                        
                        <div class="row">
                            <div class="col-md-2">
                                <button style="/*width: 100%;position:absolute; right:0;bottom:0;*/" class="btn btn-primary btn-sm fa" type="button" onclick="pruebaUno('facturas-data', false)"><i class="fa fa-file-excel-o"></i><span id="btnText">Exportar todos</span></button>
                            </div>
                            <div class="col-md-2">
                                <button style="/*width: 100%;position:absolute; right:0;bottom:0;*/" class="btn btn-primary btn-sm fa" type="button" onclick="exportarSeleccionados(0)"><i class="fa fa-file-excel-o"></i><span id="btnText">Exportar seleccionados</span></button>
                            </div>
                            <div class="col-md-6" >
                                <input type="checkbox" id="txtConDetalles" /> Exportar con detalles
                            </div>
                            <div class="col-md-2" >
                                <button class="btn btn-primary btn-sm fa" type="button" onclick="crearZipDescargar()">
                                    <i class="fa fa-download"></i><span>Descargar xml seleccionados</span></button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</main>

<!-- Page specific javascripts-->
<!-- Data table plugin-->
<script type="text/javascript" src="./Assets/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="./Assets/js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="./Assets/js/plugins/dataTables.colReorder.min.js"></script>

<script type="text/javascript" src="./Assets/js/functions_archivosxml.js"></script>
<script type="text/javascript" src="./Assets/js/functions_descargaMasiva.js"></script>

<script type="text/javascript">
    
    //esta funcion es para utilizar datatable y reorderColumns
    //var tablq = crearTablaB("sampleTableXml");
    
    var columnasOcultas = [];
    function comprobarColumnasOcultas(){
        localStorage.removeItem("columnasOcultas");
        if(localStorage.getItem("columnasOcultas")){
            columnasOcultas = localStorage.getItem("columnasOcultas").split(",");
            console.log("columnasOcultas: ", columnasOcultas);
            for(let i=0;i<columnasOcultas.length;i++){
                var numCol = columnasOcultas[i];
                
                var inputCheck1 = document.getElementById("lblCol"+numCol);
//                console.log("inputCheck1: ", inputCheck1);
                
                ocultarLaColumn(numCol, inputCheck1, false);
                
            }
            localStorage.removeItem("columnasOcultas");
        }
    }
    
    //este es el que hace que se ejecute la funcion de comprobaacion
//    document.body.onload = comprobarColumnasOcultas; 
    
    $('.toggle-vis').on('click', function (e) {
        e.preventDefault();
//        alert(tableXml.rows[0].cells[0]);
        var numCol = $(this).attr('data-column');
        var inputCheck1 = $(this).children(0)[0];
        
//        console.log("$(this).children(0);", inputCheck1);
//        console.log("numcol: ", numCol);

        ocultarLaColumn(numCol, inputCheck1, true);
        
        console.log("$(this).children(0);", inputCheck1);
    });
    
    function ocultarLaColumn(numCol, inputCheck1, nuevo){
        
        var tableXml = document.getElementById('sampleTableXml');
        
        for(let i=0;i<tableXml.rows.length;i++){
            if(tableXml.rows[i].cells[numCol] && tableXml.rows[i].cells[numCol].style.display !== "none"){
                if(i === 0){//esto lo hace solo para la primera fila, y no cada vez que ingresa
                    inputCheck1.style.color = "yellow";
                    inputCheck1.className = "fa fa-times";
                    
                    //aqui utilizar el localStorage, se necesita saber el numeroColumna para ocultar
                    if(nuevo){
                        columnasOcultas.push(numCol);
                        localStorage.setItem("columnasOcultas", columnasOcultas);
                    }
                }
                tableXml.rows[i].cells[numCol].style.display="none";
//                console.log("entrra i: ", i);
            }
            else{
                if(tableXml.rows[i].cells[numCol]){
                    tableXml.rows[i].cells[numCol].style.display="table-cell";
                    if(i === 0 && nuevo){
                        columnasOcultas = columnasOcultas.filter(y => y !== numCol);
                        console.log("es: ", );
                        localStorage.setItem("columnasOcultas", columnasOcultas);
                    }
                }
                
                if(i === 0){//esto lo hace solo para la primera fila, y no cada vez que ingresa
                    inputCheck1.style.color = "white";
                    inputCheck1.className = "fa fa-check";
                }
//                console.log("entrra else i: ", i);
            }
            
            
        }
    }
    
    function generarRide(pathXml, tipoDocumento, fechaAutorizacion, numeroAutorizacion){
//        console.log("tipoDocumento: ", tipoDocumento);
//        console.log("fechaAutorizacion: ", fechaAutorizacion);
//        console.log("numeroAutorizacion: ", numeroAutorizacion);
//        console.log("pathXml: ", pathXml);
        
        
        var resp = $('.RespuestaAjax');
        
        $.ajax({
        type: 'POST',
        url: 'acciones/generarRide.php',
        data: {
            pathXml: pathXml,
            tipoDocumento: tipoDocumento,
            fechaAutorizacion: fechaAutorizacion,
            numeroAutorizacion: numeroAutorizacion
        },
        success: function (data) {
            
            //LOADING.style.display='none';
            if(data.includes("window.location")){
                window.location.replace("index");
                return;
            }
            else if(data.includes("swal")){
                resp.html(data.replaceAll("\"", "").replaceAll("\\",""));
                return ;
            }
            
            data = JSON.parse(data);
//            console.log("asi es la data del clavefirma:: ", data);
//console.log("resp: ", data.respuesta);
            
            if(data.respuesta === "OK"){
                //data.archivoRide;
//                    console.log(data.respuesta);

                var byteCharacters = atob(data.archivoRide);
                var byteNumbers = new Array(byteCharacters.length);
                for (var i = 0; i < byteCharacters.length; i++) {
                  byteNumbers[i] = byteCharacters.charCodeAt(i);
                }
                var byteArray = new Uint8Array(byteNumbers);

                var file = new Blob([byteArray], { type: "application/pdf;base64" });
                var fileURL = URL.createObjectURL(file);
                window.open(fileURL, '_blank');
            }
            

        },
        error: function (error) {
            //LOADING.style.display='none';          
            console.log(data);
        }
    });
    }


</script>

