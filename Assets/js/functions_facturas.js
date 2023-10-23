//para indicar cuantos decimales se quiere trabajar
const CANT_DECIMALES = 2;

function agregarFila() {
    var tbody = document.getElementById('tbodySol');
    var index = tbody.rows.length;

//esta es para cuando se agrega con el calculo autmatico con las funciones en los input y con el aplica iva check
/*
    tbody.insertRow().innerHTML = '<td><input id="' + index + '" type="button" value="x" onclick="eliminarFila(this);" /></td>'
            + '<td><input type="number" id="txtCantidad' + index + '" style="width: 100%" required /></td>'
            + '<td><input id="txtDetalle' + index + '" style="width: 100%; text-transform: uppercase;" required /></td>'
    
            + '<td><input id="chkIva'+index+'" type="checkbox" onclick="valorTotal()"/></td>'
    
            + '<td><input type="number" id="txtValorUnitario'+index+'" onkeyup="valorTotalDetalle(' + index + ')" required style="width: 100%" /></td>'
            + '<td><label id="lblValorTotal'+index+'" >0</label>'
            + '<input type="hidden" id="txtIdDetalle' + index + '" name="txtIdDetalle' + index + '" value="0" /></td>';
 */
    tbody.insertRow().innerHTML = '<td><input id="' + index + '" type="button" value="x" onclick="eliminarFila(this);" /></td>'
            + '<td><input type="number" id="txtCantidad' + index + '" style="width: 100%" required onkeyup="calcularTotalDetalles()"/></td>'
            + '<td><input id="txtDetalle' + index + '" style="width: 100%; text-transform: uppercase;" required pattern="^[a-zA-Z0-9\u00f1\u00d1\u00E0-\u00FC]([a-zA-Z0-9\u00f1\u00d1\u00E0-\u00FC ]*)" minlength="4" /></td>'
    
            + '<td><input type="number" step="any" id="txtValorUnitario'+index+'" required style="width: 100%" onkeyup="calcularTotalDetalles()"/></td>'
            + '<td><input type="number" step="any" id="txtDescuento'+index+'" required style="width: 100%" onkeyup="calcularTotalDetalles()"/></td>'
            + '<td><input type="number" step="any" id="lblValorTotal'+index+'" required style="width: 100%" />'
            + '<input type="hidden" id="txtIdDetalle' + index + '" name="txtIdDetalle' + index + '" value="0" /></td>';
}

function eliminarFila(input) {
//    let tabla = document.getElementById('tblDetSolicitud');
    var tbody = document.getElementById('tbodySol');

//        console.log(input.id);

    let index = input.id;

    tbody.deleteRow(index);
    //alert(tabla.rows[index].innerHTML);
    for (i = 0; i < tbody.rows.length; i++) {
        tbody.rows[i].cells[0].children[0].id = i;
        tbody.rows[i].cells[1].children[0].id = 'txtCantidad' + i;
        tbody.rows[i].cells[2].children[0].id = 'txtDetalle' + i;
//        tbody.rows[i].cells[3].children[0].id = 'chkIva' + i;
        tbody.rows[i].cells[3].children[0].id = 'txtValorUnitario' + i;
        tbody.rows[i].cells[4].children[0].id = 'txtDescuento' + i;
        tbody.rows[i].cells[5].children[0].id = 'lblValorTotal' + i;
        
        //para el input oculto
        tbody.rows[i].cells[5].children[1].id = 'txtIdDetalle' + i;

//            console.log(tabla.rows[i].cells[0].children[0].id);
//            console.log(tabla.rows[i].cells[1].children[0].id);
        console.log(tbody.rows[i].cells[3].children[0].id);
    }

    calcularTotalDetalles();
}


function toggle(source) {
    var tbody = document.getElementById('tbodySol');
    const cantDetalles = tbody.rows.length;
    
    for (j = 0; j < cantDetalles; j++) {
        var checkboxes = document.querySelectorAll('input[id="chkIva' + [j] + '"]');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i] != source)
                checkboxes[i].checked = source.checked;
        }
    }

    valorTotal();
}

function valorTotalDetalle(index) {
    var tbody = document.getElementById('tbodySol');
    const cantDetalles = tbody.rows.length;
    //calcular el valor del registro actual
    var cantidad = parseFloat(document.getElementById('txtCantidad' + index).value);
    var txtValUnit = document.getElementById('txtValorUnitario' + index).value;
    
    var valUnit = 0;
    if (!isNaN(txtValUnit) && txtValUnit !== '') {
        valUnit = parseFloat(txtValUnit);
    }
    var valTotalDet = cantidad * valUnit;
    console.log("valTotalDet: ", valTotalDet);
    
    //este metodo "formatNumber.new" esta en el archivo main.js
    document.getElementById('lblValorTotal' + index).innerHTML = miFormatoNumber.new(valTotalDet, CANT_DECIMALES);//aqui estaba con 4 decimales

    valorTotal(cantDetalles);
}

