<?php $this->layout('base_html') ?>

<?php $this->start('head'); ?>
<title><?php echo (@$page_title ? $this->e($page_title) : $conf->title);?></title>
<?php $this->insert('head_base'); ?>
<link rel="stylesheet" href="<?php echo base_url('/assets/plugins/iCheck/square/blue.css');?>">
<?php echo $this->section('bottom_css'); ?>
<?php $this->stop() ?>
<?php $this->start('body'); ?>

<div class="wrapper">
  <?php $this->insert('header_main'); ?>
  <!-- Left side column. contains the logo and sidebar -->
  <?php $this->insert('sidebar'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
	<?php echo $this->section('content');?>
  </div>
  <!-- /.content-wrapper -->
  <?php $this->insert('footer'); ?>



</div>
<!-- ./wrapper -->


<?php $this->insert('body_bottom_base'); ?>
<?php echo $this->section('bottom_js'); ?>
<?php $this->stop(); ?>
