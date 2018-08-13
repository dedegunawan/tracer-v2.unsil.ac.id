<?php $this->layout('main_template') ?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> <?php echo $conf->title;?></a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <?php
        $modules = $ci->_getModule();
        foreach ($modules as $module) {

            ?>
            <section class="col-lg-4">
                <?php
                if ($module['menu'] != 'kosongNow') {
                ?>
              <!-- TO DO List -->
              <div class="box box-primary">
                <?php
                if ($module['menu']) {
                    ?>
                    <div class="box-header">
                      <h3 class="box-title"><?=$module['menu'];?></h3>
        			</div>
                    <?php
                }
                 ?>
                <!-- /.box-header -->
                <div class="box-body">
    			<?php
                //var_dump($module['file']);
                $this->insert($module['file']);
                ?>
    			</div>
                <!-- /.box-body -->
                <div class="box-footer clearfix no-border">
                  <!-- <button type="button" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add item</button>-->
                </div>
              </div>
              <!-- /.box -->
              <?php  }?>

            </section>
            <?php
        }
         ?>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
