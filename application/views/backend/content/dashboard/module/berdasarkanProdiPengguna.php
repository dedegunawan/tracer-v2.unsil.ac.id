<?php
$ci->load->model('DataPenggunaTemp');
$ci->load->model('Prodi');
$ci->load->model('Jenjang');
$listProdi = DataPenggunaTemp::selectRaw('prodi,count(id) as jumlah')->groupBy('prodi')->get();
$jlm = array();
$listPr = Prodi::where('NA', 'N')->get();
foreach ($listProdi as $value) {
    $prodi = $listPr->where('ProdiID', (int)$value->prodi)->first();
    //var_dump($prodi);
    $jlm[] = array($prodi->Nama." (".$prodi->jenjang->Nama.")", (int)$value->jumlah);
}
?>
<div id="berdasarkanProdiPengguna" style="height: 400px"></div>
<script>
$(function () {
    Highcharts.chart('berdasarkanProdiPengguna', {
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'Rekap Pengguna Berdasarkan Prodi',
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
