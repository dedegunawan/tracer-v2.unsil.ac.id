<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
		  <!-- Sidebar user panel -->
		  <div class="user-panel">
			<div class="pull-left image">
			  <img src="<?php echo $ci->session->userdata('user')['Profile']->image_url;?>" class="img-circle" alt="<?php echo @$ci->session->userdata('user')['Profile']->nama_depan." ".@$ci->session->userdata('user')['Profile']->nama_belakang;?>">
			</div>
			<div class="pull-left info">
			  <p><?php echo @$ci->session->userdata('user')['Profile']->nama_depan." ".$ci->session->userdata('user')['Profile']->nama_belakang;?></p>
			  <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		  </div>

      <!-- search form -->
	  <!--
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
	  -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <?php $the_router = strtolower($ci->router->fetch_class());?>
        <li class="header">Menu Utama</li>
        <?php
        if ($ci->role->hasAccess('Dashboard')) {
            ?>
		<li class="<?php echo ($the_router ==  "dashboard" ?" active ": "" );?>"><a href="<?php echo base_url('/dashboard');?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <?php
        }
        ?>
        <?php
        if ($ci->role->hasAccess('MasterPengguna') || $ci->role->hasAccess('MasterAlumni') ) {
            ?>
        <li class="treeview <?php echo (in_array($the_router, array("masterpengguna", "masteralumni")) ?" active ": "" );?>">
          <a href="#">
            <i class="fa fa-database"></i> <span>Master Data</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <?php
              if ($ci->role->hasAccess('MasterAlumni')) {
                  ?>
            <li class="<?php echo ($the_router ==  "masteralumni" ?" active ": "" );?>"><a href="<?php echo base_url('/masteralumni');?>"><i class="fa fa-circle-o"></i> Alumni</a></li>
                    <?php
                }
                ?>
                <?php
                if ($ci->role->hasAccess('MasterPengguna')) {
                    ?>
            <li class="<?php echo (strtolower($the_router) == "masterpengguna"?" active ":"");?>"><a href="<?php echo base_url('/masterpengguna');?>"><i class="fa fa-circle-o"></i> Pengguna Alumni </a></li>
                    <?php
                }
                ?>

          </ul>
        </li>
            <?php
        }
        ?>
        <?php
        if ($ci->role->hasAccess('AnalisaAlumni') | $ci->role->hasAccess('AnalisaPengguna')) {
            ?>
        <li class="treeview <?php echo (in_array($the_router, array("analisaalumni", "analisapengguna")) ?" active ": "" );?>">
          <a href="#">
            <i class="fa fa-area-chart"></i> <span>Analisa Jawaban</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <?php
          if ($ci->role->hasAccess('AnalisaAlumni')) {
              ?>
          <ul class="treeview-menu">
            <li class="<?php echo (strtolower($the_router) == "analisaalumni"?" active ":"");?>"><a href="<?php echo base_url('/analisaalumni');?>"><i class="fa fa-circle-o"></i>  Alumni </a></li>
                    <?php
                }
                ?>
                <?php
                if ($ci->role->hasAccess('AnalisaPengguna')) {
                    ?>
            <li class="<?php echo ($the_router ==  "analisapengguna" ?" active ": "" );?>"><a href="<?php echo base_url('/analisapengguna');?>"><i class="fa fa-circle-o"></i> Pengguna Alumni</a></li>
                    <?php
                }
                ?>
          </ul>
        </li>
            <?php
        }
        ?>
        <?php
        if ($ci->role->hasAccess('SaranAlumni') | $ci->role->hasAccess(' ')) {
            ?>
        <li class="treeview <?php echo (in_array($the_router, array("saranalumni", "saranpengguna")) ?" active ": "" );?>">
          <a href="#">
            <i class="fa-envelope-open-o"></i> <span>Kritik &amp; Saran</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <?php
          if ($ci->role->hasAccess('SaranAlumni')) {
              ?>
          <ul class="treeview-menu">
            <li class="<?php echo (strtolower($the_router) == "saranalumni"?" active ":"");?>"><a href="<?php echo base_url('/saranalumni');?>"><i class="fa fa-circle-o"></i>  Alumni </a></li>
                    <?php
                }
                ?>
                <?php
                if ($ci->role->hasAccess('SaranPengguna')) {
                    ?>
            <li class="<?php echo ($the_router ==  "saranpengguna" ?" active ": "" );?>"><a href="<?php echo base_url('/saranpengguna');?>"><i class="fa fa-circle-o"></i> Pengguna Alumni</a></li>
                    <?php
                }
                ?>
          </ul>
        </li>
            <?php
        }
        ?>
	  </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
