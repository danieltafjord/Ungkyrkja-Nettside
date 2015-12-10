<?php
//Fixes 'Headers already sendt' issue
ob_start();

$con = mysqli_connect('localhost','ungkyrkja','ungkyrkja','ungkyrkja');
$location = '/';
if(isset($site_location)){
  $location = $site_location;
}
$distance_from_root = substr_count($location, '/');
function navBack($num_nav_back){
  $navString = '';
  for($i = 1; $i < $num_nav_back; $i++){
    $navString .= '../';
  }
  return $navString;
}
?>
<!-- Header -->
<nav class="navbar navbar-inverse" id="nav-main">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <i class="material-icons md-light">more_vert</i><span class="sr-only">Toggle navigation</span>
      </button>
      <a class="navbar-brand" href="<?php echo navBack($distance_from_root) . 'index.php'; ?>">Ungkyrkja</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li class="<?php if($location == '/index.php'){ echo 'active'; } ?>"><a href="<?php echo navBack($distance_from_root) . 'index.php'; ?>">Heim</a></li>
        <li class="<?php if($location == '/program.php'){ echo 'active'; } ?>"><a href="<?php echo navBack($distance_from_root) . 'program.php'; ?>">Program</a></li>
        <li class="<?php if($location == '/kontakt.php'){ echo 'active'; } ?>"><a href="<?php echo navBack($distance_from_root) . 'kontakt.php'; ?>">Kontakt</a></li>
        <li><a href="#" data-toggle="modal" data-target="#tilbakemelding">Tilbakemelding</a></li>
        <li class="<?php if($location == '/bilder.php'){ echo 'active'; } ?>"><a href="<?php echo navBack($distance_from_root) . 'bilder.php'; ?>">Bilder</a></li>

        <!-- If logged in show username -->
        <?php if(!empty($_COOKIE['auth-u'])) : ?>
        <li class="dropdown<?php if($location == '/account/index.php'){echo ' active';} ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <?php
              if(!empty($_COOKIE['auth-u'])) {
                $authuser = $_COOKIE['auth-u'];
                $row = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM users WHERE user = '$authuser'"));
                echo htmlentities($row['name']);
              }
            ?>
            <span class="caret"></span></a>
          <ul class="dropdown-menu" style="">
            <?php if(isset($_POST['minside'])) {header('Location: ' . navBack($distance_from_root) . 'account/');} ?>
            <form style="min-width:160px;" action="" method="POST" class="form-inline">
              <div class="form-group">
                <button type="submit" name="minside" class="btn btn-default">Min Side</button>
              </div>
              <div class="form-group">
                <button type="submit" name="logout" class="btn btn-danger">Logg ut</button>
              </div>
            </form>
          </ul>
        </li>
        <?php endif; ?>

        <?php if(empty($_COOKIE['auth-logged'])) :?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Login <span class="caret"></span></a>
          <ul class="dropdown-menu" style="">
            <form style="width:250px;" action="" method="POST">
        <div class="form-group">
          <label for="exampleInputEmail1">Brukernavn</label>
          <input type="text" class="form-control" name="user" placeholder="Brukernavn">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Passord</label>
          <input type="password" class="form-control" name="pass" placeholder="Passord">
        </div>
        <button type="submit" name="login" class="btn btn-primary">Submit</button>
      </form>
          </ul>
        </li>
      <?php endif; ?>
      <?php if(empty($_COOKIE['auth-logged'])) :?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Register <span class="caret"></span></a>
          <ul class="dropdown-menu" style="">
            <form style="width:250px;" action="" method="POST">
            <div class="form-group">
          <label for="exampleInputEmail1">Navn</label>
          <input type="text" class="form-control" required name="name" placeholder="Navn" pattern="[a-zA-Z0-9\s]+">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Brukernavn</label>
          <input type="text" class="form-control" required name="user" placeholder="Brukernavn">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Passord</label>
          <input type="password" class="form-control" required name="pass" placeholder="Passord">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Email</label>
          <input type="email" class="form-control" required name="email" placeholder="Email">
        </div>
        <button type="submit" name="register" class="btn btn-primary">Submit</button>
      </form>
          </ul>
        </li>
      <?php endif; ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="modal fade" id="tilbakemelding" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tilbakemelding</h4>
      </div>
      <div class="modal-body">
        <p>Gi tilbakemeldinger om hva du syntes er bra eller dårlig med denne nettsiden.</p>
        <form class="form form-group" action="" method="post">
          <div class="form-group">
            <label for="name">Navn</label>
            <input type="text" class="form-control" name="name" value="">
          </div>
          <div class="form-group">
            <label for="name">Email</label>
            <input type="text" class="form-control" name="email" value="">
          </div>
          <div class="form-group">
            <label for="name">Melding</label>
            <textarea name="message" class="form-control" value=""></textarea>
          </div>
          <div class="modal-footer">
            <button type="submit" name="tilbakemelding" class="btn btn-primary">Send</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php

if (isset($_POST['tilbakemelding'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];
  mysqli_query($con, "INSERT INTO tilbakemeldinger (name, email, message) VALUES ('$name', '$email', '$message')");
  header('Location: ' . $_SERVER['PHP_SELF']);
}

?>
