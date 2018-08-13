<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<div class="row">
    <div class="col-md-12 table-responsive">
        <h4>Tingkat Penyerapan Pengguna Alumni</h4>
        <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
              <th>Tahun Angkatan</th>
              <th>Jumlah<br />Alumni</th>
              <th>Daya Serap <br />(<small>Orang</small>)</th>
              <th>Tingkat Penyerapan <br />%</th>
            </tr>

        </thead>
        <tbody>
            <?php
            $all_angkatan = $all_angkatan->sort();
            $jumYjum = 0;
            $jumYser = 0;

            $all_al[] = 0;
            $all_ds[] = 0;
            //var_dump($prodis);
            //var_dump($jumlahPengisi->all());
            foreach ($all_angkatan as $value) {
                $jumlah = $all_lulusan->where('Angkatan', (string) $value)->whereIn('ProdiID', $prodis)->pluck('jumlahLulusan')->sum();
                $jumP = $jumlahPengisi->where('tahun_angkatan', (string) $value);
                $jumP = $jumP->pluck('jumlah')->sum();
                $jumYjum += $jumlah;
                $jumYser += $jumP;


                $all_al[] = $jumlah;
                $all_ds[] = $jumP;
                ?>
                <tr>
                    <td><?=$value;?></td>
                    <td><?=$jumlah;?></td>
                    <td><?=$jumP;?></td>
                    <td><?=number_format(($jumP/$jumlah)*100, 2, ".", ",");?> %</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <th><?=$jumYjum;?></th>
                <th><?=$jumYser;?></th>
                <th><?=number_format(($jumYser/$jumYjum)*100, 2, ".", ",");?> %</th>
            </tr>
        </tfoot>
        </table>
        <hr />
    </div>
    <div class="col-md-12">
        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    </div>
    <script>
    $(function () {
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Grafik Serapan Alumni'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: <?php echo json_encode(array_values($all_angkatan->all()));?>,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah (orang)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.0f} orang</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [
                {
                name: 'Jumlah Alumni',
                data: <?php echo json_encode($all_al);?>

            },
            {
                name: 'Daya Serap',
                data: <?php echo json_encode($all_ds);?>

            }]
        });
    });
    </script>

</div>
