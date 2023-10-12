function openModalRazonRechazo(val_datos) {
    document.querySelector('#formRazonRechazo').reset();
    if(val_datos !== null){
        document.querySelector('#idRazon').value = val_datos.id;
        document.querySelector('#txtRazon').value = val_datos.razon;
        document.querySelector('#cbxListaEstado').value = val_datos.idEstado;
    }
    else{
        document.querySelector('#idRazon').value = null;
    }
    $('#modalFormRazonRechazo').modal('show');
}