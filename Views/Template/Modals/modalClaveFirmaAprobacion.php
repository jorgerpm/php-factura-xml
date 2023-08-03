<div class="modal fade" id="modalClaveFirmaAprobacion" tabindex="1" role="dialog" aria-hidden="true" style="background-color: rgba(0,0,0,0.8);">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Clave firma electr&oacute;nica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formClaveFirmaAprobacion" class="login-form" action="" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
                    
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="control-label">Clave:</label>
                            <input class="form-control" id="txtClaveFirma" name="txtClaveFirma" type="password" required="">
                        </div>
                    </div>
                    
                    
                    <div class="tile-footer" style="text-align: end;">
                        <button id="btnActionForm" class="btn btn-primary" type="button" onclick="firmarGuardar()">
                            <i class="fa fa-fw fa-lg
                               fa-check-circle"></i><span id="btnText">Firmar</span>
                        </button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="#" data-dismiss="modal" onclick="document.getElementById('txtClaveFirma').value='';">
                            <i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>