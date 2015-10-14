<!-- Header -->
<style>
nav form{
  margin: 25px;
}
.active li > a{
  pointer-events: none;
}
</style>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <i class="material-icons">more_vert</i><span class="sr-only">Toggle navigation</span>
      </button>
      <a class="navbar-brand" href="#">Ungkyrkja</a>
    </div>
    <?php
    $location = $_SERVER['PHP_SELF'];
     ?>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li class="<?php if($location == '/index.php'){ echo 'active'; } ?>"><a href="index.php">Heim</a></li>
        <li class="<?php if($location == '/program.php'){ echo 'active'; } ?>"><a href="program.php">Program</a></li>
        <li class="<?php if($location == '/kontakt.php'){ echo 'active'; } ?>"><a href="kontakt.php">Kontakt</a></li>
        <li class="<?php if($location == '/bilder.php'){ echo 'active'; } ?>"><a href="bilder.php">Bilder</a></li>

        <!-- If logged in show username -->
        <?php if(!empty($_COOKIE['auth-u'])) : ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php if(!empty($_COOKIE['auth-u'])) {echo $_COOKIE['auth-u'];} ?> <span class="caret"></span></a>
          <ul class="dropdown-menu" style="">
          <li><a href="account/">Min profil</a></li>
            <form style="width:250px;" action="" method="POST">
        <button type="submit" name="logout" class="btn btn-primary">Logout</button>
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
      <?php endif;?>
      <?php if(empty($_COOKIE['auth-logged'])) :?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Register <span class="caret"></span></a>
          <ul class="dropdown-menu" style="">
            <form style="width:250px;" action="" method="POST">
            <div class="form-group">
          <label for="exampleInputEmail1">Navn</label>
          <input type="text" class="form-control" name="name" placeholder="Navn">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Brukernavn</label>
          <input type="text" class="form-control" name="user" placeholder="Brukernavn">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Passord</label>
          <input type="password" class="form-control" name="pass" placeholder="Passord">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Email</label>
          <input type="email" class="form-control" name="email" placeholder="Email">
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
