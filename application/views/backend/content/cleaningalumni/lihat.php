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
        <section class="col-lg-5">
          <!-- TO DO List -->
          <div class="box box-primary">
            <div class="box-header">


			</div>
            <!-- /.box-header -->
            <div class="box-body box-profile">
				<form class="" action="<?php echo base_url(@$ci->urlController()->ajaximage."/".$alumni->id);?>" method="post" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-12">
					  <?php echo @$message;?>
					</div>



					<div class="col-md-12">
					<h3 class="profile-username text-center">Data <?php echo $alumni->nama_depan." ".$alumni->nama_belakang?> </h3>
					 <p class="text-muted text-center"></p>
					 <ul class="list-group list-group-unbordered">
						<li class="list-group-item">
						  <b>Prodi</b> <a class="pull-right"><?php echo @$alumni->prodiObject->Nama;?> </a>
						</li>

						<li class="list-group-item">
						  <b>Tahun Lulus</b> <a class="pull-right"><?php echo @$alumni->tahun_lulus;?> </a>
						</li>

						<li class="list-group-item">
						  <b>Tahun Angkatan</b> <a class="pull-right"><?php echo @$alumni->tahun_angkatan;?> </a>
						</li>

						<li class="list-group-item">
						  <b>Pekerjaan</b> <a class="pull-right"><?php echo @$alumni->pekerjaan;?> </a>
						</li>
						<li class="list-group-item">
						  <b>Tempat Bekerja</b> <a class="pull-right"><?php echo @$alumni->tempat_bekerja;?> </a>
						</li>

						<li class="list-group-item">
						  <b>Alamat</b> <a class="pull-right"><?php echo @$alumni->alamat;?> </a>
						</li>
						<li class="list-group-item">
						  <b>Email</b> <a class="pull-right"><?php echo @$alumni->email;?> </a>
						</li>
						<li class="list-group-item">
						  <b>Telp/HP</b> <a class="pull-right"><?php echo @$alumni->telp_hp;?> </a>
						</li>
						<li class="list-group-item">
						  <b>Kontak Lainnya</b> <a class="pull-right"><?php echo @$alumni->kontak_lainnya;?> </a>
						</li>

					  </ul>

					</div>

				  </div>
				</form>
			</div>
            <!-- /.box-body -->
            <div class="box-footer clearfix no-border">
			  <a type="button" class="btn btn-default pull-left " href="<?php echo base_url($ci->urlController()->index);?>"  style="margin:0px 10px"><i class="ion-arrow-left-c"></i> Kembali</a>
            </div>
          </div>
          <!-- /.box -->

        </section>
        <section class="col-lg-7">
          <!-- TO DO List -->
          <div class="box box-primary">
            <div class="box-header">


			</div>
            <!-- /.box-header -->
            <div class="box-body box-profile">
				<div class="row">

					<div class="col-md-12">
					<h3 class="profile-username text-center">Jawaban <?php echo $alumni->nama_depan." ".$alumni->nama_belakang?> </h3>
					 <p class="text-muted text-center"></p>
					 <ul class="list-group list-group-unbordered">
						<?php
						$jawaban_alumni_temp = $alumni->jawaban_alumni_temp;
						//var_dump($jawaban_alumni_temp->count());
						foreach ($pertanyaans as $keyA => $pertanyaan) {
							?>
							<li class="list-group-item" style="padding-bottom:20px">
							  <?=$pertanyaan['pertanyaan'];?> <a class="pull-right">
								  <?php
								  $js = $jawaban_alumni_temp->where('pertanyaan_id', $keyA)->first();
								  switch (true) {
								  	case $pertanyaan['pilihan'] == 'textarea':
								  		echo $js->jawaban;
								  		break;
								  	case is_array($pertanyaan['pilihan']):
								  		echo $pertanyaan['pilihan'][@$js->jawaban];

								  		break;

								  	default:

								  		break;
								  }
								  ?>
							  </a>
							</li>
							<?php
						} ?>


					  </ul>

					</div>

				  </div>

			</div>
            <!-- /.box-body -->
            <div class="box-footer clearfix no-border">
            </div>
          </div>
          <!-- /.box -->

        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
