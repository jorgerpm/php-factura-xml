<main class="app-content">
    <div class="app-title" style="height: 50px">
        <div>
            <span class="tamañoTitulo"><i class="fa fa-calculator"></i> Consultar facturas</span>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Consultar facturas</a></li>
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
                    if($_POST['txtRegsPagina']){
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
                                echo '<label class="toggle-vis btn btn-primary active" data-column="' . $index . '">';
                                echo '<input id="' . $col['col'] . '" type="checkbox" checked>';
                                echo '<a >' . $col['col'] . '</a>';
                                echo '</label>';
                            }
                            ?>
                        </div>
                    </div>


                    <form id="formEstado" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer" style="width: 100%; padding: 0px"
                          action="" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
                        
                        <div class="row" style="padding-top: 10px">
                            <div class="col-md-3 col-12" style="padding: 0px 5px 0px 8px">
                                <label class="btn-sm" for="listUsers">Usuario:</label>
                                <?php require_once './acciones/listarUsuarios.php'; ?>
                                <select style="position:absolute; right:0;bottom:0;" class="form-control disable-selection btn-sm" id="listUsers" name="listUsers" <?php echo ($_SESSION['Rol']->principal == 0) ? "" : "" ?>>
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
                            <div class="col-md-2 col-12" style="padding: 0px 5px 0px 5px">
                                <label class="btn-sm" for="dtFechaIni">Fecha emisi&oacute;n desde:</label>
                                <input id="dtFechaIni" name="dtFechaIni" class="form-control btn-sm" type="date" value="<?php
                                if (isset($_POST['dtFechaIni'])) {
                                    echo $_POST['dtFechaIni'];
                                } else {
                                    echo date("Y-m-d");
                                }
                                ?>">
                            </div>
                            <div class="col-md-2 col-12" style="padding: 0px 5px 0px 0px">
                                <label class="btn-sm" for="dtFechaFin">Fecha emisi&oacute;n hasta:</label>
                                <input id="dtFechaFin" name="dtFechaFin" class="form-control btn-sm" type="date" value="<?php
                                if (isset($_POST['dtFechaFin'])) {
                                    echo $_POST['dtFechaFin'];
                                } else {
                                    echo date("Y-m-d");
                                }
                                ?>">
                            </div>
                            <div class="col-md-2 col-12" style="padding: 0px 0px 0px 0px">
                                <button style="width: 100%; position:absolute; right:0;bottom:0;" class="btn btn-primary btn-sm fa" id="btnSearch" name="btnSearch" type="submit" ><i class="fa fa-search"></i><span id="btnText">Buscar</span></button>
                            </div>
                            <div class="col-md-1 col-12" ></div>
                            <div class="col-md-2 col-12" style="text-align: right">
                                <button style="width: 100%;position:absolute; right:0;bottom:0;" class="btn btn-primary btn-sm fa" type="button" onclick="pruebaUno('facturas-data')"><i class="fa fa-file-excel-o"></i><span id="btnText">Exportar csv</span></button>
                            </div>
                        </div>
                        <div class="RespuestaAjax"></div>


                        <br>
                        


                        <div class="table-responsive">
                            <table id="sampleTableXml" class="table table-hover table-bordered" style="width:100%">
                                <thead>
                                    <tr>
