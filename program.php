<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#009688">
    <title>Program | Ungkyrkja</title>
    <script src="bower_components\webcomponentsjs\webcomponents-lite.min.js"></script>
    <link rel="import" href="compontents\main-css.html">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/program.css">
  </head>
  <body>
    <!--Import navbar-->
    <?php include 'compontents\navbar.php'; ?>
		<?php
			include_once('account/login.php');

			if(empty($_COOKIE['auth-logged'])) {
				$islogged = false;
			} else {
				$islogged = true;
			}

			# Connect to database
			$conn = new mysqli("localhost","ungkyrkja","ungkyrkja","ungkyrkja");
			$program = $conn->query("SELECT * FROM uk_program ORDER BY date ASC");
			$user = false;
			if($islogged){
			$user = $_COOKIE['auth-u'];
			$user = $conn->query("SELECT user, role FROM users WHERE user LIKE $user");
			$user = $user->fetch_array();
			}
			$conn->close();
		?>

		<?php
			$role = 0;
			if($user){
				$role = (int) $user['role'];
				if($role > 0){
					?>
		<a href="edit_program.php" id="btn-new"><button type="button" class="btn btn-danger btn-fab btn-raised"><i class="material-icons md-light">add</i></button></a>
					<?php
				}
			}
		?>

		<!--Main bit-->
		<div class="container-fluid">

			<div class="row">
			<?php
				$dateFormatter = new IntlDateFormatter('no_NB.utf-8', IntlDateFormatter::FULL, IntlDateFormatter::LONG);

				function createEventPanel($id, $title, $content, $date, $enddate, $columns, $dateFormatter, $role){
					//Create panel with event data
					?>
					<div class="<?php echo "col-sm-" . $columns;?>" id="<?php echo $id; ?>">
						<div class="event-panel panel panel-default">
							<div class="panel-heading withripple">
								<?php if($role > 0){ ?><button type="button" class="btn-edit btn btn-primary btn-fab btn-raised hidden"><i class="material-icons md-light">edit</i></button><?php } ?>
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

				while($rows = $program->fetch_array()){
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
						createEventPanel($id, $title, $content, $date, $enddate, $columns, $dateFormatter, $role);
					}
					//Else, create a new row
					else{
						$row = 0;
						?>
			</div>
			<div class="row">
						<?php
						createEventPanel($id, $title, $content, $date, $enddate, $columns, $dateFormatter, $role);
					}
					//Update month after every cycle
					$month = $date->format("m");
				}
			?>
			</div>
		</div>
    <!--Import footer-->
    <?php include 'compontents\footer.php'; ?>

    <link rel="import" href="compontents\main-scripts.html">
		<script src="js/program.js"></script>
  </body>
</html>
