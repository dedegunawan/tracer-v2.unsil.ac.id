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
          <h4>Data Diri Pengguna Alumni</h4>
      </div>
      <div class="col s12">
      <form action="<?php echo base_url($ci->urlController()->index);?>" method="post" >

          <div class="row">
            <div class="input-field col m12 s12">
                <input placeholder="Nama Lembaga" id="nama_lembaga" name="nama_lembaga" type="text" class="validate <?php if( trim(form_error('nama_lembaga', ' ', ' ')) ) { echo "invalid"; };?>"  value="<?php echo set_value('nama_lembaga'); ?>" >
                <label for="nama_lembaga" data-error="<?php echo form_error('nama_lembaga', ' ', ' '); ?>">Nama Lembaga</label>
            </div>
            <div class="input-field col m6 s12">
                <input placeholder="Jabatan" id="jabatan" name="jabatan" type="text" class="validate <?php if( trim(form_error('jabatan', ' ', ' ')) ) { echo "invalid"; };?>"  value="<?php echo set_value('jabatan'); ?>" >
                <label for="jabatan" data-error="<?php echo form_error('jabatan', ' ', ' '); ?>">Jabatan</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12 m6">
                <input placeholder="Email Lembaga" id="email_lembaga" name="email_lembaga" type="text" class="validate <?php if( trim(form_error('email_lembaga', ' ', ' ')) ) { echo "invalid"; };?>"  value="<?php echo set_value('email_lembaga'); ?>" >
                <label for="email_lembaga" data-error="<?php echo form_error('email_lembaga', ' ', ' '); ?>">Email Lembaga</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col m6 s12">
                <input placeholder="Nama Alumni" id="nama_alumni" name="nama_alumni" type="text" class="validate <?php if( trim(form_error('nama_alumni', ' ', ' ')) ) { echo "invalid"; };?>" value="<?php echo set_value('nama_alumni'); ?>" >
                <label for="nama_alumni" data-error="<?php echo form_error('nama_alumni', ' ', ' '); ?>">Nama Alumni</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col m3 s12">
                <input placeholder="Tahun Angkatan" id="tahun_angkatan" name="tahun_angkatan" type="text" class="validate <?php if( trim(form_error('tahun_angkatan', ' ', ' ')) ) { echo "invalid"; };?>" length="4"  value="<?php echo set_value('tahun_angkatan'); ?>" >
                <label for="tahun_angkatan" data-error="<?php echo form_error('tahun_angkatan', ' ', ' '); ?>">Tahun Angkatan</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col m3 s12">
                <input placeholder="Tahun Lulus" id="tahun_lulus" name="tahun_lulus" type="text" class="validate <?php if( trim(form_error('tahun_lulus', ' ', ' ')) ) { echo "invalid"; };?>" length="4"  value="<?php echo set_value('tahun_lulus'); ?>" >
                <label for="tahun_lulus" data-error="<?php echo form_error('tahun_lulus', ' ', ' '); ?>">Tahun Lulus</label>
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
             <div class="input-field col s12">
                <button type="submit" class="waves-effect waves-light btn-large  yellow black-text">Simpan</button>
             </div>
           </div>


      </form>
      </div>
    </div>
</div>
