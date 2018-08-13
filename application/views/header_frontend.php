<style>
@media (max-width:680px) {
    .hide-on-small {
        display: none;
    }
}
@media (min-width:680px) and  (max-width:810px) {
    .hide-on-small {
        font-size: 80%;
    }
}
@media (max-width:640px) {
    .rightXYZ {
        float: right;

    }
}
@media (min-width:640px) {
    .rightXYZ {
        float: right;
    }
}
</style>
<div class="navbar-fixed">
    <nav class="white teal-text" role="navigation" style="height:84px">
        <div class="nav-wrapper container teal-text">
            <a id="logo-container" href="<?php echo base_url($ci->urlController()->destroy);?>" class="brand-logo" style="padding:10px;padding-left:0px"><img class="responsive-img" id="logo" src="<?php echo base_url('/assets/logo.png');?>" style="height:50px;vertical-align:middle"/> <span class="teal-text hide-on-small">Tracer Alumni Universitas Siliwangi</span></a>
            <ul id="nav-mobile" class="rightXYZ teal-text" >
                <li class=" teal-text"><a href="<?=base_url('/login');?>" class=" teal-text" style="padding:10px 30px;">Login</a></li>
            </ul>
        </div>
     </nav>
</div>
