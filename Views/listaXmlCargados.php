<script type="text/javascript" src="./Assets/js/functions_xmlCargados.js"></script>

<main class="app-content">
    <div class="app-title" style="height: 50px">
        <div>
            <span class="tamañoTitulo"><i class="fa fa-upload"></i> Archivos xml cargados</span>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item active"><a href="#">Archivos xml cargados</a></li>
        </ul>
    </div>
    <!-- Cargar archivo txt -->
    <div class="row espacio">
        <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <form class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer" action="" method="POST">
                    <div class="form-group">
                        <div class="row">
                            <?php if($_SESSION["Rol"]->id == 1){ ?>
                            <div class="col-sm-1">
                                <label class="control-label">Usuario:</label>
                            </div>
                            <div class="col-sm-2">
                            <?php require_once './acciones/listarUsuariosActivos.php'; ?>
                                <select class="form-control" id="cbxListUser" name="cbxListUser" >
                                    <?php
                                    echo ($_SESSION["Rol"]->id == 1) ? '<option value="">- seleccione -</option>' : "";
                                    
                                    foreach ($listaUsuarios as $user) {
//                                        if($user->idEstado == 1){
                                            if($_SESSION["Rol"]->id == 1){
                                                echo '<option value="' . $user->id . '" '.((isset($_POST['cbxListUser']) && $_POST['cbxListUser'] == $user->id) ? 'selected' : '').'>' . $user->nombre . '</option>';
                                            }
                                            else{
                                                if($user->id == $_SESSION["Usuario"]->id){
                                                    echo '<option value="' . $user->id . '" selected>' . $user->nombre . '</option>';
                                                    break;
                                                }
                                            }
//                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <?php } ?>
                            <div class="col-sm-2">
                                <button class="btn btn-primary btn-sm" id="btnBuscaXmlCargados" name="btnBuscaXmlCargados">
                                    <i class="fa fa-search"></i> Buscar</button>
                            </div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-2">
                                <button class="btn btn-primary btn-sm" onclick="abrirModalMiscelaneo();" type="button">
                                    <i class="fa fa-file"></i> Miscel&aacute;neos</button>
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-primary btn-sm" onclick="window.location.replace('facturasFisicas');" type="button">
                                    <i class="fa fa-file"></i> Ingresar f&iacute;sico</button>
                            </div>
                        </div>

                    </div>


                    <div class="form-group">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>

                                        <!--th>#</th-->
                                        <th>
                                            <input id="chkTodosXml" type="checkbox" onchange="selectTodos(this)"/>
                                        </th>
                                        <th style="text-align: center"></th>
                                        <th>TIPO DE GASTO</th>
                                        <th style="min-width: 200px">ASISTENTES/DETALLE</th>
                                        <th>ESTADO_SISTEMA</th>

                                        <th>COMPROBANTE</th>
                                        <th>SERIE_COMPROBANTE</th>
                                        <th>IMPORTE TOTAL</th>
                                        <th>RUC_EMISOR</th>
                                        <th>RAZON_SOCIAL_EMISOR</th>
                                        <th>FECHA_EMISION</th>
                                        <th>FECHA_AUTORIZACION</th>

                                        <th>CLAVE_ACCESO</th>
                                        <th>NUMERO_AUTORIZACION</th>
                                        
                                    </tr>
                                </thead>
                                <tbody id="dataSri">
                                    <?php 
                                    $archiCont = new archivoXmlControlador();
                                if (isset($_POST['btnBuscaXmlCargados'])) {
                                    $respuesta = $archiCont->listar_xml_cargados_controlador($_POST, 300);
                                } else {
                                    $respuesta = $archiCont->listar_xml_cargados_controlador(null, 300);
                                }

                                if(isset($respuesta)){
                                foreach ($respuesta as $xml) {
                                    $listvarj = json_decode($xml->comprobante);
                                    $docum = null;
                                    $importeTotal = 0;
                                    if (isset($listvarj->factura)) {
                                        $docum = $listvarj->factura;
                                        $importeTotal = $docum->infoFactura->importeTotal;
                                    }
                                    if (isset($listvarj->comprobanteRetencion)) {
                                        $docum = $listvarj->comprobanteRetencion;
                                        //no se puede sacar el totalretenido
                                    }
                                    if (isset($listvarj->notaCredito)) {
                                        $docum = $listvarj->notaCredito;
                                        $importeTotal = $docum->infoNotaCredito->importeTotal;
                                    }
                                    ?>
                                    <tr>
                                    <!--td><php echo $xml->id ?></td-->
                                    <td>
                                        <?php if($xml->esFisica === true){ ?>
                                            <script>listaClavesAcceso.push(<?php echo "'".$xml->id."'"; ?>);
                                                <?php if($xml->tipoDocumento == "MS"){//si es miscelaneos se agrega el tipo  ?>
                                                listaTiposGasto.push(<?php echo "'".$xml->id.":MISCELÁNEOS'"; ?>);
                                                <?php }else{ //para los que no son misce se pone alimentacion, ?>
                                                listaTiposGasto.push(<?php echo "'".$xml->id.":ALIMENTACION'"; ?>);
                                                <?php } ?>
                                            </script>

                                            <input id="<?php echo $xml->id; ?>" type="checkbox" checked="" onchange="seleccionarParaEnvio(this, <?php echo $xml->id; ?>);" />
                                        <?php } else { ?>
                                            <input id="<?php echo $xml->id; ?>" type="checkbox" onchange="seleccionarParaEnvio(this, <?php echo $xml->id; ?>);" />
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-info fa fa-trash" type="button" style="border: none"
                                                onclick="eliminarXmlCargado(<?php echo $xml->id ?>)">
                                        </button>
                                    </td>
                                    <td>
                                        <select style="width: 135px" class="form-control disable-selection btn-sm" 
                                                id="txtTipoGasto<?php echo $xml->id; ?>" name="txtTipoGasto<?php echo $xml->id; ?>" 
                                                onchange="cambiarTipoReembolso(<?php echo $xml->id; ?>)"
                                                <?php echo $xml->tipoDocumento == "MS" ? 'disabled' : ''; ?>>
                                            
                                            <option value="ALIMENTACION">ALIMENTACIÓN</option>
                                            <option value="HOSPEDAJE">HOSPEDAJE</option>
                                            <?php if($xml->tipoDocumento == "MS"){ ?>
                                            <option value="MISCELÁNEOS" <?php echo $xml->tipoDocumento == "MS" ? 'selected' : ''; ?> >MISCELÁNEOS</option>
                                            <?php } ?>
                                            <option value="VARIOS">VARIOS</option>
                                        </select>
                                    </td>
                                    
                                    <td>
                                        <input class="form-control btn-sm" type="text" id="txtAsistentes<?php echo $xml->id; ?>" style="text-transform: uppercase" />
                                    </td>
                                    
                                    <td><?php echo $xml->estadoSistema ?></td>
                                    <td><?php echo $xml->tipoDocumentoTexto ?></td>
                                    
                                    <td><?php $separador = "-";
                                    if($xml->tipoDocumento == "MS"){
                                        $separador = "";
                                    }
                                    echo $docum->infoTributaria->estab .$separador. $docum->infoTributaria->ptoEmi .$separador. $docum->infoTributaria->secuencial ?></td>
                                    
                                    <td><?php echo $importeTotal; ?></td>
                                    
                                    <td><?php echo $docum->infoTributaria->ruc ?></td>
                                    <td><?php echo $docum->infoTributaria->razonSocial ?></td>
                                    
                                    <td><?php echo Date("d/m/Y", ($xml->fechaEmision/1000)) ?></td>
                                    <td><?php echo Date("d/m/Y", ($xml->fechaAutorizacion/1000)) ?></td>
                                    
                                    <td><?php echo $xml->claveAcceso ?></td>
                                    <td><?php echo $xml->numeroAutorizacion ?></td>
                                    
                                </tr>
<?php } 
                            }?>
                                </tbody>
                            </table>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="control-label" >Tipo reembolso:</label>
                            </div>
                            <div class="col-md-3">
                                <select style="/*position:absolute; right:0;bottom:0;*/" class="form-control disable-selection btn-sm" 
                                        id="txtTipoPdf" name="txtTipoPdf">

                                    <option value="">Seleccione</option>
                                    <?php 
                                    $control = new tipoReembolsoControlador();
                                    $lista1 = $control->listar_tiporeembolso_controlador("true");
                                    foreach ($lista1 as $tipoReembolso) {
                                        echo '<option value="'.$tipoReembolso->id.'">'.$tipoReembolso->tipo.'</option>';
                                    } ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary" type="button" 
                                        onclick="mostrarModalDatosReembolso()" >GENERAR PDF</button>
                            </div>
                            <div class="col-md-4"></div>
                        </div>

                    </div>
                    <div class="RespuestaAjax"></div>
                </form>
            </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'Template/Modals/modalPdf.php'; ?>
<?php require_once 'Template/Modals/modalDatosReembolsos.php'; ?>
<?php require_once 'Template/Modals/modalClaveFirma.php'; ?>

<?php require_once 'Template/Modals/modalMiscelaneo.php'; ?>

