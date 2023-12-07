<?php
if (is_file('./Utils/configUtil.php')) {
    require_once './Utils/configUtil.php';
} else {
    require_once '../Utils/configUtil.php';
}

if (isset($_SESSION['Usuario'])) {
    $regsPagina = 10000;

    $control = new documentoReembolsoControlador();

    $respuesta = $control->listar_documentos_controlador($_POST, $regsPagina);
    
    
    ?>
    
    <table>
        <thead>
            <tr>

                <th>Estado liq. compra</th>
                <th>N&uacute;mero liq. compra</th>
                <th>Estado Sistema</th>
                <th>N&uacute;mero reembolso</th>
                <th>Tipo reembolso</th>
                <th>Usuario carga</th>
                <th>Fecha de carga</th>
                <th>Número R.C.</th>
                <th>Aprobador</th>
                <th>Usuario aprueba/rechaza</th>
                <th>Fecha aprueba/rechaza</th>
                <th>Usuario procesa/rechaza</th>
                <th>Fecha procesa/rechaza</th>
                <th>Raz&oacute;n rechazo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($respuesta) > 0) {

                foreach ($respuesta as $docReembolso) {
                    ?>
                    <tr>
                        <td style="white-space: nowrap;"><?php echo $docReembolso->liquidacionCompra != null ? $docReembolso->liquidacionCompra->estado : ''; ?></td>
                        <td style="white-space: nowrap;"><?php echo $docReembolso->liquidacionCompra != null ? $docReembolso->liquidacionCompra->numero : ''; ?></td>

                        <td style="white-space: nowrap;"><?php echo $docReembolso->estado; ?></td>
                        <td style="white-space: nowrap;"><?php echo $docReembolso->numeroReembolso; ?></td>
                        <td style="white-space: nowrap;"><?php echo $docReembolso->tipoReembolsoNombre; ?></td>
                        <td style="white-space: nowrap;"><?php echo $docReembolso->usuario->nombre; ?></td>
                        <td style="white-space: nowrap;"><?php echo date("d/m/Y", $docReembolso->fechaCargaLong / 1000); ?></td>
                        <td style="white-space: nowrap;"><?php echo $docReembolso->numeroRC; ?></td>
                        <td style="white-space: nowrap;"><?php echo $docReembolso->aprobador; ?></td>
                        <td style="white-space: nowrap;"><?php echo $docReembolso->usuarioAutoriza; ?></td>
                        <td style="white-space: nowrap;"><?php echo $docReembolso->fechaAutorizaLong != null ? date("d/m/Y H:i:s", $docReembolso->fechaAutorizaLong / 1000) : ""; ?></td>
                        <td style="white-space: nowrap;"><?php echo $docReembolso->usuarioProcesa; ?></td>
                        <td style="white-space: nowrap;"><?php echo $docReembolso->fechaProcesaLong != null ? date("d/m/Y H:i:s", $docReembolso->fechaProcesaLong / 1000) : ""; ?></td>
                        <td style="white-space: nowrap;"><?php echo $docReembolso->razonRechazo; ?></td>


                    </tr>
                    <?php
                }
            } else {
                echo '<tr><td colspan="12">No existen registros.</td></tr>';
            }
            ?>
        </tbody>
    </table>
    
    <?php
}
else{
    header("Location: index");
    echo '<script>window.location.replace("index");</script>';
}

