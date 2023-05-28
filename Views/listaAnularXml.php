<main class="app-content">
    <div class="app-title" style="height: 50px">
        <div>
            <span class="tamañoTitulo"><i class="fa fa-calculator"></i> Anular documentos xml</span>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Anular documentos xml</a></li>
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
                    if (isset($_POST['txtRegsPagina'])) {
                        $regsPagina = $_POST['txtRegsPagina'];
                    }
                    $archiCont = new archivoXmlControlador();
                    if (isset($_POST['btnSearch'])) {
                        $respuesta = $archiCont->listar_archivos_controlador($_POST, $regsPagina);
                    } else {
                        $respuesta = $archiCont->listar_archivos_controlador(null, $regsPagina);
                    }
                    ?>

                    <form id="formAnularXml" name="formAnularXml" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer" style="width: 100%; padding: 0px"
                          action="" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">

                        <div class="row" style="/*padding-top: 10px*/">
                            <div class="col-md-6">
                                <div class="row">

                                    <div class="col-md-3" style="/*padding: 0px 5px 0px 8px*/">
                                        <label class="btn-sm" for="listUsers">Usuario:</label>
                                    </div>
                                    <div class="col-md-3 col-12" style="/*padding: 0px 5px 0px 8px*/">
                                        <?php require_once './acciones/listarUsuarios.php'; ?>
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
                                        <label class="btn-sm" for="txtRuc">RUC:</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input id="txtRuc" name="txtRuc" class="form-control btn-sm" type="search" value="<?php
                                        if (isset($_POST['txtRuc'])) {
                                            echo $_POST['txtRuc'];
                                        }
                                        ?>">
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

                                            <option value="01" <?php echo ((isset($_POST['txtTipoDoc']) && $_POST['txtTipoDoc'] == "01") ? 'selected' : ''); ?> >FACTURA</option>
                                            <option value="06" <?php echo ((isset($_POST['txtTipoDoc']) && $_POST['txtTipoDoc'] == "06") ? 'selected' : ''); ?> >GUIA_REMISION</option>
                                            <option value="04" <?php echo ((isset($_POST['txtTipoDoc']) && $_POST['txtTipoDoc'] == "04") ? 'selected' : ''); ?> >NOTA_CREDITO</option>
                                            <option value="05" <?php echo ((isset($_POST['txtTipoDoc']) && $_POST['txtTipoDoc'] == "05") ? 'selected' : ''); ?> >NOTA_DEBITO</option>
                                            <option value="07" <?php echo ((isset($_POST['txtTipoDoc']) && $_POST['txtTipoDoc'] == "07") ? 'selected' : ''); ?> >RETENCION</option>

                                        </select>
                                    </div>
                                    <div class="col-md-3 col-12" style="/*padding: 0px 0px 0px 0px*/">
                                        <button style="/*width: 100%; position:absolute; right:0;bottom:0;*/" class="btn btn-primary btn-sm fa" id="btnSearch" name="btnSearch" type="submit" ><i class="fa fa-search"></i><span id="btnText">Buscar</span></button>
                                    </div>
                                    <div class="col-md-3" ></div>

                                </div>
                            </div>

                        </div>


                        <br>



                        <div class="table-responsive">
                            <table id="sampleTableXml" class="table table-hover table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Anular</th>
                                        <th>Estado Sistema</th>
                                        <th>Usuario</th>
                                        <th>Fecha de emisión</th>
                                        <th>Fecha de autorización</th>
                                        <th>Estado SRI</th>
                                        <th>Número de autorización</th>
                                        <th>Clave acceso</th>
                                        <th>Ambiente</th>
                                        <th>Tipo de documento</th>
                                        <th>Código JD proveedor</th>

                                        <th>Usuario anula</th>
                                        <th>Fecha anula</th>
                                        <th>Raz&oacute;n anulaci&oacute;n</th>
                                    </tr>
                                </thead>
                                <tbody id='bodyData'>
                                    <?php
                                    if (count($respuesta) > 0) {

                                        foreach ($respuesta as $listaArchivoXml) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php if ($listaArchivoXml->estadoSri != "ANULADO") { ?>
                                                        <input class="form-control" type="checkbox" id="<?php echo $listaArchivoXml->id; ?>" />
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($listaArchivoXml->estadoSri != "ANULADO") { ?>
                                                        <button class="btn btn-warning btn-sm" type="button" onclick="abrirModalAnulacion(<?php echo '\'' . $listaArchivoXml->id . ';\''; ?>)">x</button>
                                                    <?php } ?>
                                                </td>
                                                <td style="white-space: nowrap;"><?php echo $listaArchivoXml->estadoSistema; ?></td>
                                                <td style="white-space: nowrap;"><?php echo $listaArchivoXml->nombreUsuario; ?></td>
                                                <td style="white-space: nowrap;"><?php echo date("d/m/Y", $listaArchivoXml->fechaEmision / 1000); ?></td>
                                                <td style="white-space: nowrap;"><?php echo date("d/m/Y", $listaArchivoXml->fechaAutorizacion / 1000); ?></td>
                                                <td style="white-space: nowrap;"><?php echo $listaArchivoXml->estadoSri; ?></td>
                                                <td style="white-space: nowrap;"><?php echo $listaArchivoXml->numeroAutorizacion; ?></td>
                                                <td style="white-space: nowrap;"><?php echo $listaArchivoXml->claveAcceso; ?></td>
                                                <td style="white-space: nowrap;"><?php echo $listaArchivoXml->ambiente; ?></td>

                                                <td style="white-space: nowrap;"><?php echo $listaArchivoXml->tipoDocumento; ?></td>
                                                <td style="white-space: nowrap;"><?php echo $listaArchivoXml->codigoJDProveedor; ?></td>

                                                <td style="white-space: nowrap;"><?php echo $listaArchivoXml->usuarioAnula; ?></td>
                                                <td style="white-space: nowrap;"><?php echo $listaArchivoXml->fechaAnula != null ? date("d/m/Y H:i:s", $listaArchivoXml->fechaAnula / 1000) : ""; ?></td>
                                                <td style="white-space: nowrap;"><?php echo $listaArchivoXml->razonAnulacion; ?></td>


                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="15">No existen registros.</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <?php include 'Template/paginador.php'; ?>


                        <div class="row">
                            <div class="col-md-2">
                                <button style="/*width: 100%;position:absolute; right:0;bottom:0;*/" class="btn btn-primary btn-sm fa" 
                                        type="button" onclick="anularDocumentosSelects()"><i class="fa fa-cog"></i><span id="btnText">Anulaci&oacute;n masiva</span></button>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-5">
                                <label class="control-label">Anular por archivo:</label>
                                <input id="fileAnular" name="fileAnular" type="file" accept=".csv" class="btn btn-primary btn-sm fa"/>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary btn-sm fa" 
                                        type="button" onclick="anularPorArchivo()"><i class="fa fa-cog"></i><span id="btnText">Anular por archivo</span></button>
                            </div>
                        </div>

                    </form>
<div class="RespuestaAjax"></div>

                    <?php require_once 'Template/Modals/modalAnulacionXml.php'; ?>




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
$('.toggle-vis').on('click', function (e) {
    e.preventDefault();
    // Get the column API object
    var tableXml = document.getElementById('sampleTableXml');
//        alert(tableXml.rows[0].cells[0]);
    var numCol = $(this).attr('data-column');

    for (i = 0; i < tableXml.rows.length; i++) {
        if (tableXml.rows[i].cells[numCol].style.display !== "none") {
            tableXml.rows[i].cells[numCol].style.display = "none";
        } else {
            tableXml.rows[i].cells[numCol].style.display = "table-cell";
        }
    }
});





function anularDocumentosSelects(idXml) {
    var tbody = document.getElementById('bodyData');

    console.log("long: ", tbody.rows.length);
    var arrayidxml = "";

    if (tbody.rows.length > 0) {
        var existen = false;
        for (let i = 0; i < tbody.rows.length; i++) {
//            console.log("chlolf: ",  tbody.rows[i].cells[0]);
            if (tbody.rows[i].cells[0] && tbody.rows[i].cells[0].children[0]) {
                const select = tbody.rows[i].cells[0].children[0].checked;
                if (select === true) {
                    arrayidxml = arrayidxml + tbody.rows[i].cells[0].children[0].id + ";";
                    existen = true;
                }
                console.log(select);
            }
        }

        if (existen === true) {
            console.log("si estan selecciopnados");
            console.log("los id: ", arrayidxml);
            //aqui abrir el modar
            abrirModalAnulacion(arrayidxml);

        } else {
            swal("", "Seleccione al menos un registro.", "warning");
        }
    } else {
        swal("", "No existen registros.", "warning");
    }

}

function abrirModalAnulacion(idsxmls) {
    document.querySelector('#formAnular').reset();
    document.querySelector('#idsxml').value = idsxmls;

    $('#modalAnulacion').modal('show');
}


const inputFileAnula = $("#fileAnular");
var fileAnula = [];

//para cargar el archivo txt del sri
inputFileAnula.on('change', function (e) {
    fileAnula = [];

    let files = e.target.files;

    if (files.length === 0)
        return;

    files = Array.from(files);
    files.forEach(uu => {
        console.log("el archivo:: ", uu.type);
        if (uu.type === "text/csv"){
            fileAnula.push(uu);
        }
        else {
            swal("", "Debe seleccionar un archivo .csv", "warning");
            $(this).val('');
            return;
        }
    });
});

function anularPorArchivo() {
    console.log("long: ", $('form[name="formAnularXml"]'));
//const formData = $('form[name="formAnularXml"]'); //document.forms[0];

    const formdata = new FormData(document.getElementById("formAnularXml"));
    
//    var respuesta = document.querySelector(".RespuestaAjax");
    
    var respuesta = $('.RespuestaAjax');
    

    if(fileAnula.length > 0){
        const LOADING = document.querySelector('.loader');
            LOADING.style = 'display: flex;';
        
        $.ajax({
                type: 'POST',
                url: 'acciones/anularXmlPorArchivo.php',
                data: formdata,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log("respuets: ", (data));
                    LOADING.style = 'display: none;';
                    
                    if(data.includes("success")){
                        fileAnula = [];
                        console.log("va  anular");
                        inputFileAnula.val('');
                    }
                    respuesta.html(data);
                    
                    console.log("respuesta: ", respuesta);
                        
                },
                error: function (error) {
                    LOADING.style = 'display: none;';
                    console.log("error: ", error);
                    respuesta.innerHTML = error;
                }
            });
        
        
        
    } else {
        swal("", "Seleccione un archivo con las claves de acceso a anular.", "warning");
    }

}

</script>

