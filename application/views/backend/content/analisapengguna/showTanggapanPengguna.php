<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>

<div class="row">
    <div class="col-md-12 table-responsive">
        <table id="example1" class="table table-bordered table-striped">
        <thead>
            <?php $jum = count($pertanyaan);?>
            <tr>
              <th rowspan="2">Nama &amp; Lembaga</th>
              <th colspan="<?=$jum;?>">Pertanyaan</th>
              <th rowspan="2">Jumlah</th>
            </tr>
            <tr>
                <?php
                $keyPilihan = array_keys($pertanyaan);
                foreach ($keyPilihan as $kp) {
                    echo "<th>
                    $kp*
                    </th>";
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $start=0;

            $data = array();

            $jumY = 0;
            $jumTot = array();
            $datazz = array();
            foreach ($penggunas as $pengguna) {
                ?>
                <tr>
                    <td><?=$pengguna->nama_alumni;?><br /> (<?=$pengguna->nama_lembaga;?>)</td>
                    <?php
                    $jawabans = $pengguna->jawaban_pengguna_temp;
                    $jumX = 0;
                    foreach ($keyPilihan as $kp) {
                        $kcp = $jawabans->where('pertanyaan_id', (string) $kp)->first();
                        $ksp = (integer) (4-$kcp->jawaban+1);
                        $jumX += $ksp;
                        $jumY += $ksp;
                        $jumTot[$kp] = (isset($jumTot[$kp])) ? ($jumTot[$kp]+$ksp) : $ksp ;

                        $datazz[$kp][] = array($pengguna->nama_alumni, $ksp);
                        echo "<td>
                        $ksp
                        </td>";
                    }
                    echo "<td>
                    $jumX
                    </td>";
                     ?>
                </tr>
                <?php

            }

            ?>
        </tbody>
        <tfoot>
            <tr>
                <th>
                    Rata-rata
                </th>
                <?php
                $dataRes = array();
                $dataDrill = array();
                $count_pengguna = $penggunas->count();
                foreach ($keyPilihan as $kp) {
                    $jumTotX = $jumTot[$kp]/$count_pengguna;
                    echo "<th>
                    ".number_format($jumTotX, 2, '.', '')."
                    </th>";
                    $dataRes[] = (object) array(
                        'name' => 'Rata-rata '.$kp, 'y'=>@$jumTotX, 'drilldown' => 'Detail '.$kp
                    );
                    $dataDrill[] = (object) array(
                        'name' => 'Detail '.$kp, 'data'=>$datazz[$kp], 'id' => 'Detail '.$kp
                    );
                }
                ?>
                <th>
                    <?=number_format($jumY/$count_pengguna, 2, '.', '');?>
                </th>
            </tr>
        </tfoot>
        </table>
        <small>
            Ket Pertanyaan :<br />
            <?php
            foreach ($pertanyaan as $kunci => $jawaban) {
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$kunci. {$jawaban['pertanyaan']}<br />";
            }
            ?>
        </small>
    </div>

    <div class="col-md-6 col-md-offset-3">
        <br />
        <br />
        <br />
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
                text: 'Hasil dalam grafik'
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
