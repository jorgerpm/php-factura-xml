//para cargar el archivo txt del sri
var inputFileTxt = $("#inputFileTxt");
var nombreArchivoTxt = $("#archivoTxt");
var fileTxt = [];

//para cargar el archivo txt del sri
inputFileTxt.on('change', function (e) {
    fileTxt = [];

    let files = e.target.files;

    if (files.length === 0)
        return;

    files = Array.from(files);
    files.forEach(uu => {
        console.log("el archivo:: ", uu.type);
        if (uu.type === "text/plain")
            fileTxt.push(uu);
        else {
            swal("", "Debe seleccionar un archivo .txt", "warning");
            return;
        }
    });
    actualizarListaDeArchivos(3);
    $(this).val('');
});



function cargaArchivoSri() {

    if (fileTxt.length === 0) {
//alert('seleccione al menos un archivo');
        swal("", "Debe seleccionar el archivo .txt", "warning");
    } else {

        var archivo = fileTxt[0];
        var tbody = document.getElementById('dataSri');
        var resp = $('.RespuestaAjax');

        console.log("va al filereader");
        var lector = new FileReader();
        lector.onload = function (e) {

            const LOADING = document.querySelector('.loader');
            LOADING.style = 'display: flex;';

            var contenido = e.target.result;
//            console.log("contenido: ", contenido.split("\n"));

            const lineas = contenido.split("\n");


            var fila = undefined;

            lineas.map((linea, index) => {
                if (index > 1) {

                    //antes de generar comprobar si ya tiene esa clave de acceso
                    var existe = false;
                    for (let i = 0; i < tbody.rows.length; i++) {
//                        console.log("linea: ", linea);
//                        console.log("calveacceso: ", tbody.rows[i].cells[10].innerHTML);
                        if (linea.includes(tbody.rows[i].cells[12].innerHTML)) {
                            console.log("contienes issss");
                            existe = true;
                        }
                    }

                    if (existe === false) {
                        const columnas = linea.split("\t");

                        console.log("columnas.length: ", columnas.length);
                        if (columnas.length > 1) {
//                            console.log(linea);



                            fila = tbody.insertRow();


                            fila.insertCell().innerHTML = tbody.rows.length;
                            fila.insertCell().innerHTML = '<input id="chk' + tbody.rows.length + '" type="checkbox" class="" />';
                            fila.insertCell().innerHTML = '';
                            fila.insertCell().innerHTML = 'TEMPORAL';//este es del estado del sistema

                            columnas.map(col => {
//                                console.log("col: ", col);
                                if (col !== '')
                                    fila.insertCell().innerHTML = col;
                            });
                        } else {
//                            console.log("insertlinea: ", linea);
                            if (fila && linea !== '')
                                fila.insertCell().innerHTML = linea;
                        }
                    }
                }
            });


            LOADING.style = 'display: none;';


        };
        lector.readAsText(archivo, 'ISO-8859-1');
        console.log("leyyoooo");

        fileTxt = [];
        actualizarListaDeArchivos(3);

    }

}

function actualizarListaDeArchivos() {
    //para el archivo .txt del sri
    let listaHtml = fileTxt.map(function (item, index) {
        return `${item.name}`;
    });
    nombreArchivoTxt.text(listaHtml);

}

