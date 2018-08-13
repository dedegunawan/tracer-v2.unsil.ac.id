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
        <li class="active">Master Pengguna</li>
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
				<form class="" action="<?php echo base_url(@$ci->urlController()->ajaximage."/".$pengguna->id);?>" method="post" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-12">
					  <?php echo @$message;?>
					</div>



					<div class="col-md-12">
					<h3 class="profile-username text-center">Data <?php echo $pengguna->nama_alumni;?> </h3>
					 <p class="text-muted text-center"></p>
					 <ul class="list-group list-group-unbordered">
						<li class="list-group-item">
						  <b>Nama Lembaga</b> <a class="pull-right"><?php echo @$pengguna->nama_lembaga;?> </a>
						</li>

						<li class="list-group-item">
						  <b>Jabatan </b> <a class="pull-right"><?php echo @$pengguna->jabatan;?> </a>
						</li>

						<li class="list-group-item">
						  <b>Email Lembaga</b> <a class="pull-right"><?php echo @$pengguna->email_lembaga;?> </a>
						</li>

						<li class="list-group-item">
						  <b>Nama Alumni</b> <a class="pull-right"><?php echo @$pengguna->nama_alumni;?> </a>
						</li>
						<li class="list-group-item">
						  <b>Tahun Angkatan</b> <a class="pull-right"><?php echo @$pengguna->tahun_angkatan;?> </a>
						</li>

						<li class="list-group-item">
						  <b>Tahun Lulus</b> <a class="pull-right"><?php echo @$pengguna->tahun_lulus;?> </a>
						</li>

						<li class="list-group-item">
						  <b>Program Studi</b> <a class="pull-right"><?php echo @$pengguna->prodiObject->Nama;?> </a>
						</li>
						<li class="list-group-item">
						  <b>Jenis Kelamin</b> <a class="pull-right"><?php echo (@$pengguna->jenis_kelamin == 'L'? 'Laki-laki' : 'Perempuan');?> </a>
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
					<h3 class="profile-username text-center">Jawaban <?php echo $pengguna->nama_alumni;?> </h3>
					 <p class="text-muted text-center"></p>
					 <ul class="list-group list-group-unbordered">
						<?php
						$jawaban_pengguna_temp = $pengguna->jawaban_pengguna_temp;
						//var_dump($pertanyaans);

						foreach ($pertanyaans as $keyA => $pertanyaan) {

							?>
							<li class="list-group-item" style="padding-bottom:20px">
							  <?=$pertanyaan['pertanyaan'];?> <a class="pull-right">
								  <?php
								  $js = $jawaban_pengguna_temp->where('pertanyaan_id', (string) $keyA)->first();
								  switch (true) {
								  	case $pertanyaan['pilihan'] == 'textarea':
								  		echo @$js->jawaban;
								  		break;
								  	case is_array($pertanyaan['pilihan']):
								  		echo @$pertanyaan['pilihan'][@$js->jawaban];

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
