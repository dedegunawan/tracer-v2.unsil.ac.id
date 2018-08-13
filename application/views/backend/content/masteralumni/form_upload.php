<?php $this->layout('main_template') ?>

<?php $this->start('bottom_css') ?>
<?php $this->stop() ?>


<?php $this->start('bottom_js') ?>
<script>
$(".submit-this-form").click(function(e) {
	e.preventDefault();
	$("form").has($(this)).submit();
});
</script>
<?php $this->stop() ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?= @$page_title ? $page_title : "Import Excel";?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-"></i> Import file Excel</a></li>
        <li class="active">Master Anak</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-3">
        </section>
        <section class="col-lg-6">
		<form class="" action="" method="post" enctype="multipart/form-data">
          <!-- TO DO List -->
          <div class="box box-primary">
            <div class="box-header">


			</div>
            <!-- /.box-header -->
            <div class="box-body">
				<div class="row">
					<div class="col-md-12">
					  <?php echo @$message;?>
					</div>

				  </div>

            	<div class="row">
					<div class="col-md-12">
                        <p>
                            Sebelum melakukan upload file, file harus disesuaikan dengan format yang ada di excel.
                        </p>
                    </div>
					<div class="col-md-6">
						<div class="form-group">
							<label>File Excel <sup style="color:red">*</sup></label>
							<input type="file" class="" name="file_excel"  value="" required="true"/>

						</div>
					</div>

				</div>

			</div>
            <!-- /.box-body -->
            <div class="box-footer clearfix no-border">
			  <a type="button" class="btn btn-primary" href="<?php echo base_url($ci->urlController()->templateExcel);?>" style="margin:0px 10px"><i class="fa fa-download"></i> Download file template</a>
			  <a type="button" class="btn btn-primary pull-right submit-this-form" href="#" style="margin:0px 10px"><i class="fa fa-save"></i> Simpan</a>
			  <a type="button" class="btn btn-primary pull-right " href="<?php echo base_url($ci->urlController()->list);?>"  style="margin:0px 10px"><i class="ion-arrow-left-c"></i> Kembali</a>
            </div>
          </div>
          <!-- /.box -->

        </section>
		</form>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
