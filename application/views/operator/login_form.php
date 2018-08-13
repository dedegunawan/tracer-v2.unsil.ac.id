<?php $this->layout('template_main_frontend'); ?>

<?php $this->start('css_bottom'); ?>
<style>
.navbar-fixed {
    display: none;
}
</style>
<?php $this->stop(); ?>
<?php $this->start('js_bottom'); ?>
<?php $this->stop(); ?>
<div class="section"></div>
<main>
<center>
  <img class="responsive-img" style="width: 100px;" src="http://unsil.ac.id/wp-content/uploads/2015/09/LOGO-UNSIL-BARU.png" />
  <div class="section"></div>

  <h5 class="green-text ">Tracer Studi UNSIL</h5>
  <div class="section"></div>

  <div class="container">
    <?php
    if (
        @$message
    ) {
        foreach ($message as $key => $value) {
            if ($key == 'error') {
                $color = 'red darken-4';
            }
            else if ($key == 'success') {
                $color = 'green darken-3';
            }
            else {

            }
            ?>
            <div class="z-depth-1 <?=$color;?> row " style="display: block; padding: 20px 48px 20px 48px;width:520px;">

              <div class="col s12 white-text">
                  <?php echo implode("<br />", $value);?>
              </div>
            </div>
            <?php
        }
    }
    ?>
    <div class="z-depth-1 grey lighten-4 row" style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px solid #EEE;width:520px">

      <form class="col s12" method="post" action="">
        <div class='row'>
          <div class='col s12'>
          </div>
        </div>

        <div class='row'>
          <div class='input-field col s12'>
            <input class='validate' type='text' name='username' id='username' />
            <label for='username'>Username</label>
          </div>
        </div>

        <div class='row'>
          <div class='input-field col s12'>
            <input class='validate' type='password' name='password' id='password' />
            <label for='password'>Masukkan Password</label>
          </div>

        </div>

        <br />
        <center>
          <div class='row'>
            <button type='submit' name='btn_login' class='col s12 btn btn-large waves-effect green'>Login</button>
          </div>
        </center>
      </form>
    </div>
  </div>
  <a href="<?php echo base_url();?>" class="indigo-text">kembali ke home</a>
</center>

<div class="section"></div>
<div class="section"></div>
</main>
