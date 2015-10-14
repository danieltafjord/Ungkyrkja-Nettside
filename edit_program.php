<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ungkyrkja</title>
    <script src="bower_components\webcomponentsjs\webcomponents-lite.min.js"></script>
    <link rel="import" href="compontents\main-css.html">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="css/edit_program.css" rel="stylesheet">
  </head>
  <body>
    <!--Import navbar-->
    <?php include 'compontents\navbar.php'; ?>
		<!-- Main bit -->
		<?php

			$con = mysqli_connect("localhost","ungkyrkja","ungkyrkja","ungkyrkja");
			if (!$con) {
		    die("Connection failed: " . mysqli_error($con));
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
    <!--Import footer-->
    <?php include 'compontents\footer.php'; ?>

    <link rel="import" href="compontents\main-scripts.html">
  </body>
</html>
