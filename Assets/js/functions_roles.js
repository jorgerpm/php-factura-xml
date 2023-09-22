function openModalRol(val_datos) {
//    alert(val_datos.nombre);
//    alert(val_datos.id);
    document.querySelector('#formRol').reset();
    if(val_datos !== null){
        document.querySelector('#idRol').value = val_datos.id;
        document.querySelector('#txtNombre').value = val_datos.nombre;
        document.querySelector('#chkPrincipal').checked = val_datos.principal;
        document.querySelector('#listStatus').value = val_datos.idEstado;
        document.querySelector('#chkAutorizador').checked = val_datos.autorizador;
        
        document.querySelector('#bFactura').checked = val_datos.bFactura;
        document.querySelector('#bRetencion').checked = val_datos.bRetencion;
        document.querySelector('#bNotaCredito').checked = val_datos.bNotaCredito;
        document.querySelector('#bNotaDebito').checked = val_datos.bNotaDebito;
        document.querySelector('#bGuiaRemision').checked = val_datos.bGuiaRemision;
        
        console.log("val_datos.autorizador: ", val_datos.autorizador);
    }
    else{
        document.querySelector('#idRol').value = null;
    }
//    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
//    document.querySelector('#btnActionFormxx').classList.replace("btn-info", "btn-primary");
//    document.querySelector('#btnText').innerHTML = "Guardar";
//    document.querySelector('#titleModal').innerHTML = "Gesti&oacute;n de rol";
    $('#modalFormRol').modal('show');
}