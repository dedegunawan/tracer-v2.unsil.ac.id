<?php
$ci->load->model('DataPenggunaTemp');
$listJenisKelamin = DataPenggunaTemp::selectRaw('jenis_kelamin,count(id) as jumlah')->groupBy('jenis_kelamin')->get();
$jlm = array();
foreach ($listJenisKelamin as $value) {
    $jlm[] = array($value->jenis_kelamin, (int)$value->jumlah);
}
?>
<div id="berdasarkanKelaminPengguna" style="height: 400px"></div>
<script>
$(function () {
    Highcharts.chart('berdasarkanKelaminPengguna', {
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'Rekap Pengguna Berdasarkan Jenis Kelamin',
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
