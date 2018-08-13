<!DOCTYPE html>
<html>
<head>
<?php echo $this->section('head');?>
</head>
<body>
<?php echo $this->section('body');?>
</body>
</html>
<script>
$(document).ready(function() {
    $('select').material_select();
});
</script>
