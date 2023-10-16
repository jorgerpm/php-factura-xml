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
                                echo '<label class="toggle-vis btn btn-primary active" data-column="' . ($index+1) . '">';
                                //echo '<input id="' . $col['col'] . '" type="checkbox" checked />';
                                echo '<label style="color: white;" class="fa fa-check"></label><br/>';
                                echo '<a >' . $col['col'] . '</a>';
                                echo '</label>';
                            }
                            ?>
                        </div>
                    </div>


                    <form id="formEstado" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer" style="width: 100%; padding: 0px"
                          action="" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
                        
                        <div class="row" style="/*padding-top: 10px*/">
                            <div class="col-md-6">
                        <div class="row">
                             
                            <div class="col-md-3" style="/*padding: 0px 5px 0px 8px*/">
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
                            <div class="col-md-3" style="/*padding: 0px 0px 0px 0px*/">
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
                            
                            <div class="col-md-3" style="/*padding: 0px 0px 0px 0px*/">
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
                            <div class="col-md-3">
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
                            <div class="col-md-3">
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
                            <div class="col-md-3 col-12" style="/*padding: 0px 0px 0px 0px*/">
                                <button style="/*width: 100%; position:absolute; right:0;bottom:0;*/" class="btn btn-primary btn-sm fa" id="btnSearch" name="btnSearch" type="submit" ><i class="fa fa-search"></i><span id="btnText">Buscar</span></button>
                            </div>
                            <div class="col-md-3" ></div>
                            
                            </div>
                            </div>
                            
                        </div>
                        
                        
                        <div class="RespuestaAjax"></div>
                        

                        <br>
                        


                        <div class="table-responsive">
                            <table id="sampleTableXml" class="table table-hover table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th></th>
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
                                            <input class="form-control" type="checkbox" id="<?php echo $listaArchivoXml->claveAcceso; ?>" />
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
                                        
                                        <td style="white-space: nowrap;">
                                            <?php if ($listaArchivoXml->nombreArchivoXml != null) { ?>
                                            <a target="_blank" href="<?php echo $_SESSION['URL_SISTEMA'] . $listaArchivoXml->urlArchivo . "/" . $listaArchivoXml->nombreArchivoXml ?>"><i class="fa fa-fw fa-lg fa-download"></i><?php echo "XML";/*$listaArchivoXml->urlArchivo . "/" . $listaArchivoXml->nombreArchivoXml*/ ?></a>
                                            <?php } ?>
                                        </td>
                                        <td style="white-space: nowrap;">
                                <?php if ($listaArchivoXml->nombreArchivoPdf != null) { ?>
                                                <a target="_blank" href="<?php echo $_SESSION['URL_SISTEMA'] . $listaArchivoXml->urlArchivo . "/" . $listaArchivoXml->nombreArchivoPdf ?>"><i class="fa fa-fw fa-lg fa-download"></i><?php echo "RIDE";/*$listaArchivoXml->urlArchivo . "/" . $listaArchivoXml->nombreArchivoPdf*/ ?></a>
                                    <?php } ?>
                                        </td>


                                    </tr>
                                        <?php
                                        
                                    }
                                } else {
                                    echo '<tr><td colspan="16">No existen registros.</td></tr>';
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
                            <div class="col-md-8" >
                                <input type="checkbox" id="txtConDetalles" /> Exportar con detalles
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

<script type="text/javascript" src="./Assets/js/functions_archivosxml.js"></script>

<script type="text/javascript">
    var table = $('#sampleTableXml1').DataTable({
//        scrollY: '34vh',
//        scrollCollapse: true,
        language: {
            lengthMenu: 'Mostrar _MENU_ registros por p&aacute;gina',
            zeroRecords: 'No existen registros',
            info: 'Mostrando p&aacute;gina _PAGE_ de _PAGES_',
            infoEmpty: 'No existen registros',
            infoFiltered: '(filtrados de los _MAX_ registros totales)',
            search: 'Filtrar',
            paginate:{
                previous: '&laquo',
                next: '&raquo;',
            },
        },
        lengthMenu: [
            [10, 25, 50, 100],
            [10, 25, 50, 100],
        ],
    });
    
    $('.toggle-vis').on('click', function (e) {
        e.preventDefault();
        // Get the column API object
        var tableXml = document.getElementById('sampleTableXml');
//        alert(tableXml.rows[0].cells[0]);
        var numCol = $(this).attr('data-column');
        const inputCheck = $(this).children(0)[0];
        
        console.log("$(this).children(0);", inputCheck);
        
        console.log("numcol: ", numCol);
        
        for(let i=0;i<tableXml.rows.length;i++){
            if(tableXml.rows[i].cells[numCol] && tableXml.rows[i].cells[numCol].style.display !== "none"){
                tableXml.rows[i].cells[numCol].style.display="none";
                inputCheck.style.color = "yellow";
                inputCheck.className = "fa fa-times";
            }
            else{
                if(tableXml.rows[i].cells[numCol])
                    tableXml.rows[i].cells[numCol].style.display="table-cell";
                
                inputCheck.style.color = "white";
                inputCheck.className = "fa fa-check";
            }
        }
    });
    
    
    


</script>

