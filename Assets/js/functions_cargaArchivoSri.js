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
    actualizarListaDeArchivos();
    $(this).val('');
    
    
    //al seleccionar otro archivo se debe limpiar lo que ya cargaron
    var tbody = document.getElementById('dataSri');
    var inde = tbody.rows.length;
    for(let i=0;i<inde;i++){
//        console.log("i: ", i);
        tbody.deleteRow(0);
//        console.log("va a limpiar");
    }
    var thead = document.getElementById('headSri');
    inde = thead.rows[0].cells.length;
//    console.log("celdads: ", inde);
    for(let i=4;i<inde;i++){
        thead.rows[0].deleteCell(4);
//        console.log("quito cabeza");
    }
    
});


let indexNumAuto = -1;
function cargaArchivoSri() {
    const LOADINGx = document.querySelector('.loader');
    LOADINGx.style = 'display: flex;';
    console.log("bloquea pantalla");

    var millisecondsToWait = 100;
    setTimeout(function() {

        document.getElementById("selectTiposComprobs").value = "";


        if (fileTxt.length === 0) {
    //alert('seleccione al menos un archivo');
            LOADINGx.style = 'display: none;';
            swal("", "Debe seleccionar el archivo .txt", "warning");
        } else {
            LOADINGx.style = 'display: flex;';

            const thead = document.getElementById('headSri');

            const archivo = fileTxt[0];
            const tbody = document.getElementById('dataSri');
            const resp = $('.RespuestaAjax');

    //        console.log("va al filereader");
            var lector = new FileReader();
            lector.onload = function (e) {
                LOADINGx.style = 'display: flex;';

                var contenido = e.target.result;
    //            console.log("contenido: ", contenido.split("\n"));

                const lineas = contenido.split("\n");

                let fila = undefined;

                let tieneAutorizacion = true;


                lineas.map((linea, index) => {
    //                console.log("la linea: ",index , linea, tieneAutorizacion);
                    //comprobar si el archivo a cargar tiene la columna de clave de acceso    
                    if(index === 0){
//                        if(!linea.includes("NUMERO_AUTORIZACION")){ esto cambia porque ene l sri ya no viene esta columna
                        if(!linea.includes("CLAVE_ACCESO")){
                            swal('','El archivo no contiene la columna CLAVE_ACCESO','error');
                            tieneAutorizacion = false;
                        }
                        else{
                            //formar la cabecera de la tabla con las columnas que tiene el archivo
                            const headcolumn = linea.split(/\t/);

                            for(let i=0;i<headcolumn.length;i++){
                                thead.rows[0].insertCell().innerHTML = headcolumn[i];
//                                if(headcolumn[i] === "NUMERO_AUTORIZACION"){
                                if(headcolumn[i] === "CLAVE_ACCESO"){
                                    indexNumAuto = (i+4);
                                    console.log("el index de la columna del numero de autorizacoin: ", indexNumAuto);
                                }
                            }
                        }
                    }

                    if (tieneAutorizacion === true && index > 0) {

                        //antes de generar comprobar si ya tiene esa clave de acceso
                        var existe = false;
                        for (let i = 0; i < tbody.rows.length; i++) {
    //                        console.log("linea: ", linea);
    //                        aqui estaba el 12
                            if (tbody.rows[i].cells[indexNumAuto] && linea.includes(tbody.rows[i].cells[indexNumAuto].innerHTML)) {
    //                        if (tbody.rows[i].cells[12] && linea.includes(tbody.rows[i].cells[12].innerHTML)) {
    //                            console.log("contienes issss");
                                existe = true;
                            }
                        }

                        if (existe === false) {

                            const columnas = linea.split(/\t/);

    //                        console.log("spliittt:: ", columnas);

    //                        console.log("columnas.length: ", columnas.length);
                            if (columnas.length > 1) {
    //                            console.log(linea);


                                fila = tbody.insertRow();


                                fila.insertCell().innerHTML = tbody.rows.length;
                                fila.insertCell().innerHTML = '<input id="chk' + tbody.rows.length + '" type="checkbox" class="" />';
                                fila.insertCell().innerHTML = '';
                                fila.insertCell().innerHTML = 'TEMPORAL';//este es del estado del sistema

                                columnas.map(col => {
    //                                console.log("col: ", col);
                                    fila.insertCell().innerHTML = col;
                                });


                            } else {
    //                            console.log("insertlinea: ", linea);
    //                            if (fila && linea !== '')
    //                                fila.insertCell().innerHTML = linea;
                            }
                        }
                    }
                });

                console.log("quita bloqueo");
                LOADINGx.style = 'display: none;';

            };

            lector.readAsText(archivo, 'ISO-8859-1');
            console.log("leyyoooo");

            fileTxt = [];
            actualizarListaDeArchivos();

        }
        
    }, millisecondsToWait);

}

function actualizarListaDeArchivos() {
    //para el archivo .txt del sri
    let listaHtml = fileTxt.map(function (item, index) {
        return `${item.name}`;
    });
    nombreArchivoTxt.text(listaHtml);

}

