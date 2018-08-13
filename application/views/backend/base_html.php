<!DOCTYPE html>
<html>
<head>
<?php echo $this->section('head');?>
</head>
<body <?php echo (@$body_class?$body_class: ' class="hold-transition skin-black-light sidebar-mini fixed" ')?>>
<?php echo $this->section('body');?>
</body>
</html>
