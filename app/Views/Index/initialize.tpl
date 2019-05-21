<!DOCTYPE HTML>
<html lang="<?php echo LANG;?>">
<head>
<title><?php echo $PageData['Title'];?></title>
<?php include_once(APP_PATH_VIEWS .'HeadMeta.tpl');?>
</head>
<body>
<?php include_once(APP_PATH_VIEWS .'Headr.tpl');?>
<div class="header"></div>
<div class="container col-sm-10">
      <h3 class="display-5"><?php echo $PageData['Title'];?></h3>
      <div id="table"></div>
      <hr class="hr">
      <div id="chart"></div>
      <div class="btn">
        <button id="button" type="button" class="btn btn-primary btn-lg btn-block">Save chart settings</button>
      </div>
</div>
<?php include_once(APP_PATH_VIEWS .'Footer.tpl');?>
<!-- Scripts -->
<script>
    var arrMsg=<?php echo json_encode($PageData['errorjs']);?>;
    var fileName="<?php echo $PageData['fileName'];?>";
    var chart="<?php echo $PageData['Chart'];?>";
</script>
<?php include_once(APP_PATH_VIEWS .'Jscript.tpl');?>
<?php include_once(APP_PATH_VIEWS .$PageData['Chart'].'.tpl');?>
</body>
</html>