function enviarFacturasServer(idUsuarioSession) {
    var tbody = document.getElementById('dataSri');
    var respuesta = $('.RespuestaAjax');

    if (tbody.rows.length > 0) {
        var existen = false;
        for (let i = 0; i < tbody.rows.length; i++) {
            const select = tbody.rows[i].cells[1].children[0].checked;
            if (select === true) {
                existen = true;
                break;
            }
            console.log(select);
        }

        if (existen === true) {
            const LOADING = document.querySelector('.loader');
            LOADING.style = 'display: flex;';

            var formData = new FormData();

            const detalles = [];

            for (let i = 0; i < tbody.rows.length; i++) {

                const select = tbody.rows[i].cells[1].children[0].checked;
                console.log(select);

                if (select === true) {
                    const detalle = {
                        comprobante: tbody.rows[i].cells[4].innerHTML,
                        numeroDocumento: tbody.rows[i].cells[5].innerHTML,
//                        ruc: tbody.rows[i].cells[4].innerHTML,
//                        razonSocial: tbody.rows[i].cells[5].innerHTML,
                        idUsuarioCarga: idUsuarioSession,
                        //                comprobante: tbody.rows[i].cells[6].innerHTML,
                        //                comprobante: tbody.rows[i].cells[7].innerHTML,
                        //                comprobante: tbody.rows[i].cells[8].innerHTML,
                        //                comprobante: tbody.rows[i].cells[9].innerHTML,
                        claveAcceso: tbody.rows[i].cells[12].innerHTML,
                    };

                    detalles.push(detalle);
                }

            }
            console.log('detalles: ', (JSON.stringify(detalles)));

            formData.append("detalles", JSON.stringify(detalles));
            //        formData.append("detalles", detalles);

            $.ajax({
                type: 'POST',
                url: 'acciones/cargarArchivoSri.php',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log("respuets: ", (data));
                    if(data.includes("window.location") || data.includes("error 404")){
                        window.location.replace("index");
                    }
                    else if(data !== null){
                        const rsp = JSON.parse(data);

                        console.log("hecho json: ", rsp[0]);

                        for (let i = 0; i < tbody.rows.length; i++) {
                            rsp.map(rp => {
                                console.log("1: ", tbody.rows[i].cells[11].innerText);
                                console.log("2: ", rp.claveAcceso);

                                if (tbody.rows[i].cells[12].innerText === rp.claveAcceso) {//clave de acceso 
                                    console.log("si iguales");
                                    console.log("rp.respuesta: ", rp.claveAcceso);

                                    if (rp.respuesta === "OK") {
                                        //var check = '<div><input type="checkbox" id="envio' + i + '" onchange="seleccionarParaEnvio(this, \'' + rp.id.toString() + '\');"></div>';
                                        tbody.rows[i].cells[2].innerHTML = "CARGADO OK";// + check;

                                    } else if (rp.respuesta.includes("La clave de acceso")) {
//                                        var check = "";
//                                        if(rp.estadoSistema === "CARGADO")
                                            //check = '<div><input type="checkbox" id="envio' + i + '" onchange="seleccionarParaEnvio(this, \'' + rp.id.toString() + '\');"></div>';
                                        
                                        tbody.rows[i].cells[2].innerHTML = "YA EXISTE";// + check;
                                    } else {
                                        tbody.rows[i].cells[2].innerHTML = "ERROR: " + rp.respuesta;
                                    }
                                    //aqui se pone el estado del sistema
                                    if(rp.estadoSistema)
                                        tbody.rows[i].cells[3].innerHTML = rp.estadoSistema;
                                }
                            });
                        }

    //                    respuesta.html(rsp[0].comprobante);
                        LOADING.style = 'display: none;';
                        swal("", "Datos cargados.", "info");
                        
                    }
                    else{
                        LOADING.style = 'display: none;';
                        swal("", "Datos vacios, error al cargar los archivos.", "error");
                    }
                },
                error: function (error) {
                    LOADING.style = 'display: none;';
                    console.log("error: ", error);
                    respuesta.html(error);
                }
            });

        } else {
            swal("", "Seleccione al menos un registro.", "warning");
        }

    } else {
        swal("", "No hay documentos para cargar.", "warning");
    }
}


function selectTodos(source) {
    const tbody = document.getElementById('dataSri');
    const cantDetalles = tbody.rows.length;

    for (let j = 1; j <= cantDetalles; j++) {
        var checkboxes = document.querySelectorAll('input[id="chk' + [j] + '"]');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i] != source)
                checkboxes[i].checked = source.checked;
        }
    }
}


const listaClavesAcceso = [];
const listaTiposGasto = [];
var listaAsistentes = [];

function seleccionarParaEnvio(checkbox, idReg) {
    console.log(checkbox.checked);
    console.log(idReg);
    
    const tipoGasto = document.getElementById("txtTipoGasto"+idReg).value;
    const txtAsistentes = document.getElementById("txtAsistentes"+idReg).value;
    
    console.log("tipoGasto: ", tipoGasto);
    if(tipoGasto !== null && tipoGasto !== ''){
        if (checkbox.checked === true) {
            listaClavesAcceso.push(idReg.toString());
            console.log("agregado");
            listaTiposGasto.push(idReg.toString() + ":" + tipoGasto);
            listaAsistentes.push(idReg.toString() + ":" + txtAsistentes);
        } else {
            const index = listaClavesAcceso.indexOf(idReg.toString());
            listaClavesAcceso.splice(index, 1);
            console.log("eliminador: ", listaClavesAcceso);
            listaTiposGasto.splice(index, 1);
            listaAsistentes.splice(index, 1);
        }
    }
    else{
        checkbox.checked = false;
        swal('','Seleccione el tipo de gasto','warning');
        const index = listaClavesAcceso.indexOf(idReg.toString());
        console.log("index:: ", index);
        listaClavesAcceso.splice(index, 1);
        console.log("eliminador: ", listaClavesAcceso);
        listaTiposGasto.splice(index, 1);
        listaAsistentes.splice(index, 1);
    }
}

function cambiarTipoReembolso(idReg){
    const tipoGasto = document.getElementById("txtTipoGasto"+idReg).value;
    const index = listaClavesAcceso.indexOf(idReg.toString());
    listaTiposGasto[index] = idReg.toString() + ":" + tipoGasto;
}

