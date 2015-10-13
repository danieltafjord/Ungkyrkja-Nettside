<?php 
	
	$con = mysqli_connect("localhost","ungkyrkja","ungkyrkja","ungkyrkja");
	if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
	}
	
	$id = $title = $date = $time = $enddate = $endtime = $content = "";
	
	//Get values from post
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$id = test_input($_POST['id']);
		$title = test_input($_POST['title']);
		$date = test_input($_POST['date']);
		$time = test_input($_POST['time']);
		$enddate = test_input($_POST['enddate']);
		$endtime = test_input($_POST['endtime']);
		$content = test_input($_POST['content']);
		
		$date = date_create_from_format("Y-m-d H:i", $date . " " . $time);
		$enddate = date_create_from_format("Y-m-d H:i", $enddate . " " . $endtime);
		
		if($id != ""){
			$sql_query = "UPDATE uk_program SET title='$title', content='$content', date='" . $date->format("Y-m-d H:i:s") . "', enddate='" . $enddate->format("Y-m-d H:i:s") . 
			"' WHERE id LIKE '$id'";
			if(mysqli_query($con, $sql_query)){
				echo "Event updated successfully";
			} else {
				echo "Error updating Event: " . mysqli_error($con);
			}
		}
		else{
			$sql_query = "INSERT INTO uk_program (title, content, date, enddate) 
			VALUES ('$title', '$content', '" . $date->format("Y-m-d H:i:s") . "', '" . $enddate->format("Y-m-d H:i:s") . "')";
			if(mysqli_query($con, $sql_query)){
				echo "Event updated successfully";
			} else {
				echo "Error updating Event: " . mysqli_error($con);
			}
		}
	}
	
	function test_input($data) {
  		$data = trim($data);
  		$data = stripslashes($data);
  		$data = htmlspecialchars($data);
  		return $data;
	}
?>

<?php
	$query = null;
	
		// Get id of event
	if(isset($_GET['id'])){
		
	$id = test_input($_GET['id']);	
	}
	if($id != ""){
		$query = mysqli_query($con, "SELECT * FROM uk_program WHERE id LIKE '$id'")->fetch_assoc();
	}

	# Config
	setlocale(LC_ALL, "no");
?>

<!DOCTYPE html>
<html lang="no">
<head>
	<title>Ungkyrkja | Rediger program</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#009688">
	<link rel="stylesheet" type="text/css" href="css/teststyle.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="dist/css/roboto.min.css" rel="stylesheet">
    <link href="dist/css/material.min.css" rel="stylesheet">
    <link href="dist/css/ripples.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/edit_program.css">
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
	        <li><a href="program.php">Program</a></li>
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

<!-- Main bit -->

<?php
	if($query != null){
		$title = $query["title"];
		$content = $query["content"];
		$date = new DateTime($query["date"]);
		$enddate = new DateTime($query["enddate"]);
	}
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3">
			<div class="well">
				<form class="main-form form-group" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<Legend>Tittel:</legend>
					<input type="text" class="form-control" id="title" value="<?php echo $title; ?>" name="title"/>
					<fieldset>
						<legend>Dato og tid:</legend>
						<label for="date" class="control-label">Start dato:</label>
						<input type="date" class="form-control" id="date" name="date" value="<?php if($date!=""){echo $date->format("Y-m-d");} ?>" />
						<label for="time" class="control-label">Start tid: </label>
						<input type="time" class="form-control" id="time" name="time" value="<?php if($date!=""){echo $date->format("H:i");} ?>" />
						<label for="enddate" class="control-label">Slutt dato:</label>
						<input type="date" class="form-control" id="enddate" name="enddate" value="<?php if($enddate!=""){echo $enddate->format("Y-m-d");} ?>" />
						<label for="endtime" class="control-label">Slutt tid:</label>
						<input type="time" class="form-control" id="endtime" name="endtime" value="<?php if($enddate!=""){echo $enddate->format("H:i");}?>" />
					</fieldset>
					<legend>Innhold:</legend>
					<textarea class="form-control" rows="5" id="content" name="content"><?php echo $content; ?></textarea>
					<input type="text" class="form-control hidden" id="id" name="id" value="<?php echo $id; ?>" />
					<button type="submit" class="btn btn-primary">Lagre</button>
					<a href="program.php"><button type="button" class="btn btn-default">Tilbake</button></a>
				</form>
			</div>
		</div>
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
<script>
	$(document).ready(function() {
		// This command is used to initialize some elements and make them work properly
		$.material.init();
	});
</script>
</body>
</html>