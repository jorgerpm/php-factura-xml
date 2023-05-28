function openModalUsuario(val_datos) {
    document.querySelector('#formUsuario').reset();
    if(val_datos !== null){
        document.querySelector('#idUsuario').value = val_datos.id;
        document.querySelector('#txtNombre').value = val_datos.nombre;
        document.querySelector('#txtUsuario').value = val_datos.usuario;
        document.querySelector('#txtCorreo').value = val_datos.correo;
        document.querySelector('#cbxListaRol').value = val_datos.idRol;
        document.querySelector('#cbxListaEstado').value = val_datos.idEstado;
        
        document.querySelector('#txtClave').value = "986777f98F&b42b69b19";//val_datos.clave;
        document.querySelector('#txtClaveAux').value = "986777f98F&b42b69b19";//val_datos.clave;
    }
    else{
        document.querySelector('#idUsuario').value = null;
    }
    $('#modalFormUsuario').modal('show');
}