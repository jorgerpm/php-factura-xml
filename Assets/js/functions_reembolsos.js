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

