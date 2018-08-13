<?php
$inputFileName = $fileName;

//  Read your Excel workbook
try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
} catch(Exception $e) {
    echo 'Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage();
    die();
}

//  Get worksheet dimensions
$sheet = $objPHPExcel->getSheet(0);
$highestRow = $sheet->getHighestRow();
$highestColumn = $sheet->getHighestColumn();

$session_data = array();

//  Loop through each row of the worksheet in turn
for ($row = 4; $row <= $highestRow; $row++){
    //  Read a row of data into an array
    $rowData = $sheet->rangeToArray('C' . $row . ':' . $highestColumn . $row,
                                NULL,
                                TRUE,
                                FALSE);
    $session_data[] = $rowData;
}

$_SESSION['session_data'] = $session_data;

?>
<?php $this->layout('main_template') ?>

<?php $this->start('bottom_css') ?>
<!--<link rel="stylesheet" href="<?php echo base_url('assets/plugins/datepicker/datepicker3.css');?>">-->
<?php $this->stop() ?>


<?php $this->start('bottom_js') ?>
<script src="<?php echo base_url('assets/plugins/input-mask/jquery.inputmask.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/input-mask/jquery.inputmask.date.extensions.js');?>"></script>
<script>
$(".tanggal_lahir").inputmask("yyyy/mm/dd", {"placeholder": "yyyy/mm/dd"});
$(".pilih-tempat-lahir").click(function(e) {
	//alert("HHHHH");
});
$(".submit-this-form").click(function(e) {
	e.preventDefault();
	$("form").has($(this)).submit();
})
$(".on-hover-change-image").hover(function(e) {
	e.preventDefault();
	$(this).css('opacity', '0.5');

}, function(e) {
	e.preventDefault();
	$(this).css('opacity', '1');
});
function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.on-hover-change-image').attr('src', e.target.result);
            $('.on-hover-change-image').css('width', '200px');
            $('.on-hover-change-image').css('height', '200px');
			$("#confirmation").removeClass('hide');
        }

        reader.readAsDataURL(input.files[0]);
    }
}
$(document).on('change', "#upload-image", function(e) {
	e.preventDefault();
	readURL(this);
});
$(document).on('change', "#confirmationPush", function(e) {
	e.preventDefault();
	$("form").has($(this)).submit();
});
</script>
<?php $this->stop() ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= @$page_title;?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-"></i> <?php echo $conf->title;?></a></li>
        <li class="active">Master Anak</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12">
          <!-- TO DO List -->
          <div class="box box-primary">
            <div class="box-header">


			</div>
            <!-- /.box-header -->
            <div class="box-body box-profile">
				<div class="row">
					<div class="col-md-12">
					  <?php echo @$message;?>
					</div>
					<div class="col-md-12">
    					  <table class="table table-hover table-bordered">
                              <thead>
                                  <tr>
                                      <th>
                                          No.
                                      </th>
                                      <th>
                                          Nama Alumni
                                      </th>
                                      <th>
                                          Angkatan (Lulus)
                                      </th>
                                      <th>
                                          Pekerjaan
                                      </th>
                                      <th>
                                          Kontak
                                      </th>
                                      <th>
                                          Prodi
                                      </th>
                                      <th>
                                          Jawaban
                                      </th>
                                      <th>
                                          Status
                                      </th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php
                                  $start=0;
                                  $pertanyaan = (new ButirPertanyaan)->alumni();
                                  $first_elements = array_map(function($i) {
                                      return $i[0];
                                  }, $session_data);

                                  foreach ($first_elements as $key => $alumni) {
                                      $start++;
                                      ?>
                                      <tr>
                                          <td class="middle center">
                                              <?=$start;?>
                                          </td>
                                          <td class="middle center">
                                              <?=$alumni[1];?> <?=$alumni[2];?>
                                          </td>
                                          <td class="middle center">
                                              <?=$alumni[4];?> (<?=$alumni[3];?>)
                                          </td>
                                          <td class="middle center">
                                              <?=$alumni[5];?><br />
                                              di<br />
                                              <?=$alumni[11];?>
                                          </td>
                                          <td class="middle center">
                                              <?=$alumni[7];?><br />
                                              <?=$alumni[8];?>
                                          </td>
                                          <td class="middle center">
                                              <?=$alumni[10];?>
                                              <?php
                                              echo "<br />Status " ;
                                              $prodi = Prodi::find($alumni[10]);
                                              if ($prodi) {
                                                  $validProdi = true;
                                                  echo "Valid";
                                              } else {
                                                  $validProdi = false;
                                                  echo "Tidak Valid";
                                              }

                                              ?>
                                          </td>
                                          <td class="middle center">
                                              <?php
                                              $nomor = 1;
                                              $valid = array();
                                              $validText = array();
                                              $validAll = true;
                                              for ($i=13; $i < count($alumni) ; $i++) {
                                                  $jawaban = $alumni[$i];
                                                  $pilihan = $pertanyaan[$nomor]['pilihan'];
                                                  if ($pilihan == 'textarea') {
                                                      $valid[$nomor] = true;
                                                      $validText[$nomor] = "Nomor $nomor Valid";
                                                  } else if(
                                                      is_array($pilihan)
                                                      &&
                                                      in_array($jawaban, array_keys($pilihan))
                                                  ) {

                                                      $valid[$nomor] = true;
                                                      $validText[$nomor] = "Nomor $nomor Valid";
                                                      # code...
                                                  } else {
                                                      $valid[$nomor] = false;
                                                      $validText[$nomor] = "Nomor $nomor Tidak Valid";
                                                  }
                                                  $validAll = $validAll && $valid[$nomor];
                                                  $nomor++;
                                              }
                                              echo "<ul>
                                              <li>
                                              ".implode("</li><li>", $validText)."
                                              </li>
                                              </ul>";

                                               ?>
                                          </td>
                                          <td>
                                              <?php
                                              if ($validAll && $validProdi) {
                                                  echo "Valid, akan di proses<br />Status Proses : ";
                                                  $st = $ci->_insertAlumni($alumni);
                                                  if ($st === true) {
                                                      echo "<strong class='text-success'>Berhasil</strong>";
                                                  } else {
                                                      echo "<strong class='text-danger'>Gagal, karena $st</strong>";
                                                  }

                                              } else {
                                                  echo "Tidak Valid, tidak diproses";
                                              }

                                               ?>
                                          </td>
                                      </tr>
                                      <?php
                                  }
                                   ?>

                              </tbody>
                          </table>
					</div>

				  </div>
			</div>
            <!-- /.box-body -->
            <div class="box-footer clearfix no-border">
			  <a type="button" class="btn btn-default pull-left " href="<?php echo base_url($ci->urlController()->index);?>"  style="margin:0px 10px"><i class="ion-arrow-left-c"></i> Kembali</a>
            </div>
          </div>
          <!-- /.box -->

        </section>
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
