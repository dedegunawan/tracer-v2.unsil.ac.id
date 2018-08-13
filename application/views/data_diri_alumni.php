<?php $this->layout('template_main_frontend'); ?>

<?php $this->start('css_bottom'); ?>
<link href="<?php echo base_url('/assets/select2/dist/css/select2-materialize.css');?>" rel="stylesheet" />
<script src="<?php echo base_url('/assets/select2/dist/js/select2.min.js');?>"></script>
<?php $this->stop(); ?>
<?php $this->start('js_bottom'); ?>
<script type="text/javascript">
  $('select').select2();
</script>
<?php $this->stop(); ?>
<?php $this->insert('header_frontend'); ?>
<?php //$this->insert('content/first'); ?>
<br/>
<div class="container">
    <div class="row">
      <div class="col s12">
          <h4>Data Diri Alumni</h4>
      </div>
      <div class="col s12">
      <form action="<?php echo base_url($ci->urlController()->index);?>" method="post" >

          <div class="row">
            <div class="input-field col m6 s12">
                <input placeholder="Nama Depan" id="nama_depan" name="nama_depan" type="text" class="validate <?php if( trim(form_error('nama_depan', ' ', ' ')) ) { echo "invalid"; };?>"  value="<?php echo set_value('nama_depan'); ?>" >
                <label for="nama_depan" data-error="<?php echo form_error('nama_depan', ' ', ' '); ?>">Nama Depan</label>
            </div>
            <div class="input-field col m6 s12">
                <input placeholder="Nama Belakang" id="nama_belakang" name="nama_belakang" type="text" class="validate <?php if( trim(form_error('nama_belakang', ' ', ' ')) ) { echo "invalid"; };?>"  value="<?php echo set_value('nama_belakang'); ?>" >
                <label for="nama_belakang" data-error="<?php echo form_error('nama_belakang', ' ', ' '); ?>">Nama Belakang</label>
            </div>
          </div>


          <div class="row">
            <div class="input-field col m3 s12">
                <input placeholder="Tahun Lulus" id="tahun_lulus" name="tahun_lulus" type="text" class="validate <?php if( trim(form_error('tahun_lulus', ' ', ' ')) ) { echo "invalid"; };?>" length="4"  value="<?php echo set_value('tahun_lulus'); ?>" >
                <label for="tahun_lulus" data-error="<?php echo form_error('tahun_lulus', ' ', ' '); ?>">Tahun Lulus</label>
            </div>
            <div class="input-field col m3 s12">
                <input placeholder="Tahun Angkatan" id="tahun_angkatan" name="tahun_angkatan" type="text" class="validate <?php if( trim(form_error('tahun_angkatan', ' ', ' ')) ) { echo "invalid"; };?>" length="4"  value="<?php echo set_value('tahun_angkatan'); ?>" >
                <label for="tahun_angkatan" data-error="<?php echo form_error('tahun_angkatan', ' ', ' '); ?>">Tahun Angkatan</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col m6 s12 black-text">
                <select id="prodi" name="prodi" class="validate <?php if( trim(form_error('prodi', ' ', ' ')) ) { echo "invalid"; };?>">
                  <option value="" disabled selected>Program Studi</option>
                  <?php
                  $selected_prodi = set_value('prodi');
                  if (@$listProdi && $listProdi instanceof Illuminate\Database\Eloquent\Collection) {
                      foreach ($listProdi as $value) {
                          echo "<option value=\"{$value->ProdiID}\" ".($value->ProdiID == $selected_prodi ? " selected " : "")." >{$value->Nama} (".@$value->jenjang->Nama.")</option>";
                      }
                  }
                  ?>
                </select>
                <!--<label for="prodi" data-error="<?php echo form_error('prodi', ' ', ' '); ?>">Program Studi</label>-->
            </div>
          </div>
          <div class="row">
            <div class="input-field col m6 s12 black-text">
                <select id="pekerjaan" name="pekerjaan" class="validate <?php if( trim(form_error('pekerjaan', ' ', ' ')) ) { echo "invalid"; };?>">
                  <option value="" disabled selected>Pekerjaan</option>
                  <?php
                  $selected_pekerjaan = set_value('pekerjaan');
                  if (@$listPekerjaan && $listPekerjaan instanceof Illuminate\Database\Eloquent\Collection) {
                      foreach ($listPekerjaan as $value) {
                          echo "<option value=\"{$value->nama_pekerjaan}\" ".($value->nama_pekerjaan == $selected_pekerjaan ? " selected " : "")."  >{$value->nama_pekerjaan}</option>";
                      }
                  }
                  ?>
                </select>
                <!--<label for="pekerjaan" data-error="<?php echo form_error('pekerjaan', ' ', ' '); ?>">Pekerjaan</label>-->
            </div>
          </div>

          <div class="row">
            <div class="input-field col m6 s12 black-text">
                <select id="jenis_kelamin" name="jenis_kelamin" class="validate <?php if( trim(form_error('jenis_kelamin', ' ', ' ')) ) { echo "invalid"; };?>">
                  <option value="" disabled selected>Jenis Kelamin</option>
                  <?php
                  $kelamins = array(
                      'L' => 'Laki-laki',
                      'P' => 'Perempuan'
                  );
                  $jenis_kelamin = set_value('jenis_kelamin');
                  if (@$kelamins ) {
                      foreach ($kelamins as $k => $value) {
                          echo "<option value=\"{$k}\" ".($value == $jenis_kelamin ? " selected " : "")."  >{$value}</option>";
                      }
                  }
                  ?>
                </select>
                <!--<label for="pekerjaan" data-error="<?php echo form_error('pekerjaan', ' ', ' '); ?>">Pekerjaan</label>-->
            </div>
          </div>

          <div class="row">
            <div class="input-field col m12 s12">
                <input placeholder="Tempat Bekerja" id="tempat_bekerja" name="tempat_bekerja" type="text" class="validate <?php if( trim(form_error('tempat_bekerja', ' ', ' ')) ) { echo "invalid"; };?>"  value="<?php echo set_value('tempat_bekerja'); ?>" >
                <label for="tempat_bekerja" data-error="<?php echo form_error('tempat_bekerja', ' ', ' '); ?>">Tempat Bekerja</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col m12 s12">
                <textarea id="alamat" name="alamat" class="materialize-textarea validate <?php if( trim(form_error('alamat', ' ', ' ')) ) { echo "invalid"; };?>"><?php echo set_value('alamat'); ?> </textarea>
                <label for="alamat" data-error="<?php echo form_error('alamat', ' ', ' '); ?>">Alamat Tinggal Saat Ini</label>
            </div>
          </div>


            <div class="row">
              <div class="input-field col m4 s12">
                  <input placeholder="Telp / HP" id="telp_hp" name="telp_hp" type="text" class="validate <?php if( trim(form_error('telp_hp', ' ', ' ')) ) { echo "invalid"; };?>"  value="<?php echo set_value('telp_hp'); ?>" >
                  <label for="telp_hp" data-error="<?php echo form_error('telp_hp', ' ', ' '); ?>">Telp / HP</label>
              </div>
              <div class="input-field col m6 s12">
                  <input placeholder="Alamat Email" id="email"  name="email" type="text" class="validate <?php if( trim(form_error('email', ' ', ' ')) ) { echo "invalid"; };?>"  value="<?php echo set_value('email'); ?>" >
                  <label for="email" data-error="<?php echo form_error('email', ' ', ' '); ?>">Alamat Email</label>
              </div>
            </div>

            <div class="row">
             <div class="input-field col s12 m12">
                <textarea id="kontak_lainnya" name="kontak_lainnya" class="materialize-textarea validate <?php if( trim(form_error('kontak_lainnya', ' ', ' ')) ) { echo "invalid"; };?>" ><?php echo set_value('kontak_lainnya'); ?></textarea>
                <label for="kontak_lainnya" data-error="<?php echo form_error('kontak_lainnya', ' ', ' '); ?>">Kontak Lainnya (Pisahkan dengan baris baru)</label>
             </div>
           </div>


            <div class="row">
             <div class="input-field col s12 m12">
                <button type="submit" class="waves-effect waves-light btn-large yellow black-text">Simpan</button>
             </div>
           </div>


      </form>
      </div>
    </div>
</div>
