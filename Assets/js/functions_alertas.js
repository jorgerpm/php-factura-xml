/*function uploadFile() {
 var totalfiles = document.getElementById('archivos').files.length;
 if(totalfiles > 0 ){
 var formData = new FormData();
 //Leer los archivos seleccionados
 for (var index = 0; index < totalfiles; index++) {
 formData.append("archivos[]", document.getElementById('archivos').files[index]);
 }
 var xhttp = new XMLHttpRequest();
 //Enviar $POST a la función cargarXmlControlador.php
 xhttp.open("POST", "./Controllers/cargarXmlControlador.php", true);
 //Mostrar los cambios de estado
 xhttp.onreadystatechange = function() {
 if (this.readyState == 4 && this.status == 200) {
 var response = this.responseText;
 alert(response + " Archivos cargados");
 }
 };
 //Enviar solicitud de datos
 xhttp.send(formData);
 }else{
 alert("Por favor seleccione archivos");
 }
 }*/



/* --------------------------------  -----------------------*/
var inputFileXml = $("#inputFileXml");
var inputFilePdf = $("#inputFilePdf");

var nombreArchivoXml = $("#archivoXml");
var nombreArchivoPdf = $("#archivoPdf");
var fileXml = [];
var filePdf = [];


function actualizarListaDeArchivos(tipo) {
    if (tipo === 1) {
        let listaHtml = fileXml.map(function (item, index) {
            return `${item.name}`;
        });
        nombreArchivoXml.text(listaHtml);
    } else {
        let listaHtml = filePdf.map(function (item, index) {
            return `${item.name}`;
        });
        nombreArchivoPdf.text(listaHtml);
    }
}

inputFileXml.on('change', function (e) {
    fileXml = [];
    
    let files = e.target.files;

    if (files.length === 0)
        return;

    files = Array.from(files);
    files.forEach(uu => {
        fileXml.push(uu);
    });
    actualizarListaDeArchivos(1);
    $(this).val('');
});
inputFilePdf.on('change', function (e) {
    filePdf = [];
    
    let files = e.target.files;

    if (files.length === 0)
        return;

    files = Array.from(files);
    files.forEach(uu => {
        filePdf.push(uu);
    });
    actualizarListaDeArchivos(2);
    $(this).val('');
});

/*$(document).on("click", ".file-list-eliminar", function () {
    let index = $(this).data('index');
    archivosParaSubir.splice(index, 1);
    actualizarListaDeArchivos();
});*/

// Upload file
function uploadFile() {
    if (fileXml.length === 0) {
//alert('seleccione al menos un archivo');
        swal("", "Debe seleccionar al menos el archivo xml de la factura", "warning");
    } else {
        
        const LOADING = document.querySelector('.loader');
        LOADING.style = 'display: flex;';

        var formData = new FormData();

        // Read selected files
        fileXml.forEach(fe => {
            formData.append("archivos[]", fe);
            console.log('arhicvo: ', fe);
        });
        filePdf.forEach(fe => {
            formData.append("archivos[]", fe);
            console.log('arhicvo: ', fe);
        });

        var xhttp = new XMLHttpRequest();

        // Set POST method and ajax file path
        xhttp.open("POST", "./acciones/cargarArchivos.php", true);

        // call on request changes state
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {

                var response = this.responseText;

                if (response === "OK") {
                    LOADING.style = 'display: none;';

                    fileXml = [];
                    filePdf = [];
                    actualizarListaDeArchivos(1);
                    actualizarListaDeArchivos(2);

                    swal("", "Archivos cargados correctamente", "success");
                } else {
                    LOADING.style = 'display: none;';
                    swal("", "Error en la carga del archivo. " + response, "error");
                }

            } else {
                LOADING.style = 'display: none;';
                swal("2", "Error en la carga del archivo. " + this.responseText, "error");
            }
        };

        // Send request with data
        xhttp.send(formData);
    }

}
