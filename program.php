<?php
	include_once('resources/init.php');
	include_once('account/login.php');

	if(!empty($_COOKIE['auth-logged'])) {
		$islogged = false;
	} else {
		$islogged = true;
	}

	# Connect to database
	$conn = new mysqli("localhost","ungkyrkja","ungkyrkja","ungkyrkja");
	$query = $conn->query("SELECT * FROM uk_program ORDER BY date ASC");
	# Config
	setlocale(LC_ALL, 'no');
?>

<!DOCTYPE html>
<html lang="no">
<head>
	<title>Ungkyrkja | Program</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/teststyle.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="dist/css/roboto.min.css" rel="stylesheet">
    <link href="dist/css/material.min.css" rel="stylesheet">
    <link href="dist/css/ripples.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/program.css">
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
	      <a class="navbar-brand" href="index.php">Ungkyrkja</a>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="index.php">Home</a></li>
	        <li class="active"><a href="">Program</a></li>
	        <li><a href="index.php#">Bilder</a></li>

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

<a href="edit_program.php" id="btn-new"><button type="button" class="btn btn-danger btn-fab btn-raised"><i class="material-icons md-light">add</i></button></a>

<!--Main bit-->
<div class="container-fluid">

	<div class="row">
	<?php
		$dateFormatter = new IntlDateFormatter('no_NB.utf-8', IntlDateFormatter::FULL, IntlDateFormatter::LONG);
		
		function createEventPanel($id, $title, $content, $date, $enddate, $columns, $dateFormatter){
			//Create panel with event data
			?>
			<div class="<?php echo "col-sm-" . $columns;?>" id="<?php echo $id; ?>">
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
		<?php		
		}
	
		$month="";
		$row = 0;
		
		while($rows = $query->fetch_array()){
			$id = $rows['id'];
			$title = $rows['title'];
			$content = $rows['content'];
			$date = new DateTime($rows['date']);
			$enddate = new DateTime($rows['enddate']);
			
			//Create a divider if there is a new month
			if($month != $date->format("m")){
				$row = 0;
				?>
	</div>			
		<div class="month_divider">
			<p><?php 
				$dateFormatter->setPattern("MMMM");
				echo $dateFormatter->format($date);
				?></p>
			<hr>
		</div>
	<div class="row">
			<?php	
			}
			//Create a wide panel if there is more than 500 chars in the content
			$columns = 4;
			if(strlen($content) >= 500){
				$columns = 8;
			}
			//Check if the row has enough space
			if($row + $columns <= 12){
				$row += $columns;
				createEventPanel($id, $title, $content, $date, $enddate, $columns, $dateFormatter);
			}
			//Else, create a new row
			else{
				$row = 0;
				?>
	</div>
	<div class="row">
				<?php
				createEventPanel($id, $title, $content, $date, $enddate, $columns, $dateFormatter);
			}
			//Update month after every cycle
			$month = $date->format("m");
		}
	?>
	</div>
</div>

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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
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
