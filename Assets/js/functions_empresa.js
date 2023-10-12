function openModalEmpresa(val_datos) {
    document.querySelector('#formEmpresa').reset();
    if(val_datos !== null){
        document.querySelector('#idEmpresa').value = val_datos.id;
        document.querySelector('#txtRuc').value = val_datos.ruc;
        document.querySelector('#txtRazonSocial').value = val_datos.razonSocial;
        document.querySelector('#txtNombreComercial').value = val_datos.nombreComercial;
        document.querySelector('#txtDireccion').value = val_datos.direccion;
        document.querySelector('#txtTelefono').value = val_datos.telefono;
        document.querySelector('#txtEmail').value = val_datos.email;
        document.querySelector('#cbxListaEstado').value = val_datos.idEstado;
    }
    else{
        document.querySelector('#idEmpresa').value = null;
    }
    $('#modalFormEmpresa').modal('show');
}