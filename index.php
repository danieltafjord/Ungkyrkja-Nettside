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
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="dist/css/roboto.min.css" rel="stylesheet">
    <link href="dist/css/material.min.css" rel="stylesheet">
    <link href="dist/css/ripples.min.css" rel="stylesheet">
	<link href="css/index.css" rel="stylesheet">
	<link href="http://ungkyrkja.co.nf/logo.png" rel="icon" type="image/png"/>
</head>
	<body>
	<!-- Header -->
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <i class="material-icons">more_vert</i><span class="sr-only">Toggle navigation</span>
	      </button>
	      <a class="navbar-brand" href="#">Ungkyrkja</a>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav navbar-right">
	        <li class="active"><a href="">Home</a></li>
	        <li><a href="program.php">Program</a></li>
	        <li><a href="#">Bilder</a></li>

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
	<section style="margin: 100px 0px;" id="program-next">
		
		<h1 align="center" style="font-size:32px;">Neste samling</h1>
		<hr width="1000px" align="center" class="divider">
		<?php
		
		$conn = new mysqli("localhost", "ungkyrkja", "ungkyrkja", "ungkyrkja");
		$query = false;
		if($conn){
			$query = $conn->query("SELECT * FROM uk_program ORDER BY date ASC");
		}
		else{
			//Connection to the database has failed
		}
		$dateFormatter = new IntlDateFormatter('no_NB.utf-8', IntlDateFormatter::FULL, IntlDateFormatter::LONG);
		if($query){
			while($rows = $query->fetch_array()){
				$id = $rows['id'];
				$title = $rows['title'];
				$content = $rows['content'];
				$date = new DateTime($rows['date']);
				$enddate = new DateTime($rows['enddate']);
				$currentDate = new DateTime();
				if($date >= $currentDate){
					//Create panel with event data
			?>
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3 col-lg-4 col-lg-offset-4" id="<?php echo $id; ?>">
					<div class="event-panel panel panel-default">
						<div class="panel-heading">
							<button type="button" class="btn-edit btn btn-primary btn-fab btn-raised hidden"><i class="material-icons md-light">edit</i></button>
							<h3><?php echo $title;?></h3>
						</div>
						<div class="panel-body">
							<div class="event_data">
								<div>
									<i class="material-icons md-dark">event</i>
									<p><?php echo "Veke: " . $date->format("W"); ?></p>
								</div>
								<div>
									<i class="material-icons md-dark">access_time</i>
									<p><?php
										$dateFormatter->setPattern("EEEE dd. MMMM, HH:mm");
										if($date->format("d.m.Y") == $enddate->format("d.m.Y")){
											echo $dateFormatter->format($date) . " - " . $enddate->format("H:i");
										}
										else{
											echo $dateFormatter->format($date) . " - <br>" . $dateFormatter->format($enddate);
										}
										?></p>
								</div>
								<div>
									<?php if($content != ""){
										?>
										<i class="material-icons md-dark">label</i>
										<p><?php echo $content;?></p>
										<?php
									}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
					break;
				}
			}
		}
		
		$conn->close();
		
		?>

	</section>

<!-- Section 3 -->
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="dist/js/ripples.min.js"></script>
	<script src="dist/js/material.min.js"></script>
	<script src="js/program.js"></script>
	<script>
		$(document).ready(function() {
			// This command is used to initialize some elements and make them work properly
			$.material.init();
		});
	</script>
 	</body>
</html>
