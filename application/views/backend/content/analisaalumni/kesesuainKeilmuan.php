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
        <h3><?=@$pertanyaan['pertanyaan'];?></h3>
        <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
              <th>No.</th>
              <th>Pilihan</th>
              <th>Jumlah</th>
              <th>Presentase</th>
            </tr>

        </thead>
        <tbody>
            <?php
            $start=0;
            $jml = $allPilihan->count();
            $data = array();
            foreach($pertanyaan['pilihan'] as $key => $pilihan) { $start++;?>
                <tr>

                <td><?=@$start;?></td>
                <td><?=@$pilihan;?> (<?=@$key;?>)</td>
                <td>
                    <?php $jmlY = $allPilihan->where('jawaban', (string) $key)->count();echo $jmlY;?>
                </td>
                <td>
                    <?= (($jmlY/$jml)*100)?> %
                </td>
                </tr>

            <?php
            $data[] = array(@$pilihan." (".@$key.") ", (int) $jmlY );
            } ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">
                    Total
                </th>
                <th>
                    <?=$jml;?>
                </th>
                <th>
                    100 %
                </th>
            </tr>
        </tfoot>
        </table>
    </div>
    <div class="col-md-6 col-md-offset-3">
        <div id="berdasarkanKelamin<?=md5($nomor."dedegunawan");?>" style="height: 300px;"></div>
    </div>

    <script>
    $(function () {
        Highcharts.chart('berdasarkanKelamin<?=md5($nomor."dedegunawan");?>', {
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
                data: <?php echo json_encode($data);?>
            }]
        });
    });
    </script>
</div>
