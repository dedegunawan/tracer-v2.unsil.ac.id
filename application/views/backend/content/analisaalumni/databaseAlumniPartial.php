<?php
$real_url = base_url($ci->uri->segment(1).'/'.$ci->uri->segment(2).'/'.$ci->uri->segment(3));
?>
<script>
$(".notificationOnHapus").click(function(e) {
	e.preventDefault();
	var cfm = confirm("Apakah Anda yakin, akan menghapus data ini ?");
	if(cfm) {
		window.location.href=$(this).attr('href');
	}
});
changer("#prodiID",  '<?=$real_url;?>/');
</script>
<div class="row">
	<div class="col-md-12">
		Filter berdasarkan Prodi :
	</div>
	<div class="col-md-3">
		<select name="prodiID" id="prodiID" class="select2 form-control prodiIDChange">
			<?php
			$uri = $ci->uri->segment(4);
			?>
			<?php
			echo "<option value=\"\"  selected='selected'>
				--Pilih Salah Satu--
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
	<div class="col-md-12">
		<br />
	</div>

</div>
<table id="example1" class="table table-bordered table-striped">
<thead>
    <tr>
      <th>No.</th>
      <th>Nama</th>
      <th>Program Studi</th>
      <th>Tahun Angkatan</th>
      <th>Tahun Lulus</th>
      <th>Pekerjaan /<br />Institusi</th>
      <th>No. Kontak <br />Email</th>
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

          <td><?=$alumni->nama_depan." ".$alumni->nama_belakang;?></td>
          <td><?=@$alumni->prodiObject->Nama;?></td>
          <td><?=$alumni->tahun_angkatan;?></td>
          <td><?=$alumni->tahun_lulus;?></td>
          <td><?=$alumni->pekerjaan;?><br /><?=$alumni->tempat_bekerja;?></td>
          <td><?=$alumni->telp_hp;?><br /><?=$alumni->email;?></td>
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
