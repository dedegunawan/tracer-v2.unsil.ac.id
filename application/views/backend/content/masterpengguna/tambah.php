<?php $this->layout('main_template') ?>

<?php $this->start('bottom_css') ?>
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/datepicker/datepicker3.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2/select2.min.css');?>">
<link rel="stylesheet" href="<?php echo base_url('/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');?>">

<?php $this->stop() ?>


<?php $this->start('bottom_js') ?>
<script src="<?php echo base_url('assets/plugins/input-mask/jquery.inputmask.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/input-mask/jquery.inputmask.date.extensions.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/select2/select2.min.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js');?>"></script>
<script>
$('select').select2();
$('.date').datepicker({
  autoclose: true,
  format : 'yyyy-mm-dd'
});
//$(".tanggal_lahir").inputmask("yyyy/mm/dd", {"placeholder": "yyyy/mm/dd"});
$(".pilih-tempat-lahir").click(function(e) {
	//alert("HHHHH");
});
$(".submit-this-form").click(function(e) {
	e.preventDefault();
	$("form").has($(this)).submit();
});
$(".textarea").wysihtml5();
</script>
<?php $this->stop() ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= @$page_title;?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-"></i> <?php echo $conf->title;?></a></li>
        <li class="active">Master Pengguna</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12">
		<form class="" action="<?php echo base_url(@$ci->urlController()->tambah);?>" method="post" enctype="multipart/form-data">
          <!-- TO DO List -->
          <div class="box box-primary">
            <div class="box-header">


			</div>
            <!-- /.box-header -->
            <div class="box-body">
				<div class="row">
					<div class="col-md-12">
					  <?php echo @$message;?>
					</div>

				  </div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Nama Lembaga <sup style="color:red">*</sup></label>
							<input type="text" class="form-control" name="nama_lembaga"  value="<?php $nama_lembaga = FormRemindPostValue::nama_lembaga(); echo @$nama_lembaga;?>"/>
						</div>
					</div>
				</div>
                <div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Jabatan <sup style="color:red">*</sup></label>
							<input type="text" class="form-control" name="jabatan"  value="<?php $jabatan = FormRemindPostValue::jabatan();echo @$jabatan;?>"/>
						</div>
					</div>
				</div>
                <div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Email Lembaga <sup style="color:red">*</sup></label>
							<input type="text" class="form-control" name="email_lembaga"  value="<?php $email_lembaga = FormRemindPostValue::email_lembaga();echo @$email_lembaga;?>"/>
						</div>
					</div>
				</div>
                <div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Nama Alumni <sup style="color:red">*</sup></label>
							<input type="text" class="form-control" name="nama_alumni"  value="<?php $nama_alumni = FormRemindPostValue::nama_alumni();echo @$nama_alumni;?>"/>
						</div>
					</div>
				</div>
                <div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label>Tahun Angkatan Alumni <sup style="color:red">*</sup></label>
							<input type="text" class="form-control" name="tahun_angkatan"  value="<?php $tahun_angkatan = FormRemindPostValue::tahun_angkatan();echo @$tahun_angkatan;?>"/>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Tahun Lulus Alumni <sup style="color:red">*</sup></label>
							<input type="text" class="form-control" name="tahun_lulus"  value="<?php $tahun_lulus = FormRemindPostValue::tahun_lulus();echo @$tahun_lulus;?>"/>
						</div>
					</div>
				</div>
                <div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Jenis Kelamin <sup style="color:red">*</sup></label>
                            <select name="jenis_kelamin" class="form-control">
                                <?php
                                $default = FormRemindPostValue::jenis_kelamin();
                                $kelamins = array(
                                    'L' => 'Laki-laki',
                                    'P' => 'Perempuan',
                                );
                                foreach ($kelamins as $k => $kelamin) {
                                    echo "<option value='{$k}' ";
                                    if ($default == $k) {
                                        echo " selected='selected' ";
                                    }
                                    echo ">{$kelamin}</option>";
                                }
                                 ?>
                            </select>

						</div>
					</div>

				</div>
                <div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Prodi <sup style="color:red">*</sup></label>
                            <select name="prodi" class="form-control">
                                <?php
                                $default = FormRemindPostValue::prodi();
                                foreach ($prodis as $prodi) {
                                    echo "<option value='{$prodi->ProdiID}' ";
                                    $jenjang = $prodi->jenjang;
                                    if ($default == $prodi->ProdiID) {
                                        echo " selected='selected' ";
                                    }
                                    echo ">{$prodi->Nama} {$jenjang->Nama}</option>";
                                }
                                 ?>
                            </select>

						</div>
					</div>

				</div>
                <?php
                foreach ($pertanyaans as $key => $pertanyaan) {
                    ?>
                    <div class="row">
    					<div class="col-md-6">
    						<div class="form-group">
    							<label><?= "No.$key :  ".$pertanyaan['pertanyaan'];?> <?= (($pertanyaan['required']) ? "<sup style=\"color:red\">*</sup>" : "") ;?></label>
    							<?php
                                switch (true) {
                                    case $pertanyaan['pilihan'] == 'textarea':
                                        echo "<textarea name='pertanyaan{$key}' class='form-control'></textarea>";
                                        break;
                                    case is_array($pertanyaan['pilihan']):
                                        foreach ($pertanyaan['pilihan'] as $keyA => $valueB) {
                                            echo "<input type=\"radio\" name=\"pertanyaan{$key}\" value=\"$keyA\"> $valueB<br>";
                                        }
                                        break;

                                    default:
                                        # code...
                                        break;
                                }
                                 ?>
    						</div>
    					</div>
    				</div>
                    <?php
                }
                 ?>

			</div>
            <!-- /.box-body -->
            <div class="box-footer clearfix no-border">
			  <a type="button" class="btn btn-primary pull-right submit-this-form" href="#" style="margin:0px 10px"><i class="fa fa-save"></i> Simpan</a>
			  <a type="button" class="btn btn-default pull-right " href="<?php echo base_url($ci->urlController()->index);?>"  style="margin:0px 10px"><i class="ion-arrow-left-c"></i> Kembali</a>
            </div>
          </div>
          <!-- /.box -->

        </section>
		</form>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