function enviarFacturasServer(idUsuarioSession) {
    console.log("a bloeuqar");
    const LOADINGy = document.querySelector('.loader');
    LOADINGy.style.display = "flex";
    
    var millisecondsToWait = 100;
    setTimeout(function() {

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
    //            console.log(select);
            }

            if (existen === true) {

                const detalles = [];

                for (let i = 0; i < tbody.rows.length; i++) {

                    const select = tbody.rows[i].cells[1].children[0].checked;
    //                console.log(select);

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
    //                        claveAcceso: tbody.rows[i].cells[12].innerHTML,
                            claveAcceso: tbody.rows[i].cells[indexNumAuto].innerHTML,
                        };

                        detalles.push(detalle);   
                    }
                }
    //            console.log('detalles: ', (JSON.stringify(detalles)));

                //desde aqui se reemplaza
                let auxDetalles = [];
                let formData = new FormData();
                detalles.map((deta, indexDeta) => {
                    auxDetalles.push(deta);
                    let jsonEnvia = JSON.stringify(auxDetalles);
                    formData.append("detalles", jsonEnvia);
                    if((indexDeta+1) === detalles.length){
                        procesarEnvioArchivoServer(formData, tbody, indexDeta, detalles, LOADINGy);
                        formData = new FormData();
                        auxDetalles = [];
                    }
                    else{
                        if(((indexDeta+1) % 50) === 0){
                            procesarEnvioArchivoServer(formData, tbody, indexDeta, detalles, LOADINGy);
                            formData = new FormData();
                            auxDetalles = [];
                        }
                    }
                });
                //al fin del map hasta aca


            } else {
                LOADINGy.style.display = 'none';
                swal("", "Seleccione al menos un registro.", "warning");
            }

        } else {
            LOADINGy.style.display = 'none';
            swal("", "No hay documentos para cargar.", "warning");
        }
        
    }, millisecondsToWait);
}


function selectTodosXmlSri(source) {
    console.log("en todos los select");
    //solicitado por correo para que se marque todooo
    const tbody = document.getElementById('dataSri');
    const cantDetalles = tbody.rows.length;

    for (let j = 0; j < cantDetalles; j++) {
        //se debe tomar solo los que son input
        for(const childInput of tbody.rows[j].cells[1].children){
            //solo para los tipos input
            if(childInput.tagName === "INPUT"){
                if(childInput.checked !== source.checked){
                    childInput.checked = source.checked;
                }
                
            }
        }
    }
}





function procesarEnvioArchivoServer(formData, tbody, indexDeta, detalles, LOADING){
    
//    var formData = new FormData();
//    formData.append("detalles", JSON.stringify(detalles));

    $.ajax({
        type: 'POST',
        url: 'acciones/cargarArchivoSri.php',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        timeout: 360000, //6 minutos
        async: false,
        success: function (data) {
//                        console.log("respuets: ", (data));
            if(data.includes("window.location") || data.includes("error 404")){
                window.location.replace("index");
            }
            else if(data !== null && data.includes("Time-out")){
                swal('',data,'error');
            }
            else if(data !== null && data !== "null"){
                const rsp = JSON.parse(data);

//                        console.log("hecho json: ", rsp);

                if(rsp !== null){
                    for (let i = 0; i < tbody.rows.length; i++) {
                        rsp.map(rp => {
//                                    console.log("1: ", tbody.rows[i].cells[11].innerText);
//                                    console.log("2: ", rp.claveAcceso);

//                                if (tbody.rows[i].cells[12].innerText === rp.claveAcceso) {//clave de acceso 
                            if (tbody.rows[i].cells[indexNumAuto].innerText === rp.claveAcceso) {//clave de acceso 
//                                        console.log("si iguales");
//                                        console.log("rp.respuesta: ", rp.claveAcceso);

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
                }


                if((indexDeta+1) === detalles.length){
                    console.log("este es dentor de la function");
                    LOADING.style.display = 'none';
                    swal("", "Datos cargados.", "info");
                }

            }
            else{
                if((indexDeta+1) === detalles.length){
                    console.log("dentro funcion del else");
                    LOADING.style.display = 'none';
                    swal("", "Datos vacios, error al cargar los archivos.", "error");
                }
            }
        },
        error: function (error) {
            if((indexDeta+1) === detalles.length){
                LOADING.style.display = 'none';
                console.log("error: ", error);
                if(error.statusText === "timeout"){
                    swal('',error.statusText + " > 360000 ms",'error');
                }
                else
                    swal('',error.responseText,'error');
            }
//                        respuesta.html(error);
        }
    });
    
}



function cambiarMostrarDocs(){
    
    document.querySelector('.loader').style.display='flex';
    console.log("puesto");
    
    var millisecondsToWait = 100;
    setTimeout(function() {
        //desmarcar todos los marcados
        const source = document.getElementById("chkTodos");
        source.checked = false;
        selectTodosXmlSri(source);

        const tbody = document.getElementById('dataSri');
        const cantDetalles = tbody.rows.length;

        const tipoDoc = document.getElementById("selectTiposComprobs").value;

        if(tipoDoc !== ""){
            for(let j=0;j<cantDetalles;j++){
                if(tbody.rows[j].cells[4].innerHTML !== tipoDoc){
                    tbody.rows[j].style.display = "none";
                }
                else{
                    tbody.rows[j].style.display = "";
                }

            }
        }
        else{
            for(let i=0;i<cantDetalles;i++){
                tbody.rows[i].style.display = "";
            }
        }

        document.querySelector('.loader').style.display='none';

    }, millisecondsToWait);
}

