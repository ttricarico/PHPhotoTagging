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
