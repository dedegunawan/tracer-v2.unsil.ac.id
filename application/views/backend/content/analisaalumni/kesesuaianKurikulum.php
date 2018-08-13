<?php
if (!isset($_REQUEST['abcd'])) {
    $_REQUEST['abcd'] = 1;
    ?>

    <script src="https://code.highcharts.com/highcharts.js"></script>
 <script src="https://code.highcharts.com/modules/data.js"></script>
 <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <?php
}
else {
    $_REQUEST['abcd']++;
}
 ?>



<div class="row">
    <div class="col-md-12 table-responsive">
        <h3><?=ucwords('Kesesuaian kurikulum dengan kondisi lapangan kerja');?></h3>
        <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
              <th rowspan="2">No.</th>
              <th rowspan="2">Nama Alumni</th>
              <th colspan="3">Pertanyaan</th>
              <th rowspan="2">Jumlah</th>
            </tr>
            <tr>
              <th>1*</th>
              <th>2*</th>
              <th>3*</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $start=0;
            $totalSatu = 0;
            $totalDua = 0;
            $totalTiga = 0;
            $totalTotal = 0;
            $datazz = array();
            foreach($alumnis as $alumni) { $start++;?>
                <tr>

                <td><?=@$start;?></td>
                <td><?=@$alumni->nama_depan;?> <?=@$alumni->nama_belakang;?></td>
                <?php
                $abc = $allPilihan->where('alumni_temp_id', (string) $alumni->id);
                $satu = @$abc->where('pertanyaan_id', (string) 8)->first()->jawaban;
                $dua = @$abc->where('pertanyaan_id', (string) 9)->first()->jawaban;
                $tiga = @$abc->where('pertanyaan_id', (string) 10)->first()->jawaban;
                $satu = ((5-$satu) > 5 ? 5 : (5-$satu+1));
                $dua = ((5-$dua) > 5 ? 5 : (5-$dua+1));
                $tiga = ((5-$tiga) > 5 ? 5 : (5-$tiga+1));
                if ($satu == 6) {
                    $satu = 0;
                }
                if ($dua == 6) {
                    $dua = 0;
                }
                if ($tiga == 6) {
                    $tiga = 0;
                }
                $total = $satu+$dua+$tiga;

                $totalSatu += $satu;
                $totalDua += $dua;
                $totalTiga += $tiga;
                $totalTotal += $total;
                ?>
                <td><?=@$satu;?>
                <td><?=@$dua;?>
                <td><?=@$tiga;?>
                <td><?=@$total;?>
                </tr>
                <?php
                $datazz[1][] = array($alumni->nama_depan." ".$alumni->nama_belakang, $satu);
                $datazz[2][] = array($alumni->nama_depan." ".$alumni->nama_belakang, $dua);
                $datazz[3][] = array($alumni->nama_depan." ".$alumni->nama_belakang, $tiga);
                ?>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">
                    Rata-rata
                </th>
                <td><?=@$totalSatu/$start;?>
                <td><?=@$totalDua/$start;?>
                <td><?=@$totalTiga/$start;?>
                <td><?=@$totalTotal/$start;?>
                <?php
                $dataRes = array(
                    (object) array('name' => 'Rata-rata 1', 'y'=>@$totalSatu/$start, 'drilldown' => 'Detail 1'),
                    (object) array('name' => 'Rata-rata 2', 'y'=>@$totalDua/$start, 'drilldown' => 'Detail 2'),
                    (object) array('name' => 'Rata-rata 3', 'y'=>@$totalTiga/$start, 'drilldown' => 'Detail 3'),
                );
                $dataDrill = array(
                    (object) array('name' => 'Detail 1', 'data'=>$datazz[1], 'id' => 'Detail 1'),
                    (object) array('name' => 'Detail 2', 'data'=>$datazz[2], 'id' => 'Detail 2'),
                    (object) array('name' => 'Detail 3', 'data'=>$datazz[3], 'id' => 'Detail 3'),
                );
                ?>
            </tr>
        </tfoot>
        </table>
        <small>
            Ket Pertanyaan:<br />
            <?php
            $bt = new ButirPertanyaan;
            $pi = $bt->alumni();
            ?>
            <ol>
                <li>
                    <?=$pi['8']['pertanyaan'];?>
                </li>
                <li>
                    <?=$pi['9']['pertanyaan'];?>

                </li>
                <li>
                    <?=$pi['10']['pertanyaan'];?>

                </li>
            </ol>
        </small>
    </div>
    <div class="col-md-6 col-md-offset-3">
        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    </div>
    <script>
    $(function () {
        // Create the chart
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Kesesuaian kurikulum dengan kondisi lapangan kerja'
            },
            subtitle: {
                text: 'Klik kolom untuk melihat detail</a>.'
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Skala'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.1f}'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}<br/>'
            },

            series: [{
                name: 'Rata-rata',
                colorByPoint: true,
                data: <?php echo json_encode($dataRes);?>
            }],
            drilldown: {
                series: <?php echo json_encode($dataDrill);?>
            }
        });
    });
    </script>
</div>
