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
			background-color: #f4f4f4;
			padding:20px;
			border: 1px solid #e3e3e3;
		}
		.modal-body input[type=checkbox] {
		display:none;
		}

		.modal-body input[type=checkbox] + label
		{
		background: #000;
		min-height: 80px;
		max-height: 120px;
		min-width: 80px;
		max-width: 150px;
		display:inline-block;
		padding: 0 0 0 0px;
		cursor: pointer;
		}
		.modal-body input[type=checkbox]:checked + label
		{
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
						<h2 style="margin:0;margin-bottom:10px;">Info</h2>
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
								echo '<b>Navn: </b>' . $rows['name'] . '<br>';
								echo '<b>Email: </b>' . $rows['email'] . '<br>';
								echo '<b>Du ble medlem: </b>' . $rows['registered'] . '<br><br>';
								if ($rows['role'] == 1) {
									echo '<small>Denne brukeren har administrator rettigheter!</small><br>';
								}
							}
						?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="box">
						<h2 style="margin:0;margin-bottom:10px;">Last opp bilder her</h2>
						<form enctype="multipart/form-data" action="upload.php" method="POST">
							<div class="form-group">
								<label>Velg filer her: </lable>
								<input name="upload[]" type="file" multiple="multiple" style="width:100%;" />
							</div>
							<div class="form-group">
								<label>Undertekst: </lable><br>
								<textarea name="desc" class="form-control" style="width:100%;" type="text" rows="3" multiple="multiple"></textarea>
							</div>
							<div class="form-group">
								<button type="submit" value="Upload" class="btn btn-primary" style="width:100%;">Last opp</button>
							</div>
						 </form>
					</div>
				</div>
				<div class="col-md-4">
					<div class="box">
						<h2 style="margin:0;margin-bottom:10px;">Oppdater fremside bilde</h2>
						<form enctype="multipart/form-data" action="upload.php" method="POST">
							<div class="form-group">
								<label>Velg filer her: </lable>
								<input name="upload[]" type="file" multiple="multiple" style="width:100%;" />
								<p class="help-block">Anbefalt størrelse: 1438x450</p>
							</div>
							<div class="checkbox">
								<p class="help-block">Trykk hvis dette bilde skal vere det første som viser.</p>
						    <label for="active">
									<input type="checkbox" id="active" name="active" value="1">Første bilde
								</label>
						  </div>
							<div class="form-group">
								<button type="submit" name="submit-front" class="btn btn-primary" style="width:100%;">Last opp</button>
							</div>
						 </form>
						 <button class='btn btn-danger' data-toggle='modal' data-target='#myModal'>Slett bilder!</button>
					</div>
				</div>
			</div>
		</div>

		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Advarsel</h4>
					</div>
					<div class="modal-body">
						<form class="form-inline" method="POST" action="../delete.php">
						<p>Trykk på bildene du vil slette</p>
						<?php
						$sqlimg = mysqli_query($con, "SELECT * FROM fremside");
						while ($row = mysqli_fetch_array($sqlimg)) {
							#echo "<div>";
							echo "<input type='checkbox' id='" . $row['id'] . "' name='fremside[]' value='" . $row['id'] . "'><label for='" . $row['id'] . "' style='background-size:cover;background-image:url(../img/" . $row['name'] . ");'></label> ";
							#echo "</div>";
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

		<?php include '../components/footer.php'; ?>
 	</body>
</html>
<?php } else { header('Location: ../index.php'); } ?>