function valorTotal() {
    var tbody = document.getElementById('tbodySol');
    const cantDetalles = tbody.rows.length;
    //recorrer todos los registros para obtener el subtotal
    let subtotal = 0;
    let subtotalSinIva = 0;
    for (j = 0; j < cantDetalles; j++) {

        var lblValTotal = document.getElementById('lblValorTotal' + j).innerHTML;
        lblValTotal = lblValTotal.replace(",", "");
        
        var tieneIva = document.getElementById('chkIva' + j).checked;

        if (!isNaN(lblValTotal) && lblValTotal !== '') {
            
            if (tieneIva)
                subtotal += parseFloat(lblValTotal);
            else
                subtotalSinIva += parseFloat(lblValTotal);
        }
    }
    document.getElementById('lblSubtotal').innerHTML = miFormatoNumber.new(subtotal, CANT_DECIMALES);
    document.getElementById('lblSubtotalSinIva').innerHTML = miFormatoNumber.new(subtotalSinIva, CANT_DECIMALES);

    var iva = subtotal * 0.12;
    document.getElementById('lblIva').innerHTML = miFormatoNumber.new(iva, CANT_DECIMALES);
    var total = subtotalSinIva + subtotal + iva;
    document.getElementById('lblTotal').innerHTML = miFormatoNumber.new(total, CANT_DECIMALES);
}

function chdgd(){
    const tipoIva = document.getElementById("txtTipoIva").value;
        
        console.log("cod: ", tipoIva.split("-")[0]);
        console.log("tar: ", tipoIva.split("-")[1]);
}

$('#formFacturaFisica').submit(function (e) {

    e.preventDefault(); //no se envíe el submit todavía

    var tbody = document.getElementById('tbodySol');
    if (tbody.rows.length > 0) {
        
        //ver que el numero de factura sea correcto
        var txtNumeroFactura = document.getElementById('txtNumeroFactura').value;
        if(txtNumeroFactura.split("-").length > 2){

            console.log('inicia la cargaaaaxxxxxxxxxxxx');
            const LOADING = document.querySelector('.loader');
            LOADING.style = 'display: flex;';

            var form = $(this);
            var respuesta = form.children('.RespuestaAjax');

            var formdata = new FormData(this);


            formdata.append('registrosTabla', tbody.rows.length);

            const detaArray = [];

            for (let i = 0; i < tbody.rows.length; i++) {
                //alert(tabla.rows[i].cells[0].innerHTML);


                let cant = document.getElementById('txtCantidad' + i).value;
                let det = document.getElementById('txtDetalle' + i).value;

                let valUnit = document.getElementById('txtValorUnitario' + i).value;
                let valDesc = document.getElementById('txtDescuento' + i).value;
                let valTot = document.getElementById('lblValorTotal' + i).value;

                let idDetalle = document.getElementById('txtIdDetalle' + i).value;
                //


    //            formdata.append('txtCantidad' + i, cant);
    //            formdata.append('txtDetalle' + i, det);
    //            formdata.append('txtIdDetalle' + i, idDetalle);
    //            formdata.append('txtValorUnitario' + i, valUnit);
    //            formdata.append('txtDescuento' + i, valDesc);
    //            formdata.append('lblValorTotal' + i, valTot);

                const detalle = {
                    cantidad: cant,
                    descripcion: det.toUpperCase(),
                    valorUnitario: valUnit,
                    descuento: valDesc,
                    valorTotal: valTot,
                };

                detaArray.push(detalle);
            }


            const tipoIva = document.getElementById("txtTipoIva").value;

            formdata.append('txtTipoIva', tipoIva.split("-")[0]);
            formdata.append('txtTarifa', tipoIva.split("-")[1]);


            formdata.append('listaDetalles', JSON.stringify(detaArray));

            $.ajax({
                type: 'POST',
                url: './acciones/guardarFacturaFisica.php',
                data: formdata ? formdata : form.serialize(),
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    LOADING.style = 'display: none;';
                    console.log('fiiiinnn   successss', data);
                    if(data.includes("window.location.replace")){
                        window.location.replace("index");
                    }
                    respuesta.html(data);
                },
                error: function (error) {
                    LOADING.style = 'display: none;';
                    console.log('fiiiinnn   errrroooorr: ', error);
                    if(error.includes("window.location.replace")){
                        window.location.replace("index");
                    }
                    respuesta.html(error);
                },
                statusCode: {
                    404: function () {
    //              alert( "page not found" );
                    }
                }
            }).done(function (data) {
    //        console.log("se hixxoooo", data);//tambien
            })
            .fail(function () {
    //    alert( "error" );
            })
            .always(function () {
    //    alert( "complete" );
            });
                    
        } else {
            swal("", "El número de la factura debe tener el formato 000-000-000000000.", "warning");
        }
    } else {
        swal("", "Ingrese los detalles a la factura.", "warning");
    }

});


