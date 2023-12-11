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
        console.log("el archivo:: ", uu.type);
        if(uu.type === "text/xml")
            fileXml.push(uu);
        else{
            swal("", "Debe seleccionar un archivo de tipo XML.", "warning");
            return;
        }
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
        console.log("el archivo:: ", uu.type);
        if(uu.type === "application/pdf")
            filePdf.push(uu);
        else{
            swal("", "Debe seleccionar un archivo de tipo PDF.", "warning");
            return;
        }
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
    
    const tipoDoc = document.getElementById("txtTipoDoc");
    if(tipoDoc.value === ''){
        swal("", "Seleccione el tipo de documento.", "warning");
    }
    else{
        if (fileXml.length === 0) {
    //alert('seleccione al menos un archivo');
            swal("", "Debe seleccionar al menos el archivo xml del comprobante a cargar.", "warning");
        } else {
try{
            const LOADING = document.querySelector('.loader');
            LOADING.style = 'display: flex;';

            var formData = new FormData();
            var resp = $('.RespuestaAjax');
            
            formData.append("txtTipoDoc", tipoDoc.value);

            // Read selected files
            fileXml.forEach(fe => {
                formData.append("archivos[]", fe);
                console.log('archivo xml: ', fe);
            });
            filePdf.forEach(fe => {
                formData.append("archivos[]", fe);
                console.log('archivo pdf: ', fe);
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

                        swal("", "Archivos cargados correctamente", "success")
                                .then(t=>{window.location.href = "cargarXml";});
                    } else {
                        LOADING.style = 'display: none;';
                        resp.html(response);
                        swal("", "Error en la carga del archivo. " + response, "error");
                    }

                } else {
                    LOADING.style = 'display: none;';
                    console.log("this.responseText: ", this);
                    console.log("this.readyState: ", this.readyState);
                    console.log("this.status: ", this.status);
                    if(this.status === 0){
                        swal("", this.status+" No se puede acceder al archivo. Revise que la ubicación del archivo sea correcta.", "error");
                    }
                    else{
                        swal("2", this.status+" Error en la carga del archivo. " + this.responseText, "error");
                    }
                }
            };

            // Send request with data
            xhttp.send(formData);
                
            }catch(err){
                    console.log("exc:: ", err);
            }
        }
    }

}
