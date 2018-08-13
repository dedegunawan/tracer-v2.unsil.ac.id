<?php $this->layout('template_main_frontend'); ?>
<?php $this->insert('header_frontend'); ?>
<?php //$this->insert('content/first'); ?>
<br/>
<div class="container">
    <form action="<?php echo base_url($ci->urlController()->index);?>" method="post" >
    <div class="row">
      <div class="col s12">
          <?php
          if (@$now) {
              ?><h4>Pertanyaan ke <?php echo @$now;?> dari <?php echo @$count;?> Pertanyaan</h4><?php
          } else {
              echo "<h4>".@$thanks_text."</h4>";
          }

           ?>
      </div>
      <div class="col s12">
          <?php echo $pertanyaanView;?>
      </div>
      <div class="col s12">
          <br/>
          <?php
          if (@!$habis) {

              ?>
              <input type="hidden" name="pertanyaan_number" value="<?php echo @$now;?>" />
              <div class="row">
               <div class="input-field col s6">
                  <a href="<?php echo base_url(@$ci->urlController()->before);?>" class="waves-effect waves-light btn-large blue-grey lighten-5 black-text">Sebelumnya</a>
               </div>
               <div class="input-field col s6">
                  <button type="submit" class="waves-effect waves-light btn-large yellow black-text right submitMe">Selanjutnya</button>
               </div>
             </div>
              <?php
          } else {
              ?>
              <div class="row">
                   <div class="input-field col s12">
                      <a href="<?php echo base_url(@$ci->urlController()->destroy);?>" class="waves-effect waves-light btn-large blue-grey lighten-5 black-text">Kembali Ke Halaman Utama</a>
                   </div>

                 </div>
              <?php
          }

           ?>
      </div>
    </div>
    </form>
</div>

<script>

</script>
