<?php
$real_url = base_url($ci->uri->segment(1).'/index');
?>
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
function changer($el, url) {
    $(document).on('change', $el, function(e) {
        e.preventDefault();
        var selectedVal=$(this).val();
        var newUrl = url+selectedVal;
        window.location.href=newUrl;
    });
}
changer("#prodiID",  '<?=$real_url;?>/');
<?php
if ($ci->uri->segment(3)) {
	?>
	changer("#tahun_angkatan",  '<?=$real_url."/".$ci->uri->segment(3);?>/');
<?php } ?>
</script>
<?php $this->stop() ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Alumni
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-"></i> <?php echo $conf->title;?></a></li>
        <li class="active">Master Alumni</li>
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
					<div class="col-md-3">
						<select name="prodiID" id="prodiID" class="select2 form-control prodiIDChange">
							<?php
							$uri = $ci->uri->segment(3);
							?>
							<?php
							echo "<option value=\"\"  selected='selected'>
								--Program Studi--
							</option>";
							$pr = Prodi::where('NA', 'N')->orderBy('ProdiID')->get();
							foreach ($pr as $value) {
								echo "<option value=\"{$value->ProdiID}\" ".(($value->ProdiID == $uri) ? " selected='selected' " : "").">
									{$value->ProdiID} - {$value->Nama}
								</option>";
							}
							?>
						</select>
					</div>
					<div class="col-md-3">
					<?php
					if ($uri) {
						?>
							<select name="tahun_angkatan" id="tahun_angkatan" class="select2 form-control">
								<?php
								$urx = $ci->uri->segment(4);
								?>
								<?php
								echo "<option value=\"\"  selected='selected'>
									--Angkatan--
								</option>";
								foreach ($listAngkatan as $angkatan) {
									echo "<option value=\"{$angkatan}\" ".(($angkatan == $urx) ? " selected='selected' " : "").">
										{$angkatan}
									</option>";
								}
								?>
							</select>
						<?php

					}
					else {

					}
					?>
					</div>
					<div class="col-md-6">
						<a href="<?=base_url(@$ci->urlController()->pdf."/".$ci->uri->segment(3)."/".$ci->uri->segment(4));?>" class="btn btn-primary pull-right" style="margin-right:8px;margin-left:8px;" target="_blank" title="Print PDF"><i class="fa fa-file-pdf-o"></i></a>
						<a href="<?=base_url(@$ci->urlController()->xls."/".$ci->uri->segment(3)."/".$ci->uri->segment(4));?>" class="btn btn-primary pull-right" style="margin-right:8px;margin-left:8px;"  target="_blank"  title="Print XLS"><i class="fa fa-file-excel-o"></i></a>
					</div>
					<div class="col-md-12">
						<br />
					</div>

				</div>
				<table id="example1" class="table table-bordered table-hover">
                <thead>
					<tr>
					  <th>No.</th>
					  <th>Nama Depan</th>
					  <th>Nama Belakang</th>
					  <th>Tahun Lulus</th>
					  <th>Tahun Angkatan</th>
					  <th>Tempat Bekerja</th>
					  <th>Pekerjaan</th>
					  <th>Alamat</th>
					  <th>Telp/HP</th>
					  <th>Email</th>
					  <th>kontak Lain</th>
					  <th>Jenis Kelamin</th>
					  <th>Prodi</th>
					  <th>Aksi</th>
					</tr>

                </thead>
                <tbody>
					<?php
					$start=0;
					foreach($alumnis as $alumni) {
						$start++;
						?>
						<tr>
						  <td><?=$start;?></td>

						  <td><?=$alumni->nama_depan;?></td>
						  <td><?=$alumni->nama_belakang;?></td>
						  <td><?=$alumni->tahun_lulus;?></td>
						  <td><?=$alumni->tahun_angkatan;?></td>
						  <td><?=$alumni->tempat_bekerja;?></td>
						  <td><?=$alumni->pekerjaan;?></td>
						  <td><?=$alumni->alamat;?></td>
						  <td><?=$alumni->telp_hp;?></td>
						  <td><?=$alumni->email;?></td>
						  <td><?=$alumni->kontak_lainnya;?></td>
						  <td><?=@$alumni->jenis_kelamin;?></td>
						  <td><?=@$alumni->prodiObject->Nama;?></td>
						  <td>
						  <a href="<?php echo base_url($ci->urlController()->lihat."/".$alumni->id);?>" class="btn btn-default"  title="Lihat Detail Alumni"><i class="fa fa-eye"></i></a>
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
              <a type="button" class="btn btn-primary pull-right" href="<?php echo base_url(@$ci->urlController()->tambah);?>" style="margin-right:8px;margin-left:8px;"><i class="fa fa-plus"></i> Tambah Alumni</a>
              <a type="button" class="btn btn-primary pull-right" href="<?php echo base_url(@$ci->urlController()->importExcel);?>" style="margin-right:8px;margin-left:8px;"><i class="fa fa-upload"></i> Import Excel</a>
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
