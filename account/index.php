<?php
	include_once('../resources/init.php');
	include_once('login.php');

	if(!empty($_COOKIE['auth-logged'])) {
		$islogged = false;
	} else {
		$islogged = true;
	}
	if (!empty($_COOKIE['auth-u'])) {
?>

<div style="display:none;">
	<?php
		$postid = $_GET['id'];
	?>
</div>

<!DOCTYPE html>
<html lang="no">
<head>
	<title>Ungkyrkja | Account</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/teststyle.css">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link href="http://ungkyrkja.co.nf/logo.png" rel="icon" type="image/png"/>
</head>
	<body>

	<!-- Header -->
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	      </button>
	      <a class="navbar-brand" href="#">Ungkyrkja</a>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="../index.php">Home</a></li>
	        <li><a href="../program.php">Program</a></li>
	        <li><a href="#">Bilder</a></li>

	        <!-- If logged in show username -->
	        <?php if(!empty($_COOKIE['auth-u'])) : ?>
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php if(!empty($_COOKIE['auth-u'])) {echo $_COOKIE['auth-u'];} ?> <span class="caret"></span></a>
	          <ul class="dropdown-menu" style="">
	            <form style="width:250px;" action="" method="POST">
				  <button type="submit" name="logout" class="btn btn-default">Logout</button>
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
				  <button type="submit" name="login" class="btn btn-default">Submit</button>
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
				  <button type="submit" name="register" class="btn btn-default">Submit</button>
				</form>
	          </ul>
	        </li>
	    	<?php endif; ?>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>


	<!-- Footer -->
	<section style="background-color:#fff;min-height:200px;">
	<div style="padding-top:25px;border-bottom:1px solid #e5e5e5;" align="center">
	    	<ul>
	    		<li>&copy; Ungkyrkja Bryne</li>
	    	</ul>
		</div>
		<div style="padding-top:0px;" align="center">
	    	<ul>
	    		<li><a href="index.php">Heim</a></li>
	    		<li><a href="#kontakt">Kontakt</a></li>
	    		<li><a href="index.php">App</a></li>
	    		<li><a href="program.php">Program</a></li>
	    		<li><a href="admin.php">Admin</a></li>
	    	</ul>
		</div>
	</section>
	<script type="text/javascript">
		$(window).scroll(function(){

		  var wScroll = $(this).scrollTop();

		  $('.123').css({
		    'transform' : 'translate(0px, -'+ wScroll /40 +'%)'
		  });
	  	});

	$('a[href^="#"]').on('click', function(event) {

	    var target = $( $(this).attr('href') );

	    if( target.length ) {
	        event.preventDefault();
	        $('html, body').animate({
	            scrollTop: target.offset().top
	        }, 800);
	    }

	});

	</script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

 	</body>
</html>

<?php } else { header('Location: ../index.php'); } ?>
