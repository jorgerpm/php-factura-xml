const listaArchivosXml = [];
function addArchivoXml(urlArchivo, checkbox){
    if (checkbox.checked === true) {
        listaArchivosXml.push(urlArchivo);
        console.log("agregado el ", urlArchivo);
    }
    else{
        const index = listaArchivosXml.indexOf(urlArchivo);
        listaArchivosXml.splice(index, 1);
        console.log("elimimando ", urlArchivo);
    }
}

function crearZipDescargar(){
    
    if(listaArchivosXml.length > 0){
        
        const LOADING = document.querySelector('.loader');
        LOADING.style = 'display: flex;';

        $.ajax({
            type: 'POST',
            url: 'acciones/crearZip.php',
            data: {listaArchivosXml: listaArchivosXml},
            cache: false,
    //        contentType: false,
    //        processData: false,
            success: function (data) {
                console.log("data: ", data);
                LOADING.style = 'display: none;';
                
                if(data.includes("window.location")){
                    window.location.replace("index");
                }
                else{
                    //esta parte es para crear el link de descarga
                    var downloadLink = document.createElement("a");
                    // File name
                    var nombreArray = data.toString().split("/");
                    downloadLink.download = nombreArray[nombreArray.length-1];
                    // Create a link to the file
                    downloadLink.href = data;
                    // Hide download link
                    downloadLink.style.display = "none";
                    // Add the link to DOM
                    document.body.appendChild(downloadLink);
                    // Click download link
                    downloadLink.click();
                }
                
            },
            error: function (error) {
                LOADING.style = 'display: none;';
                console.log("error: ", error);
                swal('',error,'error');
            }
        });
    }
    else{
        swal('','Seleccione al menos un registro.','warning');
    }
}

function marcarTodosXml(checkbox){
    //agregarXml
    var checkboxes = document.querySelectorAll('.agregarXml');
    console.log("checkboxes: ", checkboxes.length);
    for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].click();
            checkboxes[i].checked = checkbox.checked;
    }
    
}