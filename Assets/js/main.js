(function () {
    "use strict";

    var treeviewMenu = $('.app-menu');

    // Toggle Sidebar
    $('[data-toggle="sidebar"]').click(function (event) {
        event.preventDefault();
        $('.app').toggleClass('sidenav-toggled');
    });

    // Activate sidebar treeview toggle
    $("[data-toggle='treeview']").click(function (event) {
        event.preventDefault();
        if (!$(this).parent().hasClass('is-expanded')) {
            treeviewMenu.find("[data-toggle='treeview']").parent().removeClass('is-expanded');
        }
        $(this).parent().toggleClass('is-expanded');
    });

    // Set initial active toggle
    $("[data-toggle='treeview.'].is-expanded").parent().toggleClass('is-expanded');

    //Activate bootstrip tooltips
    $("[data-toggle='tooltip']").tooltip();

})();


/**
 * funcion para cuando se realiza el submit de un formulario
 * **/
$('.FormularioAjax').submit(function (e) {
    console.log('inicia la cargaaaa');
    const LOADING = document.querySelector('.loader');
    LOADING.style = 'display: flex;';
    
    e.preventDefault(); //no se envíe el submit todavía

    var form = $(this);

    var tipo = form.attr('data-form');
    var accion = form.attr('action');
    var metodo = form.attr('method');
    var respuesta = form.children('.RespuestaAjax');

    var msjError = "<script>swal('Ocurrió un error inesperado','Por favor recargue la página','error');</script>";
    var formdata = new FormData(this);


    var textoAlerta;
    if (tipo === "save") {
        textoAlerta = "Los datos que enviaras quedaran almacenados en el sistema";
    } else if (tipo === "delete") {
        textoAlerta = "Los datos serán eliminados completamente del sistema";
    } else if (tipo === "update") {
        textoAlerta = "Los datos del sistema serán actualizados";
    } else if (tipo === "login") {
        textoAlerta = "Acceder al sistema";
    } else {
        textoAlerta = "Quieres realizar la operación solicitada";
    }


//        swal({
//            title: "¿Estás seguro?",   
//            text: textoAlerta,   
//            type: "question",   
//            showCancelButton: true,     
//            confirmButtonText: "Aceptar",
//            cancelButtonText: "Cancelar"
//        }).then(function () {
    $.ajax({
        type: metodo,
        url: accion,
        data: formdata ? formdata : form.serialize(),
        cache: false,
        contentType: false,
        processData: false,
        /*xhr: function(){
         var xhr = new window.XMLHttpRequest();
         xhr.upload.addEventListener("progress", function(evt) {
         if (evt.lengthComputable) {
         var percentComplete = evt.loaded / evt.total;
         percentComplete = parseInt(percentComplete * 100);
         if(percentComplete<100){
         respuesta.html('<p class="text-center">Procesado... ('+percentComplete+'%)</p><div class="progress progress-striped active"><div class="progress-bar progress-bar-info" style="width: '+percentComplete+'%;"></div></div>');
         }else{
         respuesta.html('<p class="text-center"></p>');
         }
         }
         }, false);
         return xhr;
         },*/
        success: function (data) {
            LOADING.style = 'display: none;';
            console.log('fiiiinnn   successss');
            respuesta.html(data);
        },
        error: function (error) {
            LOADING.style = 'display: none;';
            console.log('fiiiinnn   errrroooorr');
            respuesta.html(error);
        }
    });
//            return false;
//        });
});



/**esta parte sirve para inciar sesion en el sistema y enviar encriptado la clave del user*/
$('.FormLogin').submit(function (e) {
    const LOADING = document.querySelector('.loader');
    LOADING.style = 'display: flex;';
    
    e.preventDefault(); //no se envíe el submit todavía

//var textUsuario = $("#Usuario");
    var textClave = document.querySelector("#Clave");
    textClave.value = md5(textClave.value);
    
    var form = $(this);

    var accion = form.attr('action');
    var metodo = form.attr('method');
    var respuesta = form.children('.RespuestaAjax');

    var formdata = new FormData(this);
//    formdata.append("clave", md5(textClave.value));
//    form.append("clave", md5(textClave.value));

    $.ajax({
        type: metodo,
        url: accion,
        data: formdata ? formdata : form.serialize(),
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if(!data.includes("window.location.href"))
                LOADING.style = 'display: none;';
            
            textClave.value = null;
            respuesta.html(data);
        },
        error: function (error) {
            LOADING.style = 'display: none;';
            textClave.value = null;
            respuesta.html(error);
        }
    });
});

