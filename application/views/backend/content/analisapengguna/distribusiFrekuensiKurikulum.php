<?php
if (!isset($_REQUEST['abcd'])) {
    $_REQUEST['abcd'] = 1;
    ?>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <?php
}
else {
    $_REQUEST['abcd']++;
}
 ?>
 <div class="row">
    <div class="col-md-12 table-responsive">
        <h4>Pertanyaan Nomor <?=$soalNumber;?> : <?=@$pertanyaan['pertanyaan'];?></h4>
        <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
              <th>No.</th>
              <th>Pilihan</th>
              <th>Frekuensi</th>
              <th>(%)</th>
              <th>Valid (%)</th>
              <th>Kumulatif (%)</th>
            </tr>

        </thead>

        <tbody>
            <?php

            $keysValid = array_map('strval', array_keys($pertanyaan['pilihan']));
            $totalData = $allPilihan->count();
            $totalValid = $allPilihan->whereIn('jawaban', $keysValid)->count();

            $persenValid = ($totalValid/$totalData)*100;

            $start=0;
            $kumulatif=0;
            $totalFrekuensi=0;
            $totalFrekuensiPersen=0;
            $totalFrekuensiValidPersen=0;
            $dataXYZ = array();
            $txyZZZ = array();
            foreach($pertanyaan['pilihan'] as $key => $pr) { $start++;?>
                <tr>

                <td><?=@$start;?></td>
                <td><?=@$pr;?> </td>
                <?php
                $frekuensi = $allPilihan->where('jawaban', (string) $key)->count();
                $dataXYZ[] = array($pr, $frekuensi);
                if ($totalData) {
                    $frekuensiPersen = ($frekuensi/$totalData)*100;
                    $frekuensiValidPersen = ($frekuensi/$totalValid)*$persenValid;
                }
                else {
                    $frekuensiPersen = 0;
                    $frekuensiValidPersen = 0;
                }
                $kumulatif += $frekuensiPersen;
                $txyZZZ[] = (float) $kumulatif;
                $totalFrekuensi += $frekuensi;
                $totalFrekuensiPersen += $frekuensiPersen;
                $totalFrekuensiValidPersen += $frekuensiValidPersen;
                ?>
                <td><?=@$frekuensi;?> </td>
                <td><?=number_format($frekuensiPersen, 2, '.', ",");?> %</td>
                <td><?=number_format($frekuensiValidPersen, 2, '.', ",");?> % </td>
                <td><?=number_format($kumulatif, 2, '.', ",");?> % </td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">
                    Rata-rata
                </th>
                <td><?=@$totalFrekuensi;?> dari <?=@$totalData;?></td>
                <td><?=number_format(@$totalFrekuensiPersen, 2, '.', ",");?> %</td>
                <td><?=number_format(@$totalFrekuensiValidPersen, 2, '.', ",");?> %</td>
                <td><?=number_format(@$kumulatif, 2, '.', ",");?> %</td>

            </tr>
        </tfoot>
        </table>
        <hr />
    </div>
    <div class="col-md-6">
        <?php $loop_num = md5($_REQUEST['abcd']);?>
        <div id="aztec<?=$loop_num;?>" style="height: 300px;"></div>
    </div>
    <div class="col-md-6">
        <?php $loop_numY = md5($_REQUEST['abcd']."33333333333");?>
        <div id="aztec<?=$loop_numY;?>" style="height: 300px;"></div>
    </div>
    <script>
    $(function () {
        Highcharts.chart('aztec<?=$loop_num;?>', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45,
                    beta: 0
                }
            },
            title: {
                text: ' ',
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
                data: <?php echo json_encode($dataXYZ);?>
            }]
        });
    });

    $(function () {
        Highcharts.chart('aztec<?=$loop_numY;?>', {
            title: {
                text: '',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                categories: <?php echo json_encode(array_values($pertanyaan['pilihan']))?>,
            },
            yAxis: {
                title: {
                    text: 'Jumlah'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: '%'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                name: 'Jumlah Akumulatif',
                data: <?php echo json_encode($txyZZZ);?>
            }]
        });
    });

    </script>

</div>
