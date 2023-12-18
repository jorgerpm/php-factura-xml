function exportarSeleccionados(idReembolso){
    var tbody = document.getElementById('bodyDataXml');
    
    console.log("long: ", tbody.rows.length);

    if (tbody.rows.length > 0 && tbody.rows[0].cells[0].children[0]) {
        var existen = false;
        var listaCheckClaves = [];
        for (let i = 0; i < tbody.rows.length; i++) {
            var select = tbody.rows[i].cells[0].children[0].checked;
            //el id del check es la clave de acceso
            var idCheckCA = tbody.rows[i].cells[0].children[0].id;
            
            if (select === true) {
                listaCheckClaves.push(idCheckCA);
                existen = true;
                console.log('seelct: ',select);
                //break;
            }
        }
//console.log('listaCheckClaves: ',listaCheckClaves);
        if (existen === true) {
            console.log("si estan selecciopnados");
            if(idReembolso > 0){
                pruebaUnoModal('facturas-data', true, idReembolso, listaCheckClaves);
            }
            else{
                pruebaUno('facturas-data', true, listaCheckClaves);
            }
        }
        else{
            swal("", "Seleccione al menos un registro.", "warning");
        }
    }
    else{
            swal("", "No existen registros.", "warning");
        }

}

function pruebaUno(filename, seleccionados, listaCheckClaves){
    const form = document.getElementById('formListaDocsXml');
    var formdata = new FormData(form);
    exportaXmlCsv(filename, seleccionados, formdata, "sampleTableXml", listaCheckClaves);
}

function pruebaUnoModal(filename, seleccionados, idReembolso, listaCheckClaves){
    const form = document.getElementById('formListaDocsXml');
    var formdata = new FormData(form);
    
    formdata.append("btnSearch", true);
    formdata.append("txtDesde", 0);
    formdata.append("dtFechaIni", new Date().toISOString());
    formdata.append("dtFechaFin", new Date().toISOString());
    formdata.append("idReembolso", idReembolso);
    
    exportaXmlCsv(filename, seleccionados, formdata, "tableFacturasReembolso", listaCheckClaves);
}

function exportaXmlCsv(filename, seleccionados, formdata, idTabla, listaCheckClaves){
        const LOADING = document.querySelector('.loader');
            LOADING.style = 'display: flex;';
            
//        const form = document.getElementById('formListaDocsXml');
        
        const conDetalles = document.getElementById('txtConDetalles');
        
        console.log("es con detalle>: ", conDetalles.checked);
        
//        var formdata = new FormData(form);
        formdata.append("seleccionados", seleccionados);
        formdata.append("conDetalles", conDetalles.checked);
        formdata.append("listaCheckClaves", listaCheckClaves);
        
        console.log("listaCheckClaves:: ", listaCheckClaves);

    $.ajax({
        type: 'POST',
        url: 'acciones/listarArchivos.php',
        data: formdata ? formdata : form.serialize(),
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            var csv = [];

//data = JSON.stringify(data);

            data = data.replaceAll("[", "").replaceAll("]", "").replaceAll('"', '').replaceAll(',', '').replaceAll('Array', '').replaceAll('(', '').replaceAll(')', '').replaceAll('\n', '');
//            console.log(data);
            
            csv = data.split("~");

            for(var i=0;i<csv.length;i++){
                csv[i] = csv[i].toString().replaceAll(i+" => ", "").replaceAll("  ", "");
            }
            
            //comprobar las columnas
            //se utiliza con el ocultar columnas
            var tableXml = document.getElementById(idTabla);
            var tbody = document.getElementById('bodyDataXml');
                        
//            console.log("el csv ", csv[0]);

            var arrayCols = [];
                
                for(i=0;i<tableXml.rows[0].cells.length-1;i++){
                    if(tableXml.rows[0].cells[i+1].style.display !== "none"){
//                        for(j=0;j<csv[0].length;j++){ noooo
                        var nomCol = tableXml.rows[0].cells[i+1].innerHTML;
                        var datascv = csv[0].split(';');

                        for(let j=0;j<datascv.length;j++){
                            if(datascv[j] == nomCol){
    //                            console.log(nomCol);
                                arrayCols.push(j);
                                break;
                            }
                        }
                    }
                }
                //se agrega  mas columnas por el tema de los detalles
                if(conDetalles && conDetalles.checked === true){//si esta marcado el con detalles
                    arrayCols.push(datascv.length-10);
                    arrayCols.push(datascv.length-9);
                    arrayCols.push(datascv.length-8);
                    arrayCols.push(datascv.length-7);
                    arrayCols.push(datascv.length-6);
                    arrayCols.push(datascv.length-5);
                    arrayCols.push(datascv.length-4);
                    
                    arrayCols.push(datascv.length-3);
                    arrayCols.push(datascv.length-2);
                }
//            }
            
            let csvFinal = [];
            
            for(let i=0;i<csv.length;i++){
                let filaAux = [];
                let csvAux = csv[i].split(";");
//                console.log("csv[i]: ", csv[i]);
                for(let j=0;j<csvAux.length;j++){
//                    console.log("comparativo", arrayCols.find(a=>a===j));
                    if(arrayCols.find(a=>a===j) >= 0){
                        filaAux.push(csvAux[j]);
//                        console.log(csvAux[j]);
                    }
                }
                
                if(seleccionados === true){
                    console.log("si ha estado seleccc: ", seleccionados);
                
//                console.log("filaAux[7]: ", filaAux);
                
                    if(i === 0){
                        csvFinal.push(filaAux.join(";"));
                    }
                    else{
                        console.log("posicionxxx: ", (i-1));
//                        if((i-1) < tbody.rows.length){
                            for(let k=0;k<tbody.rows.length;k++){
    //                            console.log("es en el for: ", k);
                                if(tbody.rows[k].cells[0].children[0].checked === true){
    //                                console.log("esta checked:: ", tbody.rows[k].cells[0].children[0]);
    //                                console.log("1: ", tbody.rows[k].cells[8].innerText);
    //                                console.log("2: ", tbody.rows[k].cells[0].children[0].id);
                                    if(filaAux[5] === tbody.rows[k].cells[0].children[0].id){
//                                        console.log("filaAux:: ", filaAux);
                                        //console.log("seleccionado ", filaAux);
                                        csvFinal.push(filaAux.join(";"));
                                    }
                                }
                            }
//                        }
                    }
                }
                else{
                    csvFinal.push(filaAux.join(";"));
                }

                    
            }
//            console.log("success, ", csv);
            
            // Download CSV file
    downloadCSV(csvFinal.join("\n"), filename);
//downloadCSV(csv, filename);
            conDetalles.checked = false;
            
            LOADING.style = 'display: none;';
            
        },
        error: function (error) {
            console.log("error: ", error);
            LOADING.style = 'display: none;';
        }
    });
        
    }