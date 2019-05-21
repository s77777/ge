<!DOCTYPE HTML>
<html lang="<?php echo LANG;?>">
<head>
<title><?php echo $PageData['Title'];?></title>
<?php include_once(APP_PATH_VIEWS .'HeadMeta.tpl');?>
</head>
<body>
<?php include_once(APP_PATH_VIEWS .'Headr.tpl');?>
<div class="container col-sm-6">
    <div class="div-center">
      <h3><?php echo $PageData['error'];?></h3>
      <hr/>
      <a href="/"><?php echo $PageData['gohome'];?></a>
    </div>
</div>
<?php include_once(APP_PATH_VIEWS .'Jscript.tpl');?>
</body>
</html>
