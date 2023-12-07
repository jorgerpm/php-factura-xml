function mostrarFacturasXml(idReembolso){
    console.log("el id: ", idReembolso);
    
    
    var div = document.getElementById('divListaFacturasReembolso');
    
    //var form = document.getElementById('formReembolsos');
    
    var formdata = new FormData();
    formdata.append("btnSearch", true);
    formdata.append("txtDesde", 0);
    formdata.append("dtFechaIni", new Date().toISOString());
    formdata.append("dtFechaFin", new Date().toISOString());
    formdata.append("idReembolso", idReembolso);
    
    
    $.ajax({
        type: 'POST',
        url: 'acciones/listarFacturasReembolso.php',
        data: formdata,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            div.innerHTML = data;
        },
        error: function (error) {
            console.log("error: ", error);
        }
    });
    
    div.innerHTML = '';
    
    
    $('#modalFacturasReembolso').modal('show');
}

function ocultarColumna(toggle, numCol){
//    console.log("toggletoggle:: ", toggle);
    
    var tableXml = document.getElementById('tableFacturasReembolso');

    var inputCheck = toggle.children[0];

//    console.log("$(this).children(0);", inputCheck);
//    console.log("numcol: ", numCol);

    for(let i=0;i<tableXml.rows.length;i++){
        if(tableXml.rows[i].cells[numCol] && tableXml.rows[i].cells[numCol].style.display !== "none"){
            tableXml.rows[i].cells[numCol].style.display="none";
            if(i === 0){
                inputCheck.style.color = "yellow";
                inputCheck.className = "fa fa-times";
            }
        }
        else{
            if(tableXml.rows[i].cells[numCol])
                tableXml.rows[i].cells[numCol].style.display="table-cell";

            if(i === 0){
                inputCheck.style.color = "white";
                inputCheck.className = "fa fa-check";
            }
        }
    }
}

function exportarReembolsos(){
    var LOADING = document.querySelector('.loader');
    LOADING.style = 'display: flex;';
//    var condetalles = document.getElementById("chkConDetallesR").value;
    
    const form = document.getElementById('formReembolsos');
    var formdata = new FormData(form);
    
    $.ajax({
        type: 'POST',
        url: 'acciones/exportarReembolsosCsv.php',
        data: formdata ? formdata : form.serialize(),
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            //crear un div temporal
            var newDiv = document.createElement("div");
            newDiv.innerHTML = data;
            var tabla = newDiv.children[0];
            
//            console.log( tabla);
            
            var csv = [];
            var rows = tabla.rows;
            for (var i = 0; i < rows.length; i++) {
                var row = [];
                var cols = rows[i].querySelectorAll("td, th");

                for (var j = 0; j < cols.length; j++) {
                    row.push(cols[j].innerText);
                }
                csv.push(row.join(";"));
            }
            csv = csv.join("\n");

            //para descargar
            var csvFile;
            var downloadLink;
            // CSV file
            csvFile = new Blob([csv], {type: "text/csv"});
            // Download link
            downloadLink = document.createElement("a");
            // File name
            downloadLink.download = "listareembolsos.csv";
            // Create a link to the file
            downloadLink.href = window.URL.createObjectURL(csvFile);
            // Hide download link
            downloadLink.style.display = "none";
            // Add the link to DOM
            document.body.appendChild(downloadLink);
            // Click download link
            downloadLink.click();
            
            //quitar el div creado
            newDiv.remove();
            
            LOADING.style = 'display: none;';
        },
        error: function (error) {
            console.log("error: ", error);
            LOADING.style = 'display: none;';
        }
    });
    
}