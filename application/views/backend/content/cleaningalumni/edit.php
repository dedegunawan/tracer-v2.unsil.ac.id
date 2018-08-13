<?php $this->layout('main_template') ?>

<?php $this->start('bottom_css') ?>
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/datepicker/datepicker3.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2/select2.min.css');?>">
<link rel="stylesheet" href="<?php echo base_url('/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">');?>">

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
        <li class="active">Master Anak</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12">
		<form class="" action="<?php echo base_url(@$ci->urlController()->edit."/".$anak->id);?>" method="post" enctype="multipart/form-data">
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
							<label>Nama Depan <sup style="color:red">*</sup></label>
							<input type="text" class="form-control" name="nama_depan"  value="<?php $nama_depan = FormRemindPostValue::nama_depan(); echo @$nama_depan ? $nama_depan : $anak->nama_depan;?>"/>
						</div>
					</div>
				</div><div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Nama Belakang <sup style="color:red">*</sup></label>
							<input type="text" class="form-control" name="nama_belakang"  value="<?php $nama_belakang = FormRemindPostValue::nama_belakang();echo @$nama_belakang ? $nama_belakang : $anak->nama_belakang;?>"/>
						</div>
					</div>
				</div><div class="row">
					<div class="col-md-3">
						<?php
						/*
						<div class="form-group pilih-tempat-lahir">
							<label>Tempat Lahir</label>
							<div class="input-group">
								  <div class="input-group-addon">
									<i class="fa fa-search"></i>
								  </div>
							<input type="text" class="form-control disabled" name="tempat_lahir"  value="<?php echo FormRemindPostValue::tempat_lahir();?>" disabled/>
							</div>
							<input type="hidden" class="" name="tempat_lahir_kode"  value="<?php echo FormRemindPostValue::tempat_lahir_kode();?>" />
						</div>
						*/

						?>
						<div class="form-group pilih-tempat-lahir">
							<label>Tempat Lahir <sup style="color:red">*</sup></label>

							<input type="text" class="form-control" name="tempat_lahir"  value="<?php $tempat_lahir = FormRemindPostValue::tempat_lahir();echo @$tempat_lahir ? $tempat_lahir : $anak->tempat_lahir;?>" />
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Tanggal Lahir <sup style="color:red">*</sup></label>
							<div class="input-group date">
								<input type="text" class="form-control tanggal_lahir" name="tanggal_lahir"  value="<?php $tanggal_lahir= FormRemindPostValue::tanggal_lahir();echo @$tanggal_lahir ? $tanggal_lahir : $anak->tanggal_lahir ?>"/>
								<span class="input-group-addon"><i class="fa fa-th"></i></span>
							</div>

						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<div class="form-group">
							<label>Jenis Kelamin <sup style="color:red">*</sup></label>
							<select name="jenis_kelamin_id" class="form-control">
							<?php
							echo "<option value=''>--Pilih--</option>";
							$selected = FormRemindPostValue::jenis_kelamin_id();
							if(!$selected) {
								$selected = $anak->jenis_kelamin_id;

							}
							foreach($jenis_kelamin as $pkr) {
								echo "<option value='{$pkr->id}' ".($pkr->id == $selected ? " selected='selected' " : "").">{$pkr->nama}</option>";
							}
							?>
							</select>

						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Keturunan <sup style="color:red">*</sup></label>
							<select name="suku_id" class="form-control">
							<?php
							echo "<option value=''>--Pilih--</option>";
							$selected = FormRemindPostValue::suku_id();
							if(!$selected) {
								$selected = $anak->suku_id;

							}
							foreach($suku as $pkr) {
								echo "<option value='{$pkr->id}' ".($pkr->id == $selected ? " selected='selected' " : "").">{$pkr->nama}</option>";
							}
							?>
							</select>

						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<div class="form-group">
							<label>Berat Badan</label>
							<div class="input-group">
								<input type="text" class="form-control" name="berat_badan"  value="<?php $berat_badan = FormRemindPostValue::berat_badan(); echo @$berat_badan ? $berat_badan : $anak->berat_badan;?>"/>
								  <div class="input-group-addon">
									Kg
								  </div>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label>Tinggi Badan</label>
							<div class="input-group">
								<input type="text" class="form-control" name="tinggi_badan"  value="<?php $tinggi_badan =FormRemindPostValue::tinggi_badan();echo @$tinggi_badan ? $tinggi_badan : $anak->tinggi_badan;?>"/>
								<div class="input-group-addon">
									cm
								  </div>
							</div>
						</div>
					</div>
					<div class="col-md-12"><hr/></div>
				</div>
            	<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Nama Ayah <sup style="color:red">*</sup></label>
							<input type="text" class="form-control" name="nama_ayah"  value="<?php $nama_ayah = FormRemindPostValue::nama_ayah();echo @$nama_ayah ? $nama_ayah : $anak->nama_ayah;?>"/>

						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Pekerjaan Ayah <sup style="color:red">*</sup></label>
							<select name="pekerjaan_ayah" class="form-control">
							<?php
							$selected = FormRemindPostValue::pekerjaan_ayah();
							if(!$selected) {
								$selected = $anak->pekerjaan_ayah;

							}
							echo "<option value=''>--Pilih--</option>";
							foreach($pekerjaan as $pkr) {
								echo "<option value='{$pkr->id}' ".($pkr->id == $selected ? " selected " : "").">{$pkr->nama}</option>";
							}
							?>
							</select>

						</div>
					</div>
				</div><div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Nama Ibu <sup style="color:red">*</sup></label>
							<input type="text" class="form-control" name="nama_ibu"  value="<?php $nama_ibu = FormRemindPostValue::nama_ibu();echo @$nama_ibu ? $nama_ibu : $anak->nama_ibu;?>"/>

						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<label>Pekerjaan Ibu <sup style="color:red">*</sup></label>
							<select name="pekerjaan_ibu" class="form-control">
							<?php
							echo "<option value=''>--Pilih--</option>";
							$selected = FormRemindPostValue::pekerjaan_ibu();
							if(!$selected) {
								$selected = $anak->pekerjaan_ibu;

							}
							foreach($pekerjaan as $pkr) {
								echo "<option value='{$pkr->id}' ".($pkr->id == $selected ? " selected='selected' " : "").">{$pkr->nama}</option>";
							}
							?>
							</select>

						</div>
					</div>
				</div><div class="row">
					<div class="col-md-8">
						<div class="form-group">
							<label>Alamat Ayah <sup style="color:red">*</sup></label>
							<input type="text" class="form-control" name="alamat_ayah"  value="<?php $alamat_ayah = FormRemindPostValue::alamat_ayah(); echo @$alamat_ayah ? $alamat_ayah : $anak->alamat_ayah?>"/>

						</div>
					</div>
				</div>
				<div class="row">

					<div class="col-md-4">
						<div class="form-group">
							<label>Kontak Orang Tua <sup style="color:red">*</sup></label>
							<input type="text" class="form-control" name="kontak_orang_tua"  value="<?php $kontak_orang_tua= FormRemindPostValue::kontak_orang_tua(); echo @$kontak_orang_tua ? $kontak_orang_tua : $anak->kontak_orang_tua;?>"/>

						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label>Kontak Orang Tua <sup style="color:red">*</sup></label>
							<textarea class="textarea" name="deskripsi_anak" placeholder="Deskripsi Anak" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php $deskripsi_anak= FormRemindPostValue::deskripsi_anak(); echo @$deskripsi_anak ? $deskripsi_anak : $anak->deskripsi_anak;?></textarea>

						</div>
					</div>
				</div>
				<?php
				/*
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label>Penghasilan Ayah</label>
							<input type="text" class="form-control" name="penghasilan_ayah"  value="<?php $penghasilan_ayah = FormRemindPostValue::penghasilan_ayah(); echo @$penghasilan_ayah ? $penghasilan_ayah : $anak->penghasilan_ayah?>"/>

						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Penghasilan Ibu</label>
							<input type="text" class="form-control" name="penghasilan_ibu"  value="<?php $penghasilan_ibu = FormRemindPostValue::penghasilan_ibu(); echo @$penghasilan_ibu ? $penghasilan_ibu : $anak->penghasilan_ibu?>"/>

						</div>
					</div>
					<div class="col-md-12"><hr/></div>
				</div>
				*/
				?>
			</div>
            <!-- /.box-body -->
            <div class="box-footer clearfix no-border">
			  <a type="button" class="btn btn-primary pull-right submit-this-form" href="#" style="margin:0px 10px"><i class="fa fa-save"></i> Perbaharui</a>
			  <a type="button" class="btn btn-default pull-right " href="<?php echo base_url($ci->urlController()->list);?>"  style="margin:0px 10px"><i class="ion-arrow-left-c"></i> Kembali</a>
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
