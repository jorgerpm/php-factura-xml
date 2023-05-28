function ejecutarReportePdf(reporte, id) {
    const LOADING = document.querySelector('.loader');
    LOADING.style = 'display: flex;';
    
    $.ajax({
        type: 'POST',
        url: 'acciones/ejecutarReportes.php',
        data: {'reporte': reporte, 'id': id, 'tipo': 'pdf'},
        success: function (data) {
            LOADING.style = 'display: none;';          
//            console.log(data);
            
            //se recibe en el data = el archivo en base64
            var byteCharacters = atob(data);
            var byteNumbers = new Array(byteCharacters.length);
            for (var i = 0; i < byteCharacters.length; i++) {
              byteNumbers[i] = byteCharacters.charCodeAt(i);
            }
            var byteArray = new Uint8Array(byteNumbers);
            var file = new Blob([byteArray], { type: 'application/pdf;base64' });
            var fileURL = URL.createObjectURL(file);
            window.open(fileURL, '_blank', 'height=450,width=375,resizable=1');
            
        },
        error: function (error) {
            LOADING.style = 'display: none;';
            console.log(data);
        }
    });

}

function ejecutarReporteCsv(reporte, fechaIni, fechaFin) {

    console.log("fechaIni: ", fechaIni);
    console.log("fechaFin: ", fechaFin);

    const LOADING = document.querySelector('.loader');
    LOADING.style = 'display: flex;';
    
    $.ajax({
        type: 'POST',
        url: 'acciones/ejecutarReportes.php',
        data: {'reporte': reporte, 'fechaIni': fechaIni, 'fechaFin': fechaFin, 'tipo': 'xls'},
        success: function (data) {
            LOADING.style = 'display: none;';
//            console.log(data);
//            window.open(data, '_blank', 'height=450,width=375,resizable=1');

            //se recibe en el data = el archivo en base64
            var byteCharacters = atob(data);
            var byteNumbers = new Array(byteCharacters.length);
            for (var i = 0; i < byteCharacters.length; i++) {
              byteNumbers[i] = byteCharacters.charCodeAt(i);
            }
            var byteArray = new Uint8Array(byteNumbers);
            var file = new Blob([byteArray], { type: 'application/vnd.ms-excel;base64' });
            
            let link = document.createElement('a');
            link.download = reporte + '.xls';
            link.href = URL.createObjectURL(file); //aqui se pone el blob
            link.click();
            URL.revokeObjectURL(link.href);
            
        },
        error: function (error) {
            LOADING.style = 'display: none;';
            console.log(data);
        }
    });
}

