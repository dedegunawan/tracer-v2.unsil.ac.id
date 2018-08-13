<?php $this->layout('main_template') ?>
<?php $this->start('bottom_css') ?>
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.css');?>">
<?php $this->stop() ?>
<?php $this->start('bottom_js') ?>
<script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.min.js');?>"></script>
<script>
$("#example1").DataTable();
$(".notificationOnHapus").click(function(e) {
	e.preventDefault();
	var cfm = confirm("Apakah Anda yakin, akan menghapus data ini ?");
	if(cfm) {
		window.location.href=$(this).attr('href');
	}
});
</script>
<?php $this->stop() ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
		  Analisa Alumni
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-"></i> <?php echo $conf->title;?></a></li>
        <li class="active">Analisa Alumni</li>
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

            <!-- /.box-header -->
            <div class="box-body">

				<div class="row ">
					<div class="col-md-12">
					  <?php echo @$message;?>
					</div>

				</div>

                <?php
                $menu = $ci->uri->segment(3);
                $this->insert('content/analisaalumni/formViewPartial', ['selected' => $menu]);
                switch (true) {
                    case $menu == 'p1':
						$al = new DataAlumniTemp;
						$uri = $ci->uri->segment(4);
						if (@$uri) {
							$al = $al->where('prodi', $uri);
						}

                        $this->insert('content/analisaalumni/databaseAlumniPartial', [
                            'alumnis' => $al->get(),
                        ]);
                        break;
                    case $menu == 'p2':
						$bt = new ButirPertanyaan;
						$dz = $bt->alumni();
						array_pop($dz);
						array_push($dz, array('pertanyaan' => 'Tampilkan Semua'));
						$key_dz = array_keys($dz);
						$ci->showPilihanPertanyaan($dz);
						$default = $ci->uri->segment(4);
						$tampilkan_semua = array_pop($key_dz);
						if ($default == $tampilkan_semua) {
							foreach ($key_dz as $value) {
								$ci->showGeneralResultAlumni($value);
							}
						}
						else if ($default && in_array($default, $key_dz)) {
							$ci->showGeneralResultAlumni($default);
						}
                        break;
                    case $menu == 'p6':
                        $ci->kesesuaianKurikulum();
                        break;
                    case $menu == 'p7':

						for ($i=8; $i <= 10 ; $i++) {
							$ci->distribusiFrekuensiKurikulum($i);
                        }
                        break;
                    case $menu == 'p8':
                        $ci->tingkatSerapanAlumni();
                        break;

                    default:
                        # code...
                        break;
                }
                 ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
