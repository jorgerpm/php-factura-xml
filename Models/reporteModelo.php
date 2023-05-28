<?php

class reporteModelo extends serviciosWebModelo {

    protected function ejecutar_reportepdf_modelo($reporte, $id) {
        $array = [];
        $reporteDto = self::invocarGet('reportes/generarReportePdf?reporte=' . $reporte . '&id=' . $id, $array);
        return $reporteDto;
    }

    protected function ejecutar_reportexls_modelo($reporte, $fechaIni, $fechaFin) {
        $array = [];
        $reporteDto = self::invocarGet('reportes/generarReporteXls?reporte=' . $reporte . "&fechaIni=".$fechaIni."&fechaFin=".$fechaFin, $array);
        return $reporteDto;
    }
    
    protected function ejecutar_reportefirma_modelo($reporte, $ids, $tiposGasto, $tipoReembolso, $idUsuario, $idAprobador, $listaAsistentes,
            
            $motivoViaje,
                $periodoViaje,
                $lugarViaje,
                $fondoEntregado,
                $observaciones,
                $seleccion
            
            
            ) {
        $array = [];
        $reporteDto = self::invocarGet('reportes/reporteFirma?reporte=' . $reporte . '&ids=' . $ids.'&idUsuario='.$idUsuario."&tiposGasto="
                .urlencode($tiposGasto)."&tipoReembolso=".$tipoReembolso."&idAprobador=".$idAprobador."&listaAsistentes=".urlencode($listaAsistentes)
                ."&motivoViaje=".urlencode($motivoViaje)
                ."&periodoViaje=".urlencode($periodoViaje)
                ."&lugarViaje=".urlencode($lugarViaje)
                ."&fondoEntregado=".$fondoEntregado
                ."&observaciones=".urlencode($observaciones)
                ."&seleccion=".urlencode($seleccion)
                , $array);
        return $reporteDto;
    }
}
