<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#009688">
    <title>Heim | Ungkyrkja</title>
    <script src="bower_components\webcomponentsjs\webcomponents-lite.min.js"></script>
    <link rel="import" href="compontents\main-css.html">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="css/index.css" rel="stylesheet">
  </head>
  <body>
    <!--Import navbar-->
    <?php include 'compontents\navbar.php'; ?>
		<?php
	include_once('account/login.php');

	if(!empty($_COOKIE['auth-logged'])) {
		$islogged = false;
	} else {
		$islogged = true;
	}
?>

<div class="jumbotron">
	<div class="container">
		<h1>Website</h1>
		<p>For ungdom fr&aring; 8. klasse. Torsdagar kl.19.00-22.00. Interessegrupper, samlingar og ungdomsgudsteneste,
		 kiosk, weekend og andre utflukter.</p>
	</div>
</div>

<!-- Section 2 -->
	<div class="container-fluid" style="margin: 100px 0px;" id="program-next">

		<h1 align="center" style="font-size:32px;">Neste samling</h1>
		<hr width="100%" align="center" class="divider">
		<?php

		$conn = new mysqli("localhost", "ungkyrkja", "ungkyrkja", "ungkyrkja");
		$query = false;
		if($conn){
			$query = $conn->query("SELECT * FROM uk_program ORDER BY date ASC");
		}
		else{
			//Connection to the database has failed
		}
		$conn->close();
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
						<div class="panel-heading withripple">
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
		?>
  </div>
    <!--Import footer-->
    <?php include 'compontents\footer.php'; ?>

    <link rel="import" href="compontents\main-scripts.html">
		<script src="js/program.js"></script>
  </body>
</html>