function colocarAsistentes(){
    listaAsistentes = [];
    listaClavesAcceso.map(id => {
        const txtAsistentes = document.getElementById("txtAsistentes"+id).value;
        if(txtAsistentes){
            listaAsistentes.push(id.toString() + ":" + txtAsistentes);
        }
    });
}


function mostrarModalDatosReembolso(){
    if(listaClavesAcceso.length > 0){
        document.querySelector('#formDatosReemb').reset();

        const tipoR = document.querySelector('#txtTipoPdf').value;

        if(tipoR){

            if(tipoR === "GASTOS"){
                document.querySelector('#lblSeleccion').style.display= "";
                document.querySelector('#txtSeleccion').style.display= "";

                document.querySelector('#txtValorEntregado').style.display= "none";
                document.querySelector('#lblValorEntregado').style.display= "none";
                document.querySelector('#lblObservaciones').style.display= "none";
                document.querySelector('#txtObservaciones').style.display= "none";
            }
            else{
                document.querySelector('#lblSeleccion').style.display= "none";
                document.querySelector('#txtSeleccion').style.display= "none";

                document.querySelector('#txtValorEntregado').style.display= "";
                document.querySelector('#lblValorEntregado').style.display= "";
                document.querySelector('#lblObservaciones').style.display= "";
                document.querySelector('#txtObservaciones').style.display= "";
            }

            $('#modalDatosReemb').modal('show');

        }else{
            swal("", "Seleccione un tipo de reembolso.", "warning");
        }
    }else{
        swal("", "Seleccione al menos un registro.", "warning");
    }
}

function ejecutarReporteFirma(ids) {
    if(listaClavesAcceso.length > 0){
        var txtTipoPdf = document.getElementById("txtTipoPdf").value;
        
        const panelValido = validarForm();
        
        if(txtTipoPdf){
            if(panelValido){
                
                $('#modalDatosReemb').modal('hide');

                const LOADING = document.querySelector('.loader');
                LOADING.style = 'display: flex;';

                colocarAsistentes();

                console.log("los ds: ", ids);

                $.ajax({
                    type: 'POST',
                    url: 'acciones/ejecutarReportes.php',
                    data: {'reporte': "NOFIRMA", 'ids': ids.toString(), 
                        'tiposGasto':listaTiposGasto.toString(), 'tipo': 'firma',
                        'tipoReembolso': txtTipoPdf,
                        'txtAprobador': 0,
                        'asistentes': listaAsistentes.toString(),
                        
                        'motivoViaje': document.querySelector('#txtMotivoViaje').value,
                        'periodoViaje': document.querySelector('#txtPeriodoViaje').value,
                        'lugarViaje': document.querySelector('#txtLugarViaje').value,
                        'fondoEntregado': document.querySelector('#txtValorEntregado').value,
                        'observaciones': document.querySelector('#txtObservaciones').value,
                        'seleccion': document.querySelector('#txtSeleccion').value
                    },
                    success: function (data) {
                        LOADING.style = 'display: none;';          
            //            console.log(data);

                        if(data.includes("window.location")){
                            window.location.replace("index");
                        }else{

                            var byteCharacters = atob(data);
                            var byteNumbers = new Array(byteCharacters.length);
                            for (var i = 0; i < byteCharacters.length; i++) {
                              byteNumbers[i] = byteCharacters.charCodeAt(i);
                            }
                            var byteArray = new Uint8Array(byteNumbers);
                            var file = new Blob([byteArray], { type: 'application/pdf;base64' });
                            var fileURL = URL.createObjectURL(file);

                            document.querySelector('#formModalPdf').reset();
                            document.querySelector('#archivoPdf').src = fileURL;
                            document.querySelector('#txtClaves').value = ids;
                            document.querySelector('#txtTiposGasto').value = listaTiposGasto;
                            document.querySelector('#txtListaAsistentes').value = listaAsistentes;
                            document.querySelector('#txtTipoReembolso').value = txtTipoPdf;


                            if(txtTipoPdf !== "GASTOS" /*&& document.querySelector('#lblAprobador')*/){
    //                            document.querySelector('#uno').removeChild(document.querySelector('#lblAprobador'));
    //                            document.querySelector('#dos').removeChild(document.querySelector('#txtAprobador'));
                                document.querySelector('#lblAprobador').style.display = "none";
                                document.querySelector('#txtAprobador').style.display = "none";
                            }
                            else{
                                document.querySelector('#lblAprobador').style.display = "";
                                document.querySelector('#txtAprobador').style.display = "";
                            }

                            $('#modalPdf').modal('show');

                        }

                    },
                    error: function (error) {
                        LOADING.style = 'display: none;';
                        console.log(data);
                    }
                });
            
            }else{
                swal("", "Complete todos los datos.", "warning");
            }
        }else{
            swal("", "Seleccione un tipo de reembolso.", "warning");
        }
        
    }else{
        swal("", "Seleccione al menos un registro.", "warning");
    }

}


