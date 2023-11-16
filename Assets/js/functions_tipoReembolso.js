function openModalTipoReembolso(val_datos) {
    document.querySelector('#formTipoReembolso').reset();
    if(val_datos !== null){
        document.querySelector('#idTipoReembolso').value = val_datos.id;
        document.querySelector('#txtTipo').value = val_datos.tipo;
        document.querySelector('#txtSecuencial').value = val_datos.secuencial;
        document.querySelector('#txtNomenclatura').value = val_datos.nomenclatura;
        document.querySelector('#txtEsPrincipal').value = val_datos.esPrincipal;
        
    }
    else{
        document.querySelector('#idTipoReembolso').value = null;
    }
    $('#modalTipoReembolso').modal('show');
}