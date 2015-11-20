<?php
	include_once('login.php');

	$get_user = $_COOKIE['auth-u'];
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
		</style>
		<?php
			$site_location = '/account/index.php';
			include '../components/navbar.php';
		?>

		<!-- Container section -->
		<div align="left">
			<div class="row">
				<div class="col-md-4">
					<div class="box">
						<?php
							# connect to database
							$con = mysqli_connect('localhost','ungkyrkja','ungkyrkja','ungkyrkja');
							if(!$con){
								die('Failed to connect to database: ' . mysqli_error($con));
							}
							# set variables
							$authu = $_COOKIE['auth-u'];
							$queryusers = mysqli_query($con, "SELECT * FROM users WHERE user = '$authu'");
							# query table
							while ($rows = mysqli_fetch_array($queryusers)) {
								echo "<h2 style='margin:0;margin-bottom:10px;'>Hei, <strong>" . htmlentities($rows['name']) . "!</strong></h2><hr>";
								echo '<b>Brukernavn: </b>' . htmlentities($rows['user']) . '<br>';
								echo '<b>Email: </b>' . htmlentities($rows['email']) . '<br>';
								echo '<b>Du ble medlem: </b>' . htmlentities($rows['registered']) . '<br><br>';
								if ($rows['role'] == 1) {
									echo '<small>Denne brukeren har <strong>administrator</strong> rettigheter!</small><br>';
								}
							}
						?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="box">
						<h2 style="margin:0;margin-bottom:10px;">Last opp bilder her</h2><hr>
						<form class="main-form form-group" enctype="multipart/form-data" action="upload.php" method="POST">
							<div class="form-group">
								<input name="upload[]" type="file" id="file" class="jfilestyle" data-input="false" multiple="multiple" style="width:100%;"/>
								<label for="file" data-multiple-caption="{count} filer er valgt">
									<svg xmlns="http://www.w3.org/2000/svg" width="18" height="15" fill="#fff" viewBox="0 0 18 15"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg>
									Velg filer
								</label>
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
							<button type="button" class="btn btn-default" data-dismiss="modal">Lukk</button>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-danger" name="submit-fremside">Slett</button>
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
							<button type="button" class="btn btn-default" data-dismiss="modal">Lukk</button>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-danger" name="submit-bilder">Slett</button>
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