function validarForm(){
    console.log("mm: ", document.querySelector('#txtMotivoViaje').value.length);
    
    if(document.querySelector('#txtMotivoViaje').value.length === 0)
        return false;
    if(document.querySelector('#txtPeriodoViaje').value.length === 0)
        return false;
    if(document.querySelector('#txtLugarViaje').value.length === 0)
        return false;
        
    const tipoR = document.querySelector('#txtTipoPdf').value;
    
    if(tipoR === "GASTOS"){
        console.log("tipoR: ", tipoR);
        if(document.querySelector('#txtSeleccion').value.length === 0)
            return false;
        
        if(document.querySelector('#txtSeleccion').value === "JUSTIFICACIÓN FONDOS DE ATENCIÓN")
            if(document.querySelector('#txtValorEntregado').value.length === 0)
                return false;
        
    }
    else{  
        console.log("mm: ", document.querySelector('#txtValorEntregado').value.length);
        if(document.querySelector('#txtValorEntregado').value.length === 0)
            return false;
    }
    
    return true;
    
}

function cambiarValor(){
    if(document.querySelector('#txtSeleccion').value === "JUSTIFICACIÓN FONDOS DE ATENCIÓN"){
        document.querySelector('#txtValorEntregado').style.display = "";
        document.querySelector('#lblValorEntregado').style.display= "";
    }
    else{
        document.querySelector('#txtValorEntregado').style.display = "none";
        document.querySelector('#lblValorEntregado').style.display= "none";
    }
}

function enviarFirmar(ids) {
    
    
    const txtAprobador = document.getElementById("txtAprobador").value;
    const txtTipoPdf = document.getElementById("txtTipoPdf").value;
    
    console.log("txtAprobador: ", txtAprobador);
    console.log("txtTipoPdf: ", txtTipoPdf);
    
    if(txtTipoPdf === "GASTOS"){
        if(txtAprobador){
        //continua
        }
        else{
            swal('','Seleccione el usuario aprobador','warning');
            return;
        }
    }
    
    

    $('#modalPdf').modal('hide');
    const LOADING = document.querySelector('.loader');
    LOADING.style = 'display: flex;';

    //const txtTipoPdf = document.getElementById("txtTipoPdf").value;

    $.ajax({
        type: 'POST',
        url: 'acciones/ejecutarReportes.php',
        data: {'reporte': "SIFIRMA", 'ids': ids.toString(), 
            'tiposGasto':listaTiposGasto.toString(), 'tipo': 'firma',
            'tipoReembolso': txtTipoPdf,
            'txtAprobador': txtAprobador ? txtAprobador: 0,
            'asistentes': listaAsistentes.toString(),
            
            'motivoViaje': document.querySelector('#txtMotivoViaje').value,
            'periodoViaje': document.querySelector('#txtPeriodoViaje').value,
            'lugarViaje': document.querySelector('#txtLugarViaje').value,
            'fondoEntregado': document.querySelector('#txtValorEntregado').value,
            'observaciones': document.querySelector('#txtObservaciones').value,
            'seleccion': document.querySelector('#txtSeleccion').value
        },
        success: function (data) {
            LOADING.style = 'display: none;';          
            console.log(data);

            if(data.includes("window.location")){
                window.location.replace("index");
            }
            else if(data.includes("ERROR")){
                swal('',data,'error');
            }
            else if(data.includes("CORRECTO")){
                swal('',"Datos almacenados correctamente.",'info').then((value)=>{
                    const btnBuscar = document.querySelector('#btnBuscaXmlCargados');
                    btnBuscar.click();
                });

            }
            else{

                var byteCharacters = atob(data);
                var byteNumbers = new Array(byteCharacters.length);
                for (var i = 0; i < byteCharacters.length; i++) {
                  byteNumbers[i] = byteCharacters.charCodeAt(i);
                }
                var byteArray = new Uint8Array(byteNumbers);
                var file = new Blob([byteArray], { type: 'application/pdf;base64' });
                var fileURL = URL.createObjectURL(file);

                document.querySelector('#formModalPdf').reset();
                document.querySelector('#archivoPdf').src = fileURL;
                document.querySelector('#txtClaves').value = ids;
                document.querySelector('#txtTiposGasto').value = listaTiposGasto;
                document.querySelector('#txtListaAsistentes').value = listaAsistentes;
                document.querySelector('#txtTipoReembolso').value = txtTipoPdf;


                $('#modalPdf').modal('show');

            }

        },
        error: function (error) {
            LOADING.style = 'display: none;';
            console.log(data);
        }
    });
        
    
    
    
}


