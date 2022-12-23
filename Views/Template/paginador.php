<?php
$paginas = 0;
$totalRegs = 0;
if(isset($respuesta[0]->totalRegistros)){
    $totalRegs = $respuesta[0]->totalRegistros;
    $paginas = $respuesta[0]->totalRegistros / $regsPagina; //el 3 es el numero de registros a mostrar por pagina
}

$paginas = ceil($paginas);
$activo = 1;
if (isset($_POST['txtActivo'])) {
    $activo = $_POST['txtActivo'];
}
?>
<br>
<section>
    <?php 
    if($paginas == 0){
        //echo '<label style="position: absolute;">No existen registros.</label>';
    }
    else{
        //echo '<label style="position: absolute;">Mostrando página '.$activo.' de '.$paginas.'</label>';
    }
    ?>
    
    <!-- aqui poner las filas a mostrar -->
    <div class="row" style="position: absolute;">
        <!--div class="col-3 col-sm-3 col-md-3" style="padding-left: 8px">
            <label>Mostrar </label>
        </div -->
        <div class="col-4 col-sm-4 col-md-4" style="padding: 0px">
            <select name="cmbRegsPagina" id="cmbRegsPagina" aria-controls="sampleTable" class="form-control form-control-sm" onchange="cambiarRegsPagina(this)">
                <!-- option value="5" <php echo $regsPagina==5 ? 'selected':'' ?>>5</option -->
                <option value="10" <?php echo $regsPagina==10 ? 'selected':'' ?>>10</option>
                <option value="25" <?php echo $regsPagina==25 ? 'selected':'' ?>>25</option>
                <option value="50" <?php echo $regsPagina==50 ? 'selected':'' ?>>50</option>
                <option value="100" <?php echo $regsPagina==100 ? 'selected':'' ?>>100</option>
            </select>
        </div>
        <div class="col-8 col-sm-8 col-md-8" style="padding: 0px">
            <label>registros por página</label>
        </div>
        
    </div>
    
    <nav aria-label="...">
        <ul class="pagination justify-content-end">
            
            <?php 
            if($paginas == 0){
                echo '<li><label >No existen registros. </label></li>';
            }
            else{
                if($regsPagina <= $totalRegs){
                    echo '<li><label >Mostrando '.$regsPagina.' de '.$totalRegs.'&nbsp;&nbsp;</label></li>';
                }
                else{
                    echo '<li><label >Mostrando '.$totalRegs.' de '.$totalRegs.'&nbsp;&nbsp;</label></li>';
                }
            }
            ?>
            
            <li class="page-item <?php echo $activo == 1 ? 'disabled' : ''; ?>">
                <button type="button" class="page-link" onclick="paginar(<?php echo ($activo-1) . ',' . $regsPagina ?>)" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </button>
            </li>
            
            <?php
            $puntos = false;
            for ($ind = 1; $ind <= $paginas; $ind++) {
                if($paginas > 7){
                    if($ind == 1 || $ind == $paginas){
                        if ($ind == $activo) {
                            echo '<li class="page-item active" aria-current="page"><button type="button" class="page-link" onclick="paginar(' . $ind . ',' . $regsPagina . ')">' . $ind . '</button></li>';
                        } else {
                            echo '<li class="page-item"><button type="button" class="page-link" onclick="paginar(' . $ind . ',' . $regsPagina . ')">' . $ind . '</button></li>';
                        }
                    }
                    else{
                        
                        if($ind >= ($activo-2) && $ind <= ($activo+2)){
                            if ($ind == $activo) {
                                echo '<li class="page-item active" aria-current="page"><button type="button" class="page-link" onclick="paginar(' . $ind . ',' . $regsPagina . ')">' . $ind . '</button></li>';
                            } else {
                                echo '<li class="page-item"><button type="button" class="page-link" onclick="paginar(' . $ind . ',' . $regsPagina . ')">' . $ind . '</button></li>';
                            }
                        }
                        else{
                            if($ind == ($paginas-1) || $ind == 2){
                                echo '<li class="page-item"><button type="button" class="page-link" >...</button></li>';
                            }
                            else{//este else es para mostrar el boton de la mitad de las paginas
                                if($activo == 1 || $activo == $paginas){
                                    $mitad =intval($paginas/2);
                                    if($ind == ($mitad-1) && $activo < $mitad){
                                        echo '<li class="page-item"><button type="button" class="page-link" >...</button></li>';
                                    }elseif($ind == ($mitad+1)  && $activo > $mitad){
                                        echo '<li class="page-item"><button type="button" class="page-link" >...</button></li>';
                                    }else{
                                        if($ind == $mitad){
                                            if ($ind == $activo) {
                                                echo '<li class="page-item active" aria-current="page"><button type="button" class="page-link" onclick="paginar(' . $ind . ',' . $regsPagina . ')">' . $ind . '</button></li>';
                                            } else {
                                                echo '<li class="page-item"><button type="button" class="page-link" onclick="paginar(' . $ind . ',' . $regsPagina . ')">' . $ind . '</button></li>';
                                            }
                                        }
                                    }
                                }
                            }//hasta acas boton del medio
                        }
                        
                    }
                }
                else{
                    if ($ind == $activo) {
                        echo '<li class="page-item active" aria-current="page"><button type="button" class="page-link" onclick="paginar(' . $ind . ',' . $regsPagina . ')">' . $ind . '</button></li>';
                    } else {
                        echo '<li class="page-item"><button type="button" class="page-link" onclick="paginar(' . $ind . ',' . $regsPagina . ')">' . $ind . '</button></li>';
                    }
                }
            }
            ?>

            <li class="page-item <?php echo $activo == $paginas ? 'disabled' : ''; ?>">
                <button type="button" class="page-link" onclick="paginar(<?php echo ($activo+1) . ',' . $regsPagina ?>)" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </button>
            </li>
        </ul>
    </nav>
</section>
<?php echo '<input type="hidden" id="txtDesde" name="txtDesde" value="0">'; ?>
<?php /* echo '<input type="text" id="txtHasta" name="txtHasta" value="'.$regsPagina.'">'; */ ?>
<?php echo '<input type="hidden" id="txtActivo" name="txtActivo" value="1">'; ?>
<?php echo '<input type="hidden" id="txtRegsPagina" name="txtRegsPagina" value="'.$regsPagina.'">'; ?>


<script type="text/javascript">
    function paginar(pagina, regsPagina) {

        var desde = ((regsPagina * pagina) - regsPagina);
//    var hasta = ((regsPagina*pagina)-1);//se resta 1 porque el inicio va desde cero

        var textDesde = document.querySelector("#txtDesde");
        textDesde.value = desde;

//    var textHasta = document.querySelector("#txtHasta");
//    textHasta.value = hasta;

        var activo = document.querySelector("#txtActivo"); //este para saber que pagina esta activa
        activo.value = pagina;

        var botonBuscar = document.querySelector("#btnSearch");
        botonBuscar.click();

    }
    
    function cambiarRegsPagina(cmb){
        //alert(cmb.value);
        var regsPagina = document.querySelector("#txtRegsPagina"); //este para saber que pagina esta activa
        regsPagina.value = cmb.value;
        
        var botonBuscar = document.querySelector("#btnSearch");
        botonBuscar.click();
        
    }
</script>