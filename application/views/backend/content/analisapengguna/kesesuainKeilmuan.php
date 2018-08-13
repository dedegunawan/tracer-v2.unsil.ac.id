<div class="row">
    <div class="col-md-12 table-responsive">
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
            $data[] = (object) array(
                'label' => @$pilihan." (".@$key.") ",
                'data' => (int) $jmlY
            );
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
        <div id="myChart" style="height: 300px;"></div>
    </div>
    <script src="<?php echo base_url('assets/plugins/flot/jquery.flot.min.js');?>"></script>
    <script src="<?php echo base_url('assets/plugins/flot/jquery.flot.pie.min.js');?>"></script>
    <script>
    function labelFormatter(label, series) {
        return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
            + label
            + "<br>"
            + Math.round(series.percent) + "%</div>";
      }
      //console.log();
    var donutData = <?=json_encode($data);?>;
    $.plot("#myChart", donutData, {
      series: {
        pie: {
          show: true,
          radius: 1,
          innerRadius: 0.5,
          label: {
            show: true,
            radius: 2 / 3,
            formatter: labelFormatter,
            threshold: 0.1
          }

        }
      },
      legend: {
        show: true
      }
    });
    </script>
</div>
