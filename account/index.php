<?php
	# Include login.php
	include_once('login.php');

	# Turning of basic error reporting
	error_reporting(0);

	# Get error logging class
	use Project\Error\error;
	include('account/error.php');

	# connect to database
	$con = mysqli_connect('localhost','ungkyrkja','ungkyrkja','ungkyrkja');
	if(!$con){
		# Repport error
		error::report($_SERVER['PHP_SELF'],'Failed to connect to database: ' . mysqli_error($con), 'Fatal', $_SERVER['REMOTE_ADDR'], date('Y-m-d h:i:sa'));
		die('<h3>Feil oppst&aring;dt:</h3><br><a href="#" onclick="window.history.back();">G&aring; tilbake</a> eller <a href="../kontakt.php">kontakt</a> for hjelp!');
	}
	if (!empty($_COOKIE['auth-u'])) {
?>
<!DOCTYPE html>
<html lang="no">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="apple-touch-icon" sizes="57x57" href="../icon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="../icon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="../icon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="../icon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="../icon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="../icon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="../icon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="../icon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="../icon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="../icon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../icon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="../icon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../icon/favicon-16x16.png">
	<link rel="manifest" href="/manifest.json">
	<meta name="msapplication-TileColor" content="#222">
	<meta name="msapplication-TileImage" content="../icon/ms-icon-144x144.png">
	<meta name="theme-color" content="#222">
	<title>Ungkyrkja | Bruker</title>
	<script src="../bower_components/webcomponentsjs/webcomponents-lite.min.js"></script>
	<link rel="import" href="../components/header-imports.html">
</head>
	<body>
		<style>
		.box {
			margin: 15px;
			background-color: #fff;
			/*background-color: #f4f4f4;*/
			padding:20px;
			border: 1px solid #e3e3e3;
			border-radius: 3px;
		}
		.modal-body input[type=checkbox] {
			display:none;
		}
		.modal-body input[type=checkbox] + label {
			background: #000;
			min-height: 80px;
			max-height: 120px;
			min-width: 80px;
			max-width: 150px;
			display:inline-block;
			padding: 0 0 0 0px;
			cursor: pointer;
		}
		.modal-body input[type=checkbox]:checked + label {
			opacity: .5;
			min-height: 80px;
			max-height: 120px;
			min-width: 80px;
			max-width: 120px;
			width: 80px;
			display:inline-block;
			padding: 0 0 0 0px;
		}
		.modal-footer .form-group{
			display: inline-block;
		}
		</style>
		<?php
			$site_location = '/account/index.php';
			include '../components/navbar.php';
			include 'components/alert.php';
		?>

		<!-- Container section -->
		<div align="left">
			<div class="row">
				<div class="col-md-4">
					<div class="box">
						<?php
							# set variables
							if (!empty($_COOKIE['auth-u'])) {
								$authu = $_COOKIE['auth-u'];
							}
							$queryusers = mysqli_query($con, "SELECT * FROM users WHERE user = '$authu'");
							# query table
							$rows = mysqli_fetch_array($queryusers);
								echo "<h2 style='margin:0;margin-bottom:10px;'>Hei, <strong>" . htmlentities($rows['name']) . "!</strong></h2><hr>";
								echo '<b>Brukernavn: </b>' . htmlentities($rows['user']) . '<br>';
								echo '<b>Email: </b>' . htmlentities($rows['email']) . '<br>';
								echo '<b>Du ble medlem: </b>' . htmlentities($rows['registered']) . '<br><br>';
								if ($rows['role'] == 1) {
									echo '<small>Denne brukeren har <strong>administrator</strong> rettigheter!</small><br>';
								}
						?>
					</div>
				</div>


				<?php if($rows['role'] == 1): ?>
				<div class="col-md-4">
					<div class="box">
						<h2 style="margin:0;margin-bottom:10px;">Last opp bilder her</h2><hr>
						<form class="main-form form-group" enctype="multipart/form-data" action="upload.php" method="POST">
							<div class="form-group">
								<input name="upload[]" type="file" id="file" class="jfilestyle" data-input="false" multiple="multiple" style="width:100%;"/>
							</div>
							<lable>Undertekst: </lable><br>
							<textarea name="desc" class="form-control" style="width:100%;" type="text" rows="3" multiple="multiple"></textarea><br><hr>
							<div class="form-group">
								<button type="submit" value="Upload" class="btn btn-primary" style="width:100%;">Last opp</button>
							</div>
						</form>
						<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#bilderModal">Slett bilder</button>
					</div>
				</div>
				<div class="col-md-4">
					<div class="box">
						<h2 style="margin:0;margin-bottom:10px;">Oppdater fremside bilde</h2><hr>
						<form class="main-form form-group" enctype="multipart/form-data" action="upload.php" method="POST">
							<div class="form-group">
									<input name="upload[]" type="file" id="file2" class="jfilestyle" data-input="false" multiple="multiple" style="width:100%;"/>
								<p class="help-block">Anbefalt størrelse: 1438x450</p>
							</div>
							<div class="checkbox">
								<p class="help-block">Trykk hvis dette bilde skal vere det første som viser.</p>
						    <label for="active">
									<input type="checkbox" id="active" name="active" value="1">Første bilde
								</label>
						  </div><hr>
							<div class="form-group">
								<button type="submit" name="submit-front" class="btn btn-primary" style="width:100%;">Last opp</button>
							</div>
						 </form>
						 <button class='btn btn-danger' data-toggle='modal' data-target='#myModal'>Slett bilder!</button>
					</div>
				</div>
			<?php endif; ?>
			</div>
		</div>

		<!-- this is a modal for deleteing images from fremside-->
		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Slett</h4>
					</div>
					<div class="modal-body">
						<form class="form-inline" method="POST" action="../delete.php">
						<p>Trykk på bildene du vil slette</p>
						<?php
							$sqlimg = mysqli_query($con, "SELECT * FROM fremside");
							while ($row = mysqli_fetch_array($sqlimg)) {
								echo "<input type='checkbox' id='" . $row['id'] . "' name='fremside[]' value='" . $row['id'] . "'><label for='" . $row['id'] . "' style='background-size:cover;background-image:url(../img/" . htmlentities($row['name']) . ");'></label> ";
							}
						?>
					</div>
					<div class="modal-footer">
						<div class="form-group">
							<button type="submit" class="btn btn-danger" name="submit-fremside">Slett</button>
						</div>
						<div class="form-group">
							<button type="button" class="btn btn-default" data-dismiss="modal">Lukk</button>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<!-- this is a modal for deleteing images from bilder-->
		<div id="bilderModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Slett bilder</h4>
					</div>
					<div class="modal-body">
						<form class="form-inline" method="POST" action="../delete.php">
						<p>Trykk på bildene du vil slette</p>
						<?php
							$sqlimg = mysqli_query($con, "SELECT * FROM bilder");
							while ($row = mysqli_fetch_array($sqlimg)) {
								echo "<input type='checkbox' id='" . $row['id'] . "' name='bilder[]' value='" . $row['id'] . "'><label for='" . $row['id'] . "' style='background-size:cover;background-image:url(../bilder/" . htmlentities($row['img']) . ");'></label> ";
							}
						?>
					</div>
					<div class="modal-footer">
						<div class="form-group">
							<button type="submit" class="btn btn-danger" name="submit-bilder">Slett</button>
						</div>
						<div class="form-group">
							<button type="button" class="btn btn-default" data-dismiss="modal">Lukk</button>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<?php include '../components/footer.php'; ?>
 	</body>
</html>
<?php } else { echo "Du har ikke tilgang til denne siden!"; } ?>
