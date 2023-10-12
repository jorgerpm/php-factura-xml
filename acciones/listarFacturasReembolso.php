<?php
if (is_file('./Utils/configUtil.php')) {
    require_once './Utils/configUtil.php';
} else {
    require_once '../Utils/configUtil.php';
}

$regsPagina = 10;
$archiCont = new archivoXmlControlador();
if (isset($_POST['btnSearch'])) {
    $respuesta = $archiCont->listar_archivos_controlador($_POST, $regsPagina);
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

    <div class="RespuestaAjax"></div>

    <br>


    <div class="table-responsive">
        <table id="tableFacturasReembolso" class="table table-hover table-bordered" style="width:100%">
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
                        <a target="_blank" href="<?php echo $listaArchivoXml->urlArchivo . "/" . $listaArchivoXml->nombreArchivoXml ?>"><i class="fa fa-fw fa-lg fa-download"></i><?php echo "XML";/*$listaArchivoXml->urlArchivo . "/" . $listaArchivoXml->nombreArchivoXml*/ ?></a>
                        <?php } ?>
                    </td>
                    <td style="white-space: nowrap;">
            <?php if ($listaArchivoXml->nombreArchivoPdf != null) { ?>
                            <a target="_blank" href="<?php echo $listaArchivoXml->urlArchivo . "/" . $listaArchivoXml->nombreArchivoPdf ?>"><i class="fa fa-fw fa-lg fa-download"></i><?php echo "RIDE";/*$listaArchivoXml->urlArchivo . "/" . $listaArchivoXml->nombreArchivoPdf*/ ?></a>
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


    <div class="row">
        <div class="col-md-2">
            <button style="/*width: 100%;position:absolute; right:0;bottom:0;*/" class="btn btn-primary btn-sm fa" type="button" onclick="pruebaUnoModal('facturas-data', false, <?php echo $_POST['idReembolso']?>)"><i class="fa fa-file-excel-o"></i><span id="btnText">Exportar todos</span></button>
        </div>
        <div class="col-md-2">
            <button style="/*width: 100%;position:absolute; right:0;bottom:0;*/" class="btn btn-primary btn-sm fa" type="button" onclick="exportarSeleccionados(<?php echo $_POST['idReembolso']?>)"><i class="fa fa-file-excel-o"></i><span id="btnText">Exportar seleccionados</span></button>
        </div>
        <div class="col-md-8" >
            <input type="checkbox" id="txtConDetalles" /> Exportar con detalles
        </div>
    </div>

</form>