<?php foreach ($columns as $col) { ?>
                                        <th class="<?php echo $col['col']; ?>" style="width: <?php echo $col['wid']; ?>;"><?php echo $col['col']; ?></th>
                                    <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
<?php
if (count($respuesta) > 0) {
    foreach ($respuesta as $listaArchivoXml) {
        ?>
                                    <tr>
                                        <td style="white-space: nowrap;"><?php echo $listaArchivoXml->nombreUsuario ?></td>
                                        <td style="white-space: nowrap;"><?php echo date("d/m/Y", $listaArchivoXml->fechaEmision / 1000) ?></td>
                                        <td style="white-space: nowrap;"><?php echo date("d/m/Y", $listaArchivoXml->fechaAutorizacion / 1000) ?></td>
                                        <td style="white-space: nowrap;"><?php echo $listaArchivoXml->estado ?></td>
                                        <td style="white-space: nowrap;"><?php echo $listaArchivoXml->numeroAutorizacion ?></td>
                                        <td style="white-space: nowrap;"><?php echo $listaArchivoXml->ambiente ?></td>

                                        <?php
                                        $listvarj = json_decode($listaArchivoXml->comprobante);
// print_r($listvarj);
                                        $docum = null;
                                        if (isset($listvarj->factura)) {
                                            $docum = $listvarj->factura;
                                        }
                                        if ($docum != null) {
                                            $valores = [];

                                            for ($ind = 6; $ind < (count($columns) - 4); $ind++) {
                                                $coincide = false;
                                                foreach ($docum->infoTributaria as $key => $val) {
                                                    if ($columns[$ind]['col'] == $key) {
                                                        array_push($valores, $val);
                                                        $coincide = true;
                                                        break;
                                                    }
                                                }
                                                if ($coincide) {

                                                } else {
                                                    foreach ($docum->infoFactura as $key => $val) {
                                                        if (!isset($val->pago) && !isset($val->totalImpuesto)) {
                                                            if ($columns[$ind]['col'] == $key) {
                                                                array_push($valores, $val);
                                                                $coincide = true;
                                                                break;
                                                            }
                                                        }
//                                                        elseif(isset($val->totalImpuesto)){
//                                                            foreach ($val->totalImpuesto as $keyImp => $valImp) {
//                                                                $comprobar = array_search($valImp->baseImponible, $valores, false);
//                                                                if($comprobar == false){
////                                                                if($valImp->baseImponible){
//                                                                    array_push($valores, $valImp->baseImponible);
//                                                                    $coincide = true;
//                                                                    //break;
//                                                                }else{
////                                                                $coincide = false;
//                                                                }
//                                                            }
//                                                            if ($coincide) {break;}
////                                                            break;
//                                                        }
                                                    }
                                                    if ($coincide) {

                                                    } else {
                                                        //print_r($docum->infoFactura->totalConImpuestos->totalImpuesto);
                                                        if(isset($docum->infoFactura->totalConImpuestos->totalImpuesto)){
                                                            $codP=-1;
                                                            foreach ($docum->infoFactura->totalConImpuestos->totalImpuesto as $keyImp => $valImp) {
                                                                
                                                                if(isset($valImp->baseImponible)){
                                                                    //$comprobar = array_search($valImp->baseImponible, $valores, false);
                                                                    //echo '{'.print_r($comprobar == false).'}';
                                                                    //if($comprobar == false){
                                                                    if ($columns[$ind]['col'] == 'baseImponible:'.$valImp->codigoPorcentaje) {
                                                                        array_push($valores, $valImp->baseImponible);
                                                                        //echo 'sii:: '.$valImp->baseImponible;
                                                                        $coincide = true;
                                                                       // break;
                                                                    }
                                                                }
                                                                else {
                                                                    if($keyImp == 'codigoPorcentaje'){
                                                                        $codP = $valImp;
                                                                    }
                                                                    if($keyImp == 'baseImponible'){
                                                                        //$comprobar = array_search($valImp, $valores, false);
                                                                      //  echo '['.print_r($comprobar).']';
                                                                        //if($comprobar == false){
                                                                        if ($columns[$ind]['col'] == 'baseImponible:'.$codP) {
                                                                            array_push($valores, $valImp);
                                                                            //echo 'nooo:: '.$valImp;
                                                                            $coincide = true;
                                                                         //   break;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            //if ($coincide) {break;}
//                                                            break;
                                                        }
                                                        if ($coincide) {

                                                        } else {
                                                            array_push($valores, '0');
                                                        }
                                                    }
                                                }
                                            }

                                            foreach ($valores as $vals) {
                                                echo '<td style="white-space: nowrap;">';
                                                print_r($vals);
                                                echo "</td>";
                                            }
                                        }
                                        ?>


                    <!--td><?php /* echo $listaArchivoXml->comprobante */ ?></td-->

                                                <!--td><php echo $listaArchivoXml->xmlBase64 ?></td>
                                                <td><php echo $listaArchivoXml->pdfBase64 ?></td-->                                    
                                            <!--td><php echo $listaArchivoXml->ubicacionArchivo ?></td-->
                                        <td style="white-space: nowrap;"><?php echo $listaArchivoXml->tipoDocumento ?></td>
                                        <td style="white-space: nowrap;"><?php echo $listaArchivoXml->idProveedor ?></td>
                                        <td style="white-space: nowrap;"><a target="_blank" href="<?php echo $listaArchivoXml->urlArchivo . "/" . $listaArchivoXml->nombreArchivoXml ?>"><?php echo $listaArchivoXml->urlArchivo . "/" . $listaArchivoXml->nombreArchivoXml ?></a></td>
                                        <td style="white-space: nowrap;">
<?php if ($listaArchivoXml->nombreArchivoPdf != null) { ?>
                                                <a target="_blank" href="<?php echo $listaArchivoXml->urlArchivo . "/" . $listaArchivoXml->nombreArchivoPdf ?>"><?php echo $listaArchivoXml->urlArchivo . "/" . $listaArchivoXml->nombreArchivoPdf ?></a>
                                    <?php } ?>
                                        </td>


                                    </tr>
                                        <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="10">No existen registros.</td><tr>';
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
<?php include 'Template/paginador.php'; ?>
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
        
        for(i=0;i<tableXml.rows.length;i++){
            if(tableXml.rows[i].cells[numCol].style.display !== "none"){
                tableXml.rows[i].cells[numCol].style.display="none";
            }
            else{
                tableXml.rows[i].cells[numCol].style.display="table-cell";
            }
        }
    });


function pruebaUno(filename){
        
        //const form = document.forms[0];
        const form = document.getElementById('formEstado');
        
        //alert(form);
        
//        var accion = form.attr('action');
//    var metodo = form.attr('method');
//        alert(metodo);
        
        var formdata = new FormData(form);
        

    $.ajax({
        type: 'POST',
        url: 'acciones/listarArchivos.php',
        data: formdata ? formdata : form.serialize(),
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            var csv = [];

//data = JSON.stringify(data);

            data = data.replaceAll("[", "").replaceAll("]", "").replaceAll('"', '').replaceAll(',', '').replaceAll('Array', '').replaceAll('(', '').replaceAll(')', '').replaceAll('\n', '');
//            console.log(data);
            
            csv = data.split("~");

            for(var i=0;i<csv.length;i++){
                csv[i] = csv[i].toString().replaceAll(i+" => ", "").replaceAll("  ", "");
            }
            
            //comprobar las columnas
            var tableXml = document.getElementById('sampleTableXml');
    //        alert(tableXml.rows[0].cells[0]);
            //var numCol = $(this).attr('data-column');

            var arrayCols = [];

            for(i=0;i<tableXml.rows[0].cells.length;i++){
                if(tableXml.rows[0].cells[i].style.display !== "none"){
//                    for(j=0;j<csv[0].length;j++){
                    var nomCol = tableXml.rows[0].cells[i].innerHTML;
                    var datascv = csv[0].split(';');
                    
                    for(j=0;j<datascv.length;j++){
                        if(datascv[j] == nomCol){
//                            console.log(nomCol);
                            arrayCols.push(j);
                            break;
                        }
                    }
                }
            }
            
            let csvFinal = [];
            
            for(i=0;i<csv.length;i++){
                let filaAux = [];
                let csvAux = csv[i].split(";");
                for(j=0;j<csvAux.length;j++){
//                    console.log("comparativo", arrayCols.find(a=>a===j));
                    if(arrayCols.find(a=>a===j) >= 0){
                        filaAux.push(csvAux[j]);
//                        console.log(csvAux[j]);
                    }
                }
                csvFinal.push(filaAux.join(";"));    
            }
//            console.log("success, ", csv);
            
            // Download CSV file
    downloadCSV(csvFinal.join("\n"), filename);
//downloadCSV(csv, filename);
        },
        error: function (error) {
            console.log("error: ", error);
        }
    });
        
    }

</script>