var miFormatoNumber = {
    separador: ",", // separador para los miles
    sepDecimal: '.', // separador para los decimales
    formatear:function (num, decs){
        num = num.toFixed(decs);
       num +='';
       var splitStr = num.split('.');
       var splitLeft = splitStr[0];
       var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
       var regx = /(\d+)(\d{3})/;
       while (regx.test(splitLeft)) {
           splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
       }
       return this.simbol + splitLeft +splitRight;
    },
    new:function(num, decs, simbol){
        this.simbol = simbol ||'';
        decs = decs || 0;
        return this.formatear(num, decs);
    }
}




function calcularIvaTotales(){
    try{
        const subiva = document.getElementById("lblSubtotal");
        const iva = document.getElementById("lblIva");
        const total = document.getElementById("lblTotal");
        const subsiniva = document.getElementById("lblSubtotalSinIva");

        if(!subiva.value){
           subiva.value = 0;
        }   
        if(!subsiniva.value){
            subsiniva.value = 0;
        }

        iva.value = parseFloat(parseFloat(subiva.value) * 12 / 100).toFixed(2);
        total.value = parseFloat(parseFloat(subiva.value) + parseFloat(iva.value) + parseFloat(subsiniva.value)).toFixed(2);
        
    }catch(error){
        console.log("error: ", error);
    }
    
}


function calcularTotalDetalles(){
    var tbody = document.getElementById('tbodySol');
    let index = tbody.rows.length;
    let descTot = 0;

    for(let i=0;i<index;i++){
        
        const txtCantidad = document.getElementById("txtCantidad"+i);
        const txtValorUnitario = document.getElementById("txtValorUnitario"+i);
        const txtDescuento = document.getElementById("txtDescuento"+i);
        const lblValorTotal = document.getElementById("lblValorTotal"+i);

        if(!txtCantidad.value){
            txtCantidad.value = 0;
        }
        if(!txtValorUnitario.value){
            txtValorUnitario.value = 0;
        }
        if(!txtDescuento.value){
            txtDescuento.value = 0;
        }

        lblValorTotal.value = parseFloat((parseFloat(txtValorUnitario.value) * parseFloat(txtCantidad.value)) - parseFloat(txtDescuento.value)).toFixed(2);
        
        
        if(txtDescuento.value){
            descTot = parseFloat(parseFloat(descTot) + parseFloat(txtDescuento.value)).toFixed(2);
        }
    }
    document.getElementById("lblDescuentoTotal").value = descTot;
    
}

function ponerGuion(input, event){
//    console.log("eventooo:: ", event);
    if(event.keyCode >= 48 && event.keyCode <= 57){
        if(input.value.length === 3 || input.value.length === 7){
            input.value = input.value + "-";
        }
        else{
            if(input.value.length > 3 && input.value.length < 7){
                input.value = input.value.replace("-", "");
//                console.log(input.value.substring(0,3));
//                console.log(input.value.substring(3));

                input.value = input.value.substring(0,3) + "-" + input.value.substring(3);
            }
            if(input.value.length > 7){
                input.value = input.value.substring(0,7) + "-" + input.value.substring(8);
            }
        }
    }
}

function traerDatosProveedor(datosRuc){
    if(datosRuc.value !== null && datosRuc.value !== ''){
        if(datosRuc.value.length !== 13){
            swal("","El número de ruc debe tener 13 dígitos.","warning");
            return;
        }
    }
    
    const LOADING = document.querySelector('.loader');
    LOADING.style = 'display: flex;';
    
    $.ajax({
        type: 'POST',
        url: './acciones/traerDatosProveedor.php',
        data: {txtRuc: datosRuc.value},
        cache: false,
        success: function (data) {
            LOADING.style = 'display: none;';
            console.log('fiiiinnn   successss', data);
            if(data.includes("window.location.replace")){
                window.location.replace("index");
            }
            var dataJson = JSON.parse(data);
            document.querySelector('#txtProveedor').value = dataJson.nombre;
//            document.querySelector('#txtDirecProv').value = dataJson.direccion;
            
        },
        error: function (error) {
            LOADING.style = 'display: none;';
            console.log('fiiiinnn   errrroooorr: ', error);
            if(error.includes("window.location.replace")){
                window.location.replace("index");
            }
            swal("",error,"error");
        },
        statusCode: {
            404: function () {
//              alert( "page not found" );
            }
        }
    }).done(function (data) {
//        console.log("se hixxoooo", data);//tambien
    })
    .fail(function () {
//    alert( "error" );
    })
    .always(function () {
//    alert( "complete" );
    });
    
}