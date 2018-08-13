<?php $this->layout('base_html') ?>
<?php $this->start('head'); ?>
<title><?php echo (@$page_title ? $this->e($page_title) : "App");?></title>

<?php $this->insert('head_base_frontend'); ?>
<?php echo $this->section('css_bottom');?>

<?php $this->stop() ?>
<?php $this->start('body'); ?>
<?php if (@!$_SESSION['roleAccess']): ?>
    <?php $this->insert('header_frontend'); ?>
<?php endif; ?>
<?php
if (@$_GET['abcd'] == 'saya') {
    //var_dump($_SESSION);
    //die();
}
?>
<?php if ($ci->router->fetch_class() === null): ?>
    <style>
    #logo {
        width:46px;margin:10px;
    }

    @media (max-width: 460px) {
        #logo {
            width:46px;
            margin:5px !important;
        }
        .hide-on-small {
            display: none !important;
        }
    }
    @media (max-width: 620px) and (min-width: 460px) {
        #logo {
            width:46px;
            margin:5px !important;
        }
    }
    </style>
    <div class="navbar-fixed ">
        <nav class="white teal-text">
            <div class="nav-wrapper white teal-text">
                <a href="#!" class="brand-logo teal-text" style="display:inline !important">
                    <img class="responsive-img" id="logo" src="http://unsil.ac.id/wp-content/uploads/2015/09/LOGO-UNSIL-BARU.png" style=""/>
                    <span style="position:relative;top:-24px;" class="hide-on-small">Tracer Studi Universitas Siliwangi</span>
                </a>

            </div>
        </nav>
    </div>
<?php endif; ?>

<?php echo $this->section('content');?>
<?php echo $this->section('js_bottom');?>
<?php $this->insert('body_bottom_frontend'); ?>
<?php $this->stop(); ?>
