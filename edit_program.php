<?php

	# Connect to database
	$con = mysqli_connect("localhost","ungkyrkja","ungkyrkja","ungkyrkja");
	$query;

		// Get id of event
	$id = $_GET['id'];
	if($id != NULL){
		$query = mysqli_query($con, "SELECT * FROM uk_program WHERE id LIKE " . $id)->fetch_assoc();
	}

	# Config
	setlocale(LC_ALL, 'no');
?>

<!DOCTYPE html>
<html lang="no">
<head>
	<title>Ungkyrkja | Program</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/teststyle.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/program.css">
	<link href="http://ungkyrkja.co.nf/logo.png" rel="icon" type="image/png"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>
<body>

<!-- Header -->
<div style="width:100%;height:60px;background-color:#fff;">
	<a href=""><img src="img/uk_logo.png" class="logo-img" /></a>
	<a href="program.php" style="float:right;margin-right:40px;margin-top:14px;padding:5px;">Program</a>
	<a href="bilder.php" style="float:right;margin-right:40px;margin-top:14px;padding:5px;">Bilder</a>
	<a href="" style="float:right;margin-right:40px;margin-top:14px;padding:5px;">Heim</a>
</div>

<!-- Main bit -->

<?php
	if($query != null){
		$title = $query['title'];
		$content = $query['content'];
		$date = new DateTime($query['date']);
		$enddate = new DateTime($query['enddate']);
	}
?>

<div class="container-fluid">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<form class="title-form form-group">
				<label for="title">Tittel:</label>
				<input type="text" class="form-control" id="title" value="<?php echo $title; ?>" />
			</form>
		</div>
		<div class="panel-body">
			<form class="body-form form-group">
				<label><img src="img/ic_access_time_black.png" /> Dato og tid: </label>
				<p>Startdato: </p><input type="date" class="form-control" id="date" value="<?php echo $date->format("Y-m-d"); ?>" />
				<p>Starttid: </p><input type="time" class="form-control" id="time" value="<?php echo $date->format("H:i"); ?>" />
				<p>Sluttdato: </p><input type="date" class="form-control" id="enddate" value="<?php echo $enddate->format("Y-m-d"); ?>" />
				<p>Sluttid: </p><input type="time" class="form-control" id="endtime" value="<?php echo $enddate->format("H:i");?>"
				<label for="content"><img src="img/ic_label_black.png" /> Innhold: </label>
				<textarea class="form-control" rows="5" id="content"><?php echo $content; ?></textarea>
			</form>
		</div>
	</div>
	<button type="button" class="button-save btn btn-primary">Lagre</button>
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

</body>
</html>
