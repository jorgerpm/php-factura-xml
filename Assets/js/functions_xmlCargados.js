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
        
        //VERIFICAR QUE los campos "asistente" esten llenos de todos los seleccionados
        var tbody = document.getElementById('dataSri');
        var cantDetalles = tbody.rows.length;

        var valorAsistente = true;
        for (let j = 0; j < cantDetalles; j++) {
            //se debe tomar solo los que son input
            for(const childInput of tbody.rows[j].cells[0].children){
                //solo para los tipos input
                if(childInput.tagName === "INPUT" && childInput.checked){
                    var txtAsistentes = tbody.rows[j].cells[3].children[0].value;
                    if(txtAsistentes === null || txtAsistentes === ''){
                        valorAsistente = false;
                    }
                }
            }
        }
        if(valorAsistente === false){
            swal('','Debe completar todos los campos asistentes/detalle de los elementos marcados.','warning');
            return;
        }
        
        
        var tipoR = document.querySelector('#txtTipoPdf').value;

        if(tipoR){

            if(tipoR === "5"){
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
                LOADING.style.display='flex';

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
                        'seleccion': document.querySelector('#txtSeleccion').value,
                        'numeroRC': document.querySelector('#txtNumeroRC').value,
//                        'claveFirma': document.querySelector('#txtClaveFirma').value
                    },
                    success: function (data) {
                        LOADING.style.display='none';
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


                            if(txtTipoPdf !== "5" /*&& document.querySelector('#lblAprobador')*/){
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
                        LOADING.style.display='none';          
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
    if(document.querySelector('#txtNumeroRC').value.length === 0)
        return false;
        
    const tipoR = document.querySelector('#txtTipoPdf').value;
    
    if(tipoR === "5"){
        console.log("tipoR: ", tipoR);
        if(document.querySelector('#txtSeleccion').value.length === 0)
            return false;
        
        if(document.querySelector('#txtSeleccion').value === "3"){
            if(document.querySelector('#txtValorEntregado').value.length === 0)
                return false;
        }
        
    }
    else{  
        console.log("mm: ", document.querySelector('#txtValorEntregado').value.length);
        if(document.querySelector('#txtValorEntregado').value.length === 0)
            return false;
    }
    
    return true;
    
}

function cambiarValor(){
    if(document.querySelector('#txtSeleccion').value === "3"){
        document.querySelector('#txtValorEntregado').style.display = "";
        document.querySelector('#lblValorEntregado').style.display= "";
    }
    else{
        document.querySelector('#txtValorEntregado').style.display = "none";
        document.querySelector('#lblValorEntregado').style.display= "none";
    }
}

function enviarFirmar(ids) {
    
    console.log(";;:", document.querySelector('#modalClaveFirma').style.display);
    
    if(document.querySelector('#modalClaveFirma').style.display === 'block'){
        if(document.querySelector('#txtClaveFirma').value === ''){
            swal('','Ingrese la clave de la firma electrónica.','warning');
            return ;
        }
    }
    
    const txtAprobador = document.getElementById("txtAprobador").value;
    const txtTipoPdf = document.getElementById("txtTipoPdf").value;
    
    console.log("txtAprobador: ", txtAprobador);
    console.log("txtTipoPdf: ", txtTipoPdf);
    
    if(txtTipoPdf === "5"){
        if(txtAprobador){
        //continua
        }
        else{
            swal('','Seleccione el usuario aprobador','warning');
            return;
        }
    }
    
    

    //$('#modalPdf').modal('hide');
    const LOADING = document.querySelector('.loader');
    LOADING.style.display='flex';

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
            'seleccion': document.querySelector('#txtSeleccion').value,
            'claveFirma': document.querySelector('#txtClaveFirma').value,
            'numeroRC': document.querySelector('#txtNumeroRC').value,
        },
        success: function (data) {
            LOADING.style.display='none';
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
            LOADING.style.display='none';
            console.log(data);
        }
    });
           
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
                    $('#modalClaveFirma').modal('show');
                }
                else{
                    enviarFirmar(listaClavesAcceso);
                }

            }

        },
        error: function (error) {
            LOADING.style.display='none';          
            console.log(data);
        }
    });
}


function selectTodos(source) {
    //soliictado por correo para que se marque todooo
    const tbody = document.getElementById('dataSri');
    const cantDetalles = tbody.rows.length;

    for (let j = 0; j < cantDetalles; j++) {
        //se debe tomar solo los que son input
        for(const childInput of tbody.rows[j].cells[0].children){
            //solo para los tipos input
            if(childInput.tagName === "INPUT"){
                //esto es para cuando ya vienen marcados por defecto, no les debe volver a marcar
                //y que no se dupliquen los valores
                if(childInput.checked !== source.checked){
                    childInput.checked = source.checked;
                    seleccionarParaEnvio(childInput, childInput.id);
                }
                
            }
        }
    }
}