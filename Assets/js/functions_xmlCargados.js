function eliminarXmlCargado(idXml){
    console.log("id: ", idXml);
    swal({
        text: "¿Está de acuerdo con eliminar el registro?",
        icon: "warning",
        buttons: {cancel: "NO", si: "SI"},
        dangerMode: true,
    }).then(value=>{
        console.log("value: ", value);
        if(value === "si"){
            const LOADING = document.querySelector('.loader');
            LOADING.style = 'display: flex;';
    
            var respuesta = $('.RespuestaAjax');
    
            $.ajax({
                type: 'POST',
                url: 'acciones/eliminarXmlCargado.php',
                data: {idXml: idXml},
                cache: false,
                success: function (data) {
                    LOADING.style = 'display: none;';
                    respuesta.html(data);
//                    window.location.reload();
                },
                error: function (error) {
                    LOADING.style = 'display: none;';
                    console.log("error: ", error);
                }
            });
        }
    });
}

function abrirModalMiscelaneo(){
    document.querySelector('#formMiscelaneo').reset();
    
    $('#modalFormMiscelaneo').modal('show');
}