function abrirCargaLiquidacionCompra(idReembolso, numeroReembolso, tipoReembolso){
    
    console.log("idReembolso: ", idReembolso);
    
    document.querySelector('#formCargaLiquidacionCompra').reset();

    document.querySelector('#idReembLQ').value = idReembolso;
    document.querySelector('#numeroReembolsoLC').value = numeroReembolso;
    document.querySelector('#tipoReembolsoLC').value = tipoReembolso;

    $('#modalCargaLiquidacionCompra').modal('show');
}


function abrirModalLiquidacion(idReembolso, urlArchivo) {

    document.querySelector('#formModalFirmaLiquidacion').reset();

    document.querySelector('#archivoPdfLC').src = urlArchivo;//fileURL;
    document.querySelector('#txtUrlLiquidacion').value = urlArchivo;
    document.querySelector('#txtIdReembs').value = idReembolso;
    
    $('#modalFirmaLiquidacion').modal('show');
}


function solicitarClaveFirmaLC(){
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
                    $('#modalClaveFirmaLiquidacion').modal('show');
                    console.log("le pongo el focus");
                    document.querySelector('#txtClaveFirmaLC').autofocus = true;
                    document.querySelector('#txtClaveFirmaLC').focus();
                    console.log(document.querySelector('#txtClaveFirmaLC'));
                }
                else{
                    firmarGuardarLC();
                }

            }

        },
        error: function (error) {
            LOADING.style.display='none';          
            console.log(data);
        }
    });
}

function firmarGuardarLC() {
    console.log(";;:", document.querySelector('#modalClaveFirmaLiquidacion').style.display);
    
    if(document.querySelector('#modalClaveFirmaLiquidacion').style.display === 'block'){
        if(document.querySelector('#txtClaveFirmaLC').value === ''){
            swal('','Ingrese la clave de la firma electrónica.','warning');
            return ;
        }
    }
    
    const LOADING = document.querySelector('.loader');
    LOADING.style = 'display: flex;';

    const formElement = document.querySelector("#formModalFirmaLiquidacion");
    const formData = new FormData(formElement);
    
    formData.append('txtClaveFirmaLC', document.querySelector('#txtClaveFirmaLC').value);

    const respuesta = $('.RespuestaAjax');

    $.ajax({
        type: 'POST',
        url: 'acciones/firmarLiquidacionCompra.php',
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