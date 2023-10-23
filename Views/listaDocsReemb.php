<main class="app-content">
    <div class="app-title" style="height: 50px">
        <div>
            <span class="tamañoTitulo"><i class="fa fa-calculator"></i> Documentos reembolsos</span>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">Documentos reembolsos</a></li>
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
                    $control = new documentoReembolsoControlador();
                    if (isset($_POST['btnSearch'])) {
                        $respuesta = $control->listar_documentos_controlador($_POST, $regsPagina);
                    } else {
                        $respuesta = $control->listar_documentos_controlador(null, $regsPagina);
                    }
                    ?>

                    <form id="formReembolsos" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer" style="width: 100%; padding: 0px"
                          action="" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">

                        <div class="row" style="/*padding-top: 10px*/">
                            <div class="col-md-6">
                                <div class="row">

                                    <div class="col-md-3" style="/*display: <php echo ($_SESSION['Rol']->id ==1 || $_SESSION['Rol']->principal == 1) ? '' :'none' ?> */ ">
                                        <label class="btn-sm" for="listUsers">Usuario carga:</label>
                                    </div>
                                    <div class="col-md-3 col-12" style="/*display: <php echo ($_SESSION['Rol']->id ==1 || $_SESSION['Rol']->principal == 1) ? '' :'none' ?>*/">
                                        <?php require_once './acciones/listarUsuariosActivos.php'; ?>
                                        <select style="/*position:absolute; right:0;bottom:0;*/" class="form-control disable-selection btn-sm" id="listUsers" name="listUsers" <?php echo ($_SESSION['Rol']->id ==1 || $_SESSION['Rol']->principal == 1) ? '' : 'readonly' ?> >
                                            <?php if ($_SESSION['Rol']->id ==1 || $_SESSION['Rol']->principal == 1) { ?>
                                                <option value="">Seleccione</option>;
                                            <?php } ?>
                                            <?php
                                            foreach ($listaUsuarios as $user) {
                                                if ($_SESSION['Rol']->id ==1 || $_SESSION['Rol']->principal == 1) {
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
                                        <label class="control-label btn-sm" for="dtFechaIni">Fecha carga desde:</label>
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
                                        <label class="btn-sm" for="dtFechaFin">Fecha carga hasta:</label>
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

                                            <option value="APROBADO" <?php echo ((isset($_POST['txtEstadoSistema']) && $_POST['txtEstadoSistema'] == "APROBADO") ? 'selected' : ''); ?> >APROBADO</option>
                                            <option value="PROCESADO" <?php echo ((isset($_POST['txtEstadoSistema']) && $_POST['txtEstadoSistema'] == "PROCESADO") ? 'selected' : ''); ?> >PROCESADO</option>
                                            <option value="RECHAZADO" <?php echo ((isset($_POST['txtEstadoSistema']) && $_POST['txtEstadoSistema'] == "RECHAZADO") ? 'selected' : ''); ?> >RECHAZADO</option>
                                            <option value="POR_AUTORIZAR" <?php echo ((isset($_POST['txtEstadoSistema']) && $_POST['txtEstadoSistema'] == "POR_AUTORIZAR") ? 'selected' : ''); ?> >POR_AUTORIZAR</option>

                                        </select>
                                    </div>

                                </div>
                            </div>

                        </div>
                        
                        <div class="row">
                            <div class="col-md-2">
                                <button class="btn btn-primary btn-sm fa" id="btnSearch" name="btnSearch" type="submit" ><i class="fa fa-search"></i><span id="btnText">Buscar</span></button>
                            </div>
                            <div class="col-md-10">
                            </div>
                        </div>


                        <br>



                        <div class="table-responsive">
                            <table id="sampleTableXml" class="table table-hover table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <?php if($_SESSION['Rol']->autorizador == 1){ ?>
                                        <th>Aprobar/ rechazar</th>
                                        <?php } ?>
                                        
                                        <?php //para el contador o para el auxiliar
                                        if($_SESSION['Rol']->id == 1 || $_SESSION['Rol']->id == 4 || $_SESSION['Rol']->id == 5){ ?>
                                        <th>Datos conta.</th>
                                        <th>Solicitar justificativo</th>
                                        <?php } ?>
                                        
                                        <th>Ver doc. reembolso</th>
                                        <th>Cargar justific.</th>
                                        <th>Ver justificativo</th>
                                        <th>Ver documentos</th>
                                        <th>Estado Sistema</th>
                                        <th>Tipo reembolso</th>
                                        <th>Usuario carga</th>
                                        <th>Fecha de carga</th>
                                        <th>Número R.C.</th>
                                        <th>Aprobador</th>
                                        <th>Usuario aprueba/rechaza</th>
                                        <th>Fecha aprueba/rechaza</th>
                                        <th>Usuario procesa/rechaza</th>
                                        <th>Fecha procesa/rechaza</th>
                                        <th>Raz&oacute;n rechazo</th>
                                    </tr>
                                </thead>
                                <tbody id='bodyData'>
                                    <?php
                                    if (count($respuesta) > 0) {

                                        foreach ($respuesta as $docReembolso) {
                                            ?>
                                            <tr>
                                                <?php
//                                                $nuevoPath = $docReembolso->pathArchivo;
//                                                if ($docReembolso->estado == "APROBADO" || $docReembolso->estado == "RECHAZADO" || $docReembolso->estado == "PROCESADO") {
//                                                    $pathArchivo = $docReembolso->pathArchivo;
//                                                    $arrPath = explode("/", $pathArchivo);
//
//                                                    $nuevoPath = str_replace($arrPath[count($arrPath) - 1], "", $pathArchivo) . $docReembolso->estado . "/" . $arrPath[count($arrPath) - 1];
//                                                }
                                                $nuevoPath = $_SESSION['URL_SISTEMA'] . $docReembolso->pathArchivo;
                                                ?>
                                                
                                                
                                                <?php if($_SESSION['Rol']->autorizador == 1){ ?>
                                                <td>
                                                    <?php /*echo $_SESSION['URL_SISTEMA']; echo "<br/>";*/
                                                    if ($docReembolso->estado == "POR_AUTORIZAR") { //APROBADO" && $docReembolso->estado != "RECHAZADO" && $docReembolso->estado != "PROCESADO
                                                        //si es un gasto solo debe aprobar el admin o la persona a quien se le asigno para aprobar (aprobador)
                                                            if ($docReembolso->tipoReembolso == "GASTOS"){
                                                                //si es admin muestra el boton para aprobar
                                                                //si es el mismo usuario al que le dijeron que apruebe tambien muestra el boton
                                                                if($_SESSION['Rol']->id == 1 || $_SESSION['Usuario']->id == $docReembolso->idAprobador){ ?>
                                                                    <button class="btn btn-info fa fa-edit btn-sm" type="button" onclick="abrirModal(<?php echo $docReembolso->id . ",'" . $nuevoPath/*$docReembolso->pathArchivo*/ . "'"; ?>, false, <?php echo "'".$docReembolso->tipoReembolso."','".$docReembolso->estado."'"?>)"></button>
                                                          <?php }
                                                            }elseif($_SESSION['Rol']->id == 4 || $_SESSION['Rol']->id == 5 || $_SESSION['Rol']->id == 1){ 
                                                                //solo para contador, auxiliar y admin ?>
                                                                <button class="btn btn-info fa fa-edit btn-sm" type="button" onclick="abrirModal(<?php echo $docReembolso->id . ",'" . $nuevoPath/*$docReembolso->pathArchivo*/ . "'"; ?>, false, <?php echo "'".$docReembolso->tipoReembolso."','".$docReembolso->estado."'"?>)"></button>
                                                           <?php }
                                                        }else{
                                                            if ($docReembolso->estado == "APROBADO" && $docReembolso->tipoReembolso == "GASTOS" && $docReembolso->tresFirmas == 0
                                                                && ($_SESSION['Rol']->id == 4 || $_SESSION['Rol']->id == 5 || $_SESSION['Rol']->id == 1)){ 
                                                                //solo para contador, auxiliar y admin 
                                                                ?>
                                                                <button class="btn btn-info fa fa-edit btn-sm" type="button" onclick="abrirModal(<?php echo $docReembolso->id . ",'" . $nuevoPath . "'"; ?>, true, <?php echo "'".$docReembolso->tipoReembolso."','".$docReembolso->estado."'"?>)"></button>
                                                        <?php }
                                                        } ?>
                                                </td>
                                                <?php } ?>

                                                
                                                
                                                    
                                                
                                                <?php //para el contador o para el auxiliar
                                                if($_SESSION['Rol']->id == 1 || $_SESSION['Rol']->id == 4 || $_SESSION['Rol']->id == 5){ ?>
                                                <td>
                                                    <button class="btn btn-info fa fa-edit btn-sm" type="button" onclick='abrirDatosContador(<?php echo str_replace("'","",json_encode($docReembolso)); ?>)'></button>
                                                </td>
                                                <td>
                                                    <button class="btn btn-link fa fa-lg fa-envelope-o" type="button" onclick="enviarEmailDevolucion('<?php echo $docReembolso->usuario->nombre; ?>', <?php echo $docReembolso->id; ?>, '<?php echo $nuevoPath ;?>')"></button>
                                                </td>
                                                <?php }  ?>    
                                                    
                                                <td>
                                                    <a href="<?php echo $nuevoPath; ?>" target="_blank"><i class="fa fa-fw fa-lg fa-download"></i></a>
                                                </td>
                                                
                                                <td>
                                                    <?php $mostrar = false; 
                                                    if($_SESSION['Usuario']->id == $docReembolso->usuarioCarga){ //el rol=3 son los jefes 
                                                        $mostrar = true;
                                                    }
                                                    //para el contador o para el auxiliar y admin
                                                    if($_SESSION['Rol']->id == 4 || $_SESSION['Rol']->id == 5 || $_SESSION['Rol']->id == 1){
                                                        $mostrar = true;
                                                    }
                                                    if($mostrar == true){?>
                                                        <button class="btn btn-link fa fa-lg fa-upload" type="button" style="border: none"
                                                            onclick="abrirCargaArchivo(<?php echo $docReembolso->id; ?>)"></button>
                                                    <?php } ?>
                                                </td>
                                                
                                                <td>
                                                    <?php if(isset($docReembolso->justificacionBase64)) { ?>
                                                    <button class="btn btn-link fa fa-lg fa-download" type="button" style="border: none"
                                                            onclick="mostrarJustificativo('<?php echo $docReembolso->justificacionBase64; ?>', '<?php echo $docReembolso->tipoJustificacionBase64; ?>')"></button>
                                                    <?php } ?>
                                                </td>

                                                
                                                <td>
                                                    <button class="btn btn-info fa fa-file-code-o" type="button" style="border: none"
                                                        onclick="mostrarFacturasXml(<?php echo $docReembolso->id ?>)">
                                                    </button>
                                                </td>
                                                
                                                <td style="white-space: nowrap;"><?php echo $docReembolso->estado; ?></td>
                                                <td style="white-space: nowrap;"><?php echo ($docReembolso->tipoReembolso == "VIAJES" ? "LIQUIDACION DE GASTO DE VIAJES" : ($docReembolso->tipoReembolso == "GASTOS" ? "REEMBOLSO DE GASTOS" : $docReembolso->tipoReembolso)); ?></td>
                                                <td style="white-space: nowrap;"><?php echo $docReembolso->usuario->nombre; ?></td>
                                                <td style="white-space: nowrap;"><?php echo date("d/m/Y", $docReembolso->fechaCargaLong / 1000); ?></td>
                                                <td style="white-space: nowrap;"><?php echo $docReembolso->numeroRC; ?></td>
                                                <td style="white-space: nowrap;"><?php echo $docReembolso->aprobador; ?></td>
                                                <td style="white-space: nowrap;"><?php echo $docReembolso->usuarioAutoriza; ?></td>
                                                <td style="white-space: nowrap;"><?php echo $docReembolso->fechaAutorizaLong != null ? date("d/m/Y H:i:s", $docReembolso->fechaAutorizaLong / 1000) : ""; ?></td>
                                                <td style="white-space: nowrap;"><?php echo $docReembolso->usuarioProcesa; ?></td>
                                                <td style="white-space: nowrap;"><?php echo $docReembolso->fechaProcesaLong != null ? date("d/m/Y H:i:s", $docReembolso->fechaProcesaLong / 1000) : ""; ?></td>
                                                <td style="white-space: nowrap;"><?php echo $docReembolso->razonRechazo; ?></td>


                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="12">No existen registros.</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
<?php include 'Template/paginador.php'; ?>


                    </form>


<?php require_once 'Template/Modals/modalAprobarReembolso.php'; ?>
<?php require_once 'Template/Modals/modalDatosContador.php'; ?>
<?php require_once 'Template/Modals/modalCargaArchivo.php'; ?>
                    
                    <?php require_once 'Template/Modals/modalClaveFirmaAprobacion.php'; ?>
<?php require_once 'Template/Modals/modalFacturasReembolso.php'; ?>
                    <script type="text/javascript" src="./Assets/js/functions_descargaMasiva.js"></script>

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

<script type="text/javascript" src="./Assets/js/functions_reembolsos.js"></script>

<script type="text/javascript" src="./Assets/js/functions_archivosxml.js"></script>

<script type="text/javascript">

function abrirModal(idDoc, urlArchivo, terceraFirma, tipoReembolso, estadoReembolso) {

    document.querySelector('#formModalPdf').reset();

    document.querySelector('#archivoPdf').src = urlArchivo;//fileURL;
    document.querySelector('#txtUrlDocReembolso').value = urlArchivo;
    document.querySelector('#txtIdDocReembolso').value = idDoc;
    
    //aqui se controla los estados que se van a mostrar en la ventana de aprobacion.
    //para saber si se aprueba o se procesa
    document.querySelector('#txtRazonRechazo').type = "hidden";
    var cmbEstados = document.querySelector('#selectEstado');
    cmbEstados.innerHTML='';    
    var option = document.createElement("option");
    option.text = "Seleccione estado";
    option.value = null;
    cmbEstados.add(option);
    if(tipoReembolso === "GASTOS"){
        if(estadoReembolso === "POR_AUTORIZAR"){
            var option = document.createElement("option");
            option.text = "APROBADO";
            option.value = "APROBADO";
            cmbEstados.add(option);
        }else{
            var option = document.createElement("option");
            option.text = "PROCESADO";
            option.value = "PROCESADO";
            cmbEstados.add(option);
        }
    }
    else{
        var option = document.createElement("option");
        option.text = "PROCESADO";
        option.value = "PROCESADO";
        cmbEstados.add(option);
    }
    var option = document.createElement("option");
    option.text = "RECHAZADO";
    option.value = "RECHAZADO";
    cmbEstados.add(option);
    //hasta aca
    
    if(terceraFirma === true){
        document.querySelector('#txtTerceraFirma').value = true;
    }

    $('#modalAprobarReembolso').modal('show');
}

function validarSeleccion() {
    console.log("es el id: ", document.querySelector('#txtIdDocReembolso').value);

    if (document.querySelector('#selectEstado').value !== "") {
        if (document.querySelector('#selectEstado').value === "RECHAZADO") {
            if (document.querySelector('#txtRazonRechazo').value !== '') {
                //se envia a firmar y guardar
                //aqui se llama a que muestre el modal de la clave
                solicitarClaveFirma();
                //firmarGuardar();
            } else {
                swal('', 'Ingrese la raz\u00f3n del rechazo', 'warning');
            }
        } else {
            //se envia a firmar y guardar
            //aqui se llama a que muestre el modal de la clave
            solicitarClaveFirma();
//            firmarGuardar();
        }
    } else {
        swal('', 'Seleccione el estado', 'warning');
    }

}

function mostrarRazonRechazo() {
    document.querySelector('#txtRazonRechazo').value = '';
    console.log("--: ", document.querySelector('#selectEstado').value);
    if (document.querySelector('#selectEstado').value === "RECHAZADO") {
        document.querySelector('#txtRazonRechazo').type = "text";
    } else {
        document.querySelector('#txtRazonRechazo').type = "hidden";
    }
}

function firmarGuardar() {
    console.log(";;:", document.querySelector('#modalClaveFirmaAprobacion').style.display);
    
    if(document.querySelector('#modalClaveFirmaAprobacion').style.display === 'block'){
        if(document.querySelector('#txtClaveFirma').value === ''){
            swal('','Ingrese la clave de la firma electrónica.','warning');
            return ;
        }
    }
    
    const LOADING = document.querySelector('.loader');
    LOADING.style = 'display: flex;';

    const formElement = document.querySelector("#formModalPdf");
    const formData = new FormData(formElement);
    
    formData.append('txtClaveFirma', document.querySelector('#txtClaveFirma').value);

    const respuesta = $('.RespuestaAjax');

    $.ajax({
        type: 'POST',
        url: 'acciones/aprobarReembolso.php',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            console.log("respuets: ", (data));
            LOADING.style = 'display: none;';

            respuesta.html(data);
        },
        error: function (error) {
            LOADING.style = 'display: none;';
            console.log("error: ", error);
        }
    });
}

function abrirDatosContador(reembolso){

console.log("reembolco, ", reembolso);

    document.querySelector('#formDatosConta').reset();

    document.querySelector('#idReemb').value = reembolso.id;
    
    
    document.querySelector('#batchIngresoLiquidacion').value = reembolso.batchIngresoLiquidacion;
    document.querySelector('#batchDocumentoInterno').value = reembolso.batchDocumentoInterno;
    document.querySelector('#p3').value = reembolso.p3;
    document.querySelector('#p4').value = reembolso.p4;
    document.querySelector('#p5').value = reembolso.p5;
    document.querySelector('#phne').value = reembolso.phne;
    document.querySelector('#cruce1').value = reembolso.cruce1;
    document.querySelector('#cruce2').value = reembolso.cruce2;
    
    document.querySelector('#divTipoGastos').style.display = "none";
    
    if(reembolso.tipoReembolso === "GASTOS"){
        document.querySelector('#justificativos').value = reembolso.justificativos;
        document.querySelector('#tipoDocumento').value = reembolso.tipoDocumento;
        document.querySelector('#numeroDocumento').value = reembolso.numeroDocumento;
        document.querySelector('#numeroRetencion').value = reembolso.numeroRetencion;
        
        document.querySelector('#divTipoGastos').style.display = "";
        
    }

    $('#modalDatosConta').modal('show');    
}


function enviarEmailDevolucion(usuario, idReembolso, urlArchivo){
    
     swal({
      title: "",
      text: "Se enviar\u00e1 un correo al usuario "+usuario+" solicitando la justificaci\u00f3n del reembolso. ¿Continuar?",
      icon: "warning",
      buttons: [
        'NO',
        'SI'
      ],
      dangerMode: true,
    }).then(function(isConfirm) {
      if (isConfirm) {
          const LOADING = document.querySelector('.loader');
          LOADING.style = 'display: flex;';
          //aqui hacer la llamada ajax
          $.ajax({
            type: 'POST',
            url: 'acciones/enviarCorreoJustificacion.php',
            data: {'idReembolso': idReembolso, 'txtUrlDocReembolso': urlArchivo},
            cache: false,
//            contentType: false,
//            processData: false,
            success: function (data) {
                LOADING.style = 'display: none;';
                if(data === "OK")
                    swal('','Se ha enviado el correo al usuario '+usuario+' para la justificaci\u00f3n del reembolso.','info');
                else
                    swal('',data,'error');
                
                console.log("respuets: ", (data));
            },
            error: function (error) {
                LOADING.style = 'display: none;';
                console.log("error: ", error);
            }
        });
          
        
      } 
//      else { //esto si presionan el NO
//        swal("Cancelled", "Your imaginary file is safe :)", "error");
//      }
    })
}

function abrirCargaArchivo(idReembolso){
    
    console.log("idReembolso: ", idReembolso);
    
    document.querySelector('#formCargaArchivo').reset();

    document.querySelector('#idReembJust').value = idReembolso;

    $('#modalCargaArchivo').modal('show');
}

function mostrarJustificativo(fileBase63, tipof){
    
    var byteCharacters = atob(fileBase63);
    var byteNumbers = new Array(byteCharacters.length);
    for (var i = 0; i < byteCharacters.length; i++) {
      byteNumbers[i] = byteCharacters.charCodeAt(i);
    }
    var byteArray = new Uint8Array(byteNumbers);
    
    //saber el tipo del archivo que es
    console.log("tipof:: ", tipof);
//    var tipoArchivo = "";
//    if(tipof === "pdf")
//        tipoArchivo = 'document/pdf';
//    if(tipof === "gif" || tipof === "png" || tipof === "jpg")
//        tipoArchivo = 'image/'+tipof;
//    if(tipof === "xls" || tipof === "xlsx")
//        tipoArchivo = 'application/vnd.ms-excel';
//    if(tipof === "doc" || tipof === "docx")
//        tipoArchivo = 'application/vnd.ms-word';
    
    var file = new Blob([byteArray], { type: tipof+";base64" });
    var fileURL = URL.createObjectURL(file);
    window.open(fileURL, '_blank', 'height=450,width=375,resizable=1');
}


function solicitarClaveFirma(){
    const LOADING = document.querySelector('.loader');
    LOADING.style.display='flex';

    
    console.log("ESTA EN solicitarClaveFirma");

    $.ajax({
        type: 'POST',
        url: 'acciones/solicitarClaveFirma.php',
        data: {
        },
        success: function (data) {
            LOADING.style.display='none';
            console.log("asi es la data del clavefirma:: ", data);

            if(data.includes("window.location")){
                window.location.replace("index");
            }else{
                
                if(data === "1"){
                    console.log("si es uno");
                    $('#modalClaveFirmaAprobacion').modal('show');
                    console.log("le pongo el focus");
                    document.querySelector('#txtClaveFirma').autofocus = true;
                    document.querySelector('#txtClaveFirma').focus();
                    console.log(document.querySelector('#txtClaveFirma'));
                }
                else{
                    firmarGuardar();
                }

            }

        },
        error: function (error) {
            LOADING.style.display='none';          
            console.log(data);
        }
    });
}

</script>

