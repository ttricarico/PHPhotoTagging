<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PHPhotoTagging<?php echo ($title != '') ? ' :: '.$title : ''; ?></title>

  <link href="<?php echo baseurl();?>/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
  <link href="<?php echo baseurl();?>/css/bootstrap-theme.min.css" type="text/css" rel="stylesheet" />
  <link href="<?php echo baseurl();?>/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
  <link href="<?php echo baseurl();?>/css/defaults.css" type="text/css" rel="stylesheet" />

  <script src="<?php echo baseurl();?>/js/jquery-2.1.1.min.js" type="text/javascript"></script>
  <script src="<?php echo baseurl();?>/js/bootstrap.min.js" type="text/javascript"></script>
<?php if($addlscripts) {
  foreach($addlscripts as $as) {
    ?><script src="<?php echo $as; ?>" type="text/javascript"></script><?php echo PHP_EOL;
  }
} ?>
</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" href="<?php echo baseurl();?>/"><i class="fa fa-home"></i> Back Home</a>
      </div>
      <div class="collapse navbar-collapse">


        <ul class="nav navbar-nav navbar-right">
          <li>
            <a href="<?php echo baseurl();?>/photo/upload">Upload New Photo</a>
          </li>
          <li>
            <form class="navbar-form navbar-right" role="search">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search Photos">
                <span class="input-group-btn">
                  <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                </span>
              </div>
            </form>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i><span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">All Photos</a></li>
              <li><a href="#">Photos I uploaded</a></li>
              <li class="divider"></li>
              <li><a href="<?php echo baseurl();?>/logout">Log Out <i class="fa fa-sign-out text-danger"></i></a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
</nav>
<div class="container">