/**esta parte sirve para inciar sesion en el sistema y enviar encriptado la clave del user*/
$('.FormCambioClave').submit(function (e) {
    const LOADING = document.querySelector('.loader');
    LOADING.style = 'display: flex;';
    e.preventDefault(); //no se envíe el submit todavía

//var textUsuario = $("#Usuario");
    var textClave = document.querySelector("#txtClaveActual");
    textClave.value = md5(textClave.value);
    
    var form = $(this);

    var accion = form.attr('action');
    var metodo = form.attr('method');
    var respuesta = form.children('.RespuestaAjax');

    var formdata = new FormData(this);

    $.ajax({
        type: metodo,
        url: accion,
        data: formdata ? formdata : form.serialize(),
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            LOADING.style = 'display: none;';
            textClave.value = null;
            respuesta.html(data);
        },
        error: function (error) {
            LOADING.style = 'display: none;';
            textClave.value = null;
            respuesta.html(error);
        }
    });
});


function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}

function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll("table tr");
    
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (var j = 0; j < cols.length; j++) 
            row.push(cols[j].innerText);
        
        csv.push(row.join(";"));        
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}



function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}



$(function(){
    $("#sampleTableXml11").colResizable({
                liveDrag:true, 
                gripInnerHtml:"<div class='grip'></div>", 
                draggingClass:"dragging", 
//            resizeMode:'fit'
//            resizeMode:'flex'
            resizeMode:'overflow'
    });
});

function crearTablaB(idTabla){
//    var tablq = $('#sampleTableXml').DataTable({
var tablq = $('#'+idTabla).DataTable({
        language: {
            zeroRecords: 'No existen registros',
        },
        info: false,
        searching:false,
        paginate:false,
        paging: false,
        //ordering: false,
        //colReorder: true
    });
    return tablq;
}
    
    //esta funcion sirve para reordenar las columnas a una posicion especifica, pero con la cantidad
    //exacta de columnas, entre todas esas columnas se debe reordenar
    
    function gg(){
        if(tablq){
    //        var tableXml = document.getElementById('sampleTableXml');
            //var leTab = tableXml.rows[0].cells.length;
            
            console.log("a order");
            //aqui toca guardar en un array la forma en que se ordena
            
            //for(let i=(leTab-1);i>=0;i--){ esta es para reverso
//            for(let i=0;i<leTab;i++){
//                columnx.push(i);
//            }
localStorage.removeItem("ordenColumna");
            if(localStorage.getItem("ordenColumna")){
                var columnx = localStorage.getItem("ordenColumna").split(",");
                console.log(localStorage.getItem("ordenColumna"));
                if(tablq.colReorder){
                    tablq.colReorder.order(columnx);
                }

                console.log("ya ordenoo");
            }
            //esta e spara mover entre dos columnas
            //tablq.colReorder.move(3,0);
            localStorage.removeItem("ordenColumna");
        }
    }
    gg();
    
    
    
    tablq.on('column-reorder', function (e, settings, details) {
//        var headerCell = $(tablq.column(details.to).header());
//console.log(details);
//console.log(settings);
//console.log(e);
        var columnx=[];
        if(localStorage.getItem("ordenColumna")){
            columnx = localStorage.getItem("ordenColumna").split(",");
        }
        if(columnx.length === 0){
            var tableXml = document.getElementById('sampleTableXml');
            var leTab = tableXml.rows[0].cells.length;
            for(let i=0;i<leTab;i++){
                columnx.push(i);
            }
            
        }
        console.log(columnx);
        var val1 = columnx[details.from];
        var val2 = columnx[details.to];
        console.log(val1);
        console.log(val2);
        columnx.splice(details.to, 1, val1);
        columnx.splice(details.from, 1, val2);
        console.log(columnx);
        localStorage.setItem("ordenColumna", columnx);
    
//        headerCell.addClass('reordered');
//        setTimeout(function () {
//            headerCell.removeClass('reordered');
//        }, 2000);
    });
    
    //esta funcion funciona en el momento en que se order por filas, no columnas
    tablq.on('draw', function () {
        console.log( 'Table redrawn' );
    } );
