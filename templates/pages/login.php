<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PHPhotoTagging :: Log In</title>

  <link href="http://localhost/PHPhotoTagging/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
  <link href="http://localhost/PHPhotoTagging/css/bootstrap-theme.min.css" type="text/css" rel="stylesheet" />
  <link href="http://localhost/PHPhotoTagging/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
</head>
<body>

<div class="container">
<h2>PHPhotoTagging</h2>

<?php
  if($error) {
    echo $error['detail'];
  }
?>

  <form role="form" action="<?php echo baseurl(); ?>/login" method="POST">
    <div class="form-group">
      <label for="user">Email address</label>
      <input name="user" id="user" type="text" class="form-control" />
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input name="pass" type="password" id="password" class="form-control" />
    </div>
    <button type="submit" class="btn btn-default">Log In</button>
  </form>
</div><!-- .container -->
</body>
</html>
