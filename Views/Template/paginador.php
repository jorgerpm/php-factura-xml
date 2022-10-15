<?php
$paginas = 0;
if(isset($respuesta[0]->totalRegistros)){
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
        echo '<label style="position: absolute;">No existen registros.</label>';
    }
    else{
        echo '<label style="position: absolute;">Mostrando página '.$activo.' de '.$paginas.'</label>';
    }
    ?>
    <nav aria-label="...">
        <ul class="pagination justify-content-end">
            <li class="page-item <?php echo $activo == 1 ? 'disabled' : ''; ?>">
                <button type="button" class="page-link" onclick="paginar(<?php echo ($activo-1) . ',' . $regsPagina ?>)" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </button>
            </li>
            
            <?php
            for ($ind = 1; $ind <= $paginas; $ind++) {
                if ($ind == $activo) {
                    echo '<li class="page-item active" aria-current="page"><button type="button" class="page-link" onclick="paginar(' . $ind . ',' . $regsPagina . ')">' . $ind . '</button></li>';
                } else {
                    echo '<li class="page-item"><button type="button" class="page-link" onclick="paginar(' . $ind . ',' . $regsPagina . ')">' . $ind . '</button></li>';
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
    }
</script>