<?php
$ci->load->model('DataAlumniTemp');
$ci->load->model('Prodi');
$ci->load->model('Jenjang');
$listProdi = DataAlumniTemp::selectRaw('prodi,count(id) as jumlah')->groupBy('prodi')->get();
$jlm = array();
$listPr = Prodi::where('NA', 'N')->get();
foreach ($listProdi as $value) {
    $prodi = $listPr->where('ProdiID', (int)$value->prodi)->first();
    //var_dump($prodi);
    $jlm[] = array($prodi->Nama." (".$prodi->jenjang->Nama.")", (int)$value->jumlah);
}
?>
<div id="berdasarkanProdi" style="height: 400px"></div>
<script>
$(function () {
    Highcharts.chart('berdasarkanProdi', {
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'Rekap Alumni Berdasarkan Prodi',
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                },
                showInLegend: true
            }
        },

        series: [{
            type: 'pie',
            name: '',
            data: <?php echo json_encode($jlm);?>
        }]
    });
});
</script>
