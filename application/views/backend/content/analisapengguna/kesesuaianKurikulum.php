<div class="row">
    <div class="col-md-12 table-responsive">
        <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
              <th rowspan="2">No.</th>
              <th rowspan="2">Nama Alumni</th>
              <th colspan="3">Pertanyaan</th>
              <th rowspan="2">Jumlah</th>
            </tr>
            <tr>
              <th>1</th>
              <th>2</th>
              <th>3</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $start=0;
            $totalSatu = 0;
            $totalDua = 0;
            $totalTiga = 0;
            $totalTotal = 0;
            foreach($alumnis as $alumni) { $start++;?>
                <tr>

                <td><?=@$start;?></td>
                <td><?=@$alumni->nama_depan;?> <?=@$alumni->nama_belakang;?></td>
                <?php
                $abc = $allPilihan->where('alumni_temp_id', $alumni->id);
                $satu = @$abc->where('pertanyaan_id', 8)->first()->jawaban;
                $dua = @$abc->where('pertanyaan_id', 9)->first()->jawaban;
                $tiga = @$abc->where('pertanyaan_id', 10)->first()->jawaban;
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
