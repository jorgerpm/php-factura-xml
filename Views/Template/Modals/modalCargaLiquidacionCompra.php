<div class="modal fade" id="modalCargaLiquidacionCompra" tabindex="1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Cargar liquidaci&oacute;n compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formCargaLiquidacionCompra" class="login-form" action="acciones/cargarLiquidacionCompra.php" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
                    
                    <input id="idReembLQ" name="idReembLQ" type="hidden">
                    <input id="numeroReembolsoLC" name="numeroReembolsoLC" type="hidden">
                    
                    <div class="form-group row">
                        <div class="col-md-11">
                            <label class="control-label">Número liquidación de compra:</label>
                            <input class="form-control" id="numeroLC" name="numeroLC" type="number" required="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-11">
                            <label class="control-label">Seleccione archivo:</label>
                            
                            <input type="file" id="txtArchivoLQ" name="txtArchivoLQ" class="form-control" required="" accept=".pdf">
                            
                        </div>
                    </div>
                    
                    
                    <div class="tile-footer" style="text-align: end;">
                        <button class="btn btn-primary" type="submit" >
                            <i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Cargar archivo</span>
                        </button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                    </div>
                    
                    <div class="RespuestaAjax"></div>
                    
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    
$('#formCargaLiquidacionCompra').submit(function (e) {
    const LOADING = document.querySelector('.loader');
    LOADING.style = 'display: flex;';
    
    e.preventDefault(); //no se envíe el submit todavía
console.log("cargadndododooo");
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
                
            //if(!data.includes("window.location.href"))
            $('#modalCargaLiquidacionCompra').modal('hide');
            
            respuesta.html(data);
        },
        error: function (error) {
            LOADING.style = 'display: none;';
            
            respuesta.html(error);
        }
    });
});
</script>