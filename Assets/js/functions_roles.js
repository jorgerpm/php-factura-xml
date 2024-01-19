var listaEmpres = [];
function openModalRol(val_datos) {
    
    listaEmpres = [];
    document.querySelector('#formRol').reset();
    if(val_datos !== null){
        
        console.log("idepresas: ", val_datos.listaIdEmpresas);
        
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
        
        document.querySelector('#chkDatosContable').checked = val_datos.datosContable;
        document.querySelector('#chkCargaLiquidacion').checked = val_datos.cargaliquidacion;
        document.querySelector('#txtListaEmpresas').value = val_datos.listaIdEmpresas;
        
        if(val_datos.listaIdEmpresas.length > 0){
            if(val_datos.listaIdEmpresas.includes(",")){
                var llist = val_datos.listaIdEmpresas.split(",");
                llist.map(l => {
                    listaEmpres.push(l);
                    document.getElementById(l).checked = true;
                });
            }
            else{
                listaEmpres.push(val_datos.listaIdEmpresas);
                document.getElementById(val_datos.listaIdEmpresas).checked = true;
            }
        }
        
        console.log("listaEmpres: ", listaEmpres);
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

function ingresarEmpresaLista(checkEmp){
//    var list = document.querySelector('#txtListaEmpresas').value;
    if(checkEmp.checked){
        listaEmpres.push(checkEmp.id);
    }
    else{
        var index = listaEmpres.indexOf(checkEmp.id);
        listaEmpres.splice(index, 1);
    }
    document.querySelector('#txtListaEmpresas').value = listaEmpres;
}