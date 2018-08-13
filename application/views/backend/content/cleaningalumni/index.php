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
        Cleaning Data Alumni
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-"></i> <?php echo $conf->title;?></a></li>
        <li class="active">Cleaning Data Alumni</li>
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
            <div class="box-body table-responsive">

				<div class="row ">
					<div class="col-md-12">
					  <?php echo @$message;?>
					</div>

				</div>
				<table id="example1" class="table table-bordered table-striped">
                <thead>
					<tr>
					  <th>No.</th>
					  <th>Nama Alumni</th>
					  <th>Tahun Angkatan &amp; Lulus</th>
					  <th>Jawaban</th>
					  <th>Kontak</th>
					  <th>Aksi</th>
					</tr>

                </thead>
                <tbody>
					<?php
					$start=0;
					foreach($alumnis as $alumni) {
						$start++;
						$validator = ValidAlumni::firstOrCreate(['temp_alumni_id' => $alumni->id]);
						?>
						<tr>
						  <td><?=$start;?></td>

						  <td><?=$alumni->nama_depan." ".$alumni->nama_belakang;?></td>
						  <td><?php $ax = checker_year($alumni->tahun_angkatan, $alumni->tahun_lulus); ?><?= (($ax === true ) ? "valid" : $ax); ?></td>
						  <td><?php $ay = checker_jawaban($pertanyaans, $alumni->jawaban_alumni_temp); ?><?= (($ay === true ) ? "valid" : $ay); ?></td>
						  <td><?php $az = check_kontak($alumni->email, $alumni->telp_hp); ?><?= (($az === true ) ? "valid" : $az); ?></td>
						  <?php
						  if (
							  $ax === true
							  &&
							  $ay === true
							  &&
							  $az === true
					  	  ) {
						  	$validator->status = 1;
						  }
						  $validator->save();
						  ?>
						  <td>
						  <a href="<?php echo base_url($ci->urlController()->lihat."/".$alumni->id);?>" class="btn btn-default" target="_blank" title="Lihat Detail Alumni"><i class="fa fa-eye"></i></a>
						  &nbsp;
						  <!--
						  <a href="<?php echo base_url($ci->urlController()->edit."/".$alumni->id);?>" class="btn btn-primary"  title="Ubah Data Alumni"><i class="fa fa-edit"></i></a>
						  &nbsp;
					  		-->
						  <a href="<?php echo base_url($ci->urlController()->hapus."/".$alumni->id);?>" class="btn btn-danger notificationOnHapus Alumni" title="hapus Data"><i class="fa fa-close"></i></a>
						  </td>
						</tr>
					<?php } ?>
				</tbody>
				</table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix no-border">
              <a type="button" class="btn btn-default pull-right" href="<?php echo base_url(@$ci->urlController()->tambah);?>"><i class="fa fa-plus"></i> Tambah Alumni</a>
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
