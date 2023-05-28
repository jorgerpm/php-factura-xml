function openModal(val_datos) {
    
    console.log("json::: " + val_datos);
    
    document.querySelector('#formFirmaDigital').reset();
    
    if (val_datos !== null) {
        document.querySelector('#idFirmaDigital').value = val_datos.id;
//        document.querySelector('#txtArchivo').filename = "val_datos.archivo";
//        console.log("fecha:: ", new Date(val_datos.fechaCaducaLong).toLocaleString('en-CA'));
        
        document.querySelector('#txtFecha').value = new Date(val_datos.fechaCaducaLong).toLocaleString('en-CA').split(",")[0];
        document.querySelector('#txtClave').value = val_datos.txtClave;
        
        if(document.querySelector('#cbxListUser'))
            document.querySelector('#cbxListUser').value = val_datos.usuario.id;
    
        document.querySelector('#txtTipoFirma').value = val_datos.tipoFirma;
        document.querySelector('#cbxListaEstado').value = val_datos.idEstado;
    } else {
        document.querySelector('#idFirmaDigital').value = null;
    }
    $('#modalFirmaDigital').modal('show');
}




var inputFile = $("#txtArchivo");
inputFile.on('change', function (e) {
    const tipoFirma = document.getElementById('txtTipoFirma').value;
    if(tipoFirma !== null && tipoFirma !== ""){
        var fileXml = [];

        let files = e.target.files;

        if (files.length === 0)
            return;

        files = Array.from(files);
        files.forEach(uu => {
            console.log("el archivo:: ", uu.type);
            if(tipoFirma === "0"){//si es electronica
                if(uu.type === "application/pkcs12"){
                    fileXml.push(uu);
        //            $(this).val(files);
                }
                else{
                    swal("", "Debe seleccionar un archivo de tipo .P12", "warning");
                    $(this).val('');
                    return;
                }
            }
            if(tipoFirma === "1"){//si es una imagen
                if(uu.type === "image/gif"){
                    fileXml.push(uu);
        //            $(this).val(files);
                }
                else{
                    swal("", "Debe seleccionar un archivo de tipo .gif", "warning");
                    $(this).val('');
                    return;
                }
            }
        });
    }
    else{
        swal('','Primero seleccione el tipo de firma.','warning');
        $(this).val('');
        return;
    }
});


function cambioTipoFirma(){
    const tipoFirma = document.getElementById('txtTipoFirma').value;
    if(tipoFirma === "1"){//es imagen
        document.getElementById('txtClave').value = "1234567890";
        document.getElementById('txtFecha').value = new Date().toISOString().split('T')[0];
        
        document.getElementById('txtClave').readOnly = true;
        document.getElementById('txtFecha').readOnly = true;
    }
    if(tipoFirma === "0"){//es imagen
        document.getElementById('txtClave').value = "";
        document.getElementById('txtFecha').value = "";
        
        document.getElementById('txtClave').readOnly = false;
        document.getElementById('txtFecha').readOnly = false;
    }
}