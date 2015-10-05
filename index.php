<?php
	include_once('resources/init.php');
	include_once('account/login.php');

	if(!empty($_COOKIE['auth-logged'])) {
		$islogged = false;
	} else {
		$islogged = true;
	}

	$posts = get_posts(((isset($_GET['id'])) ? $_GET['id'] : null));
	setlocale(LC_ALL, 'no');
?>

<div style="display:none;">
<?php
$postid = $_GET['id'];
?>
</div>

<!DOCTYPE html>
<html lang="no">
<head>
	<title>Ungkyrkja | Heim</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/teststyle.css">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link href="dist/css/roboto.min.css" rel="stylesheet">
    <link href="dist/css/material.min.css" rel="stylesheet">
    <link href="dist/css/ripples.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link href="http://ungkyrkja.co.nf/logo.png" rel="icon" type="image/png"/>
</head>
	<body>
	<!-- Header -->
	<nav class="navbar navbar-default navbar-fixed-top">
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
	        <li><a href="">Home</a></li>
	        <li><a href="program.php">Program</a></li>
	        <li><a href="#">Bilder</a></li>

	        <!-- If logged in show username -->
	        <?php if(!empty($_COOKIE['auth-u'])) : ?>
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php if(!empty($_COOKIE['auth-u'])) {echo $_COOKIE['auth-u'];} ?> <span class="caret"></span></a>
	          <ul class="dropdown-menu" style="">
	          <li><a href="account/">Min profil</a></li>
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

	<div class="jumbotron">
	  <div class="container">
	    <h1>Website</h1>
	    <p>For ungdom fr&aring; 8. klasse. Torsdagar kl.19.00-22.00. Interessegrupper, samlingar og ungdomsgudsteneste,
	     kiosk, weekend og andre utflukter.</p>
	  </div>
	</div>

	<!-- Section 1 -->
	<section>
	<div align="center" id="container">

	                <div class=<?php if(isset($_GET['id'])){echo '"post-container-large"';} else {echo '"post-container"';} ?> id="post">

						<br>

	                    <?php

		                    foreach ( $posts as $post ) {
		                            if ( ! category_exists('name', $post ['name'] ) ){
		                                    $post['name'] = 'Uncategorised';
		                            }
						?>

						<div class="post">

							<!--<button class=<?php if(isset($_GET['id'])){echo '"post-readall-large"';}else {echo '"post-readall"';} ?> onclick="javascript:location.href='index.php?id=<?php echo $post['post_id']; ?>'">READ ALL ...</button>-->

							<h2><a href="category.php?id=<?php echo $post['category_id']; ?>" class="category-post"><img src="<?php if($post['category_id'] == 13) { echo "img/samling.png";} elseif($post['category_id'] == 14) {echo "img/warning.png";} ?>" style="width:17px;"></a>
							<a href="index.php?id=<?php echo $post['post_id']; ?>" class=<?php if(isset($_GET['id'])){echo '"title-large"';}else {echo '"title"';} ?>><?php echo $post['title']; ?></a></h2>
							
							<small class="date"><img src="img/time.png" style="width:9px;margin-bottom:-1px;"> Postet <?php echo date('d / m / Y h:i', strtotime($post['date_posted'])); ?></small>

							<hr style="border:0;border-bottom:1px solid #e6e6e6;;"></hr>

							<p class="post-content" id="content"><?php echo nl2br($post['contents']);?></p>
							<br>

	                    </div>

						<?php
							}
						?>
						<!-- End Post -->

					</div>
	    </div></section><!-- END CONTAINER -->


<!-- Section 2 -->
	<section align="center" style="margin: 100px 0px;" id="kontakt">

		<h1 style="font-size:32px;">Kontakt</h1>
		<hr width="1000px" align="center" class="divider">

		<div class="kontakt-con">
			<a href="kontakt.php?p=Johannes"><img src="https://scontent.xx.fbcdn.net/hphotos-xpf1/v/t1.0-9/954725_847834458580329_5032481761037889532_n.jpg?oh=61e8af90d178c807a811634524ed7615&oe=562DC2CA"></a>
			<p>Johannes Kleppe</p>
			<small>Ungdomspastor</small>
		</div>
		<div class="kontakt-con">
			<a href="kontakt.php?p=Marion"><img src="img/standard.jpg"></a>
			<p>Marion Lende</p>
			<small>Barne- og ungdomsarbeider</small>
		</div>
		<div class="kontakt-con">
			<a href="kontakt.php?p=Håkon"><img src="img/standard.jpg"></a>
			<p>H&aring;kon Espevik</p>
			<small>Formann og kyrkjetenar</small>
		</div>

	</section>

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
	<script src="js/ripples.min.js"></script>
	<script src="js/material.min.js"></script>
	<script>
		$(document).ready(function() {
			// This command is used to initialize some elements and make them work properly
			$.material.init();
		});
	</script>
 	</body>
</html>
