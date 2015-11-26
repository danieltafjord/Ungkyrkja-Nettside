<?php
	# Include login.php
	include_once('login.php');
	include '../components/alert.php';

	# Turning of basic error reporting
	#error_reporting(0);

	# Get error logging class
	#use Project\Error\error;
	#include('error.php');

	# connect to database
	$con = mysqli_connect('localhost','ungkyrkja','ungkyrkja','ungkyrkja');
	if(!$con){
		# Repport error
		error::report($_SERVER['PHP_SELF'],'Failed to connect to database: ' . mysqli_error($con), 'Fatal', $_SERVER['REMOTE_ADDR'], date('Y-m-d h:i:sa'));
		die('<h3>Feil oppst&aring;dt:</h3><br><a href="#" onclick="window.history.back();">G&aring; tilbake</a> eller <a href="../kontakt.php">kontakt</a> for hjelp!');
	}
	setlocale(LC_TIME, 'no_NO');
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
		.row {
			font-size:14px;
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
			include '../components/alert.php';
		?>

		<!-- Container section -->
		<div align="left">
			<div class="row" style="margin:0;">
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
							$datetime = date_create($rows['registered']);
								echo "<h2 style='margin:0;margin-bottom:10px;'>Hei, <strong>" . htmlentities($rows['name']) . "!</strong></h2><hr>";
								echo '<b>Brukernavn: </b>' . htmlentities($rows['user']) . '<br>';
								echo '<b>Email: </b>' . htmlentities($rows['email']) . '<br>';
								echo '<b>Du ble medlem: </b>' . date_format($datetime, "F d, Y") . '<br><br>';
						?>
					</div>
				</div>

			<?php if($rows['role'] <= 2): ?>
				<div class="col-md-8">
					<div class="box">
						<?php $con = mysqli_connect('localhost','ungkyrkja','ungkyrkja','ungkyrkja'); $errorsqlall = mysqli_query($con, "SELECT * FROM error"); ?>
						<h2 style="margin:0;margin-bottom:10px;font-weight:bold;">Feil meldinger <span class="badge"><?php echo mysqli_num_rows($errorsqlall); ?></span></h2><hr>
						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<tr>
									<th>Id</th>
									<th>Side</th>
									<th>Melding</th>
									<th>Type</th>
									<th>Ip</th>
									<th>Dato</th>
									<th>Telling</th>
									<th>Slett</th>
								</tr>
								<?php
								$errorsql = mysqli_query($con, "SELECT * FROM error ORDER BY type LIMIT 10");
								if (mysqli_num_rows($errorsql) == 0) {
									echo "<tr><td>Finner ingen feilmeldinger.</td></tr>";
								} else {
									while ($row = mysqli_fetch_array($errorsql)) {
										echo "<tr>";
										echo "<td>" . htmlentities($row['id']) . "</td>";
										echo "<td>" . htmlentities($row['page']) . "</td>";
										echo "<td>" . htmlentities($row['message']) . "</td>";
										echo "<td>" . htmlentities($row['type']) . "</td>";
										echo "<td>" . htmlentities($row['ip']) . "</td>";
										echo "<td>" . htmlentities($row['time']) . "</td>";
										echo "<td>" . htmlentities($row['count']) . "</td>";
										echo "<td>";
										echo "<form method='post' action=''>&nbsp;&nbsp;<button style='border:none;background-color:transparent;' value ='" . $row['id'] . "' name='del'><span class='glyphicon glyphicon-trash' style='color:#d9534f;'></span></button></form>";
										echo "</td>";
										echo "</tr>";
									}
								}

								if (isset($_POST['del'])) {
									$id = $_POST['del'];
									mysqli_query($con, "DELETE FROM error WHERE id = '$id'");
									header('Location: ' . $_SERVER['PHP_SELF'] . '?alert=1004');
								}

								?>
							</table>
						</div>
					</div>
				</div>

				<div class="col-md-12">
					<div class="box">
						<?php $brukersql = mysqli_query($con, "SELECT * FROM users"); ?>
						<h2 style="margin:0;margin-bottom:10px;font-weight:bold;">Brukere <span class="badge"><?php echo mysqli_num_rows($brukersql); ?></span></h2><hr>
						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<tr>
									<th>Id</th>
									<th>Navn</th>
									<th>Brukernavn</th>
									<th>Email</th>
									<th>Registrert</th>
									<th>Ip</th>
									<th>Rolle</th>
									<th>Aktivert</th>
									<th>Deaktiver</th>
									<th>Aktiver</th>
									<th>Slett</th>
								</tr>
								<?php

								$brukersql = mysqli_query($con, "SELECT * FROM users");
								while ($userrow = mysqli_fetch_array($brukersql)) {
									$date = date_create($userrow['registered']);
									if ($userrow['active'] == 0) {echo "<tr class='danger'>";}
									elseif ($userrow['role'] == 1) {echo "<tr class='success'>";}
									elseif ($userrow['role'] == 2) {echo "<tr class='warning'>";}
									else {echo "<tr>";}
									echo "<td>" . htmlentities($userrow['id']) . "</td>";
									echo "<td>" . htmlentities($userrow['name']) . "</td>";
									echo "<td>" . htmlentities($userrow['user']) . "</td>";
									echo "<td>" . htmlentities($userrow['email']) . "</td>";
									echo "<td>" . date_format($date, 'F d, Y') . "</td>";
									echo "<td>" . htmlentities($userrow['ip']) . "</td>";
									if ($userrow['role'] == 0) { echo "<td>Bruker</td>";}
									if ($userrow['role'] == 1) { echo "<td>Administrator</td>";}
									if ($userrow['role'] == 2) { echo "<td>Utvikler</td>";}
									if ($userrow['active'] == 1) {echo "<td>Ja</td>";}
									if ($userrow['active'] == 0) {echo "<td>Nei</td>";}
									echo "<td><form method='post' action=''>&nbsp;&nbsp;<button style='border:none;background-color:transparent;' value ='" . $userrow['id'] . "' name='freezeuser'><span class='glyphicon glyphicon-minus' style='color:#555;'></span></button></form></td>";
									echo "<td><form method='post' action=''>&nbsp;&nbsp;<button style='border:none;background-color:transparent;' value ='" . $userrow['id'] . "' name='unfreezeuser'><span class='glyphicon glyphicon-plus' style='color:#555;'></span></button></form></td>";
									echo "<td><form method='post' action=''>&nbsp;&nbsp;<button style='border:none;background-color:transparent;' value ='" . $userrow['id'] . "' name='deluser'><span class='glyphicon glyphicon-trash' style='color:#d9534f;'></span></button></form></td>";
									echo "</tr>";
								}

								if (isset($_POST['deluser'])) {
									$id = $_POST['deluser'];
									mysqli_query($con, "DELETE FROM users WHERE id = '$id'");
									header('Location: ' . $_SERVER['PHP_SELF'] . '?alert=1005');
								}
								if (isset($_POST['freezeuser'])) {
									$id = $_POST['freezeuser'];
									mysqli_query($con, "UPDATE users SET active = '0' WHERE id = '$id'");
									header('Location: ' . $_SERVER['PHP_SELF'] . '?alert=1006');
								}
								if (isset($_POST['unfreezeuser'])) {
									$id = $_POST['unfreezeuser'];
									mysqli_query($con, "UPDATE users SET active = '1' WHERE id = '$id'");
									header('Location: ' . $_SERVER['PHP_SELF'] . '?alert=1007');
								}

								?>

							</table>
						</div>
					</div>
				</div>
			<?php endif; ?>

				<?php if($rows['role'] == 1): ?>

				<div class="col-md-4" style="border:none;">
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
				<div class="col-md-12">
					<div class="box">
						<h2 style="margin:0;margin-bottom:10px;">Brukere</h2><hr>
						<div class="table-responsive">
							<table class="table table-striped table-hover">
								<tr>
									<th>Id</th>
									<th>Navn</th>
									<th>Brukernavn</th>
									<th>Email</th>
									<th>Registrert</th>
									<th>Ip</th>
									<th>Rolle</th>
									<th>Aktivert</th>
									<th>Deaktiver</th>
									<th>Aktiver</th>
									<th>Slett</th>
								</tr>
								<?php

								$brukersql = mysqli_query($con, "SELECT * FROM users");
								while ($userrow = mysqli_fetch_array($brukersql)) {
									$date = date_create($userrow['registered']);
									if ($userrow['active'] == 0) {echo "<tr class='danger'>";}
									else {echo "<tr class='success'>";}
									echo "<td>" . htmlentities($userrow['id']) . "</td>";
									echo "<td>" . htmlentities($userrow['name']) . "</td>";
									echo "<td>" . htmlentities($userrow['user']) . "</td>";
									echo "<td>" . htmlentities($userrow['email']) . "</td>";
									echo "<td>" . date_format($date, 'F d, Y') . "</td>";
									echo "<td>" . htmlentities($userrow['ip']) . "</td>";
									if ($userrow['role'] == 0) { echo "<td>Bruker</td>";}
									if ($userrow['role'] == 1) { echo "<td>Administrator</td>";}
									if ($userrow['role'] == 2) { echo "<td>Utvikler</td>";}
									if ($userrow['active'] == 1) {echo "<td>Ja</td>";}
									if ($userrow['active'] == 0) {echo "<td>Nei</td>";}
									echo "<td><form method='post' action=''>&nbsp;&nbsp;<button style='border:none;background-color:transparent;' value ='" . $userrow['id'] . "' name='freezeuser'><span class='glyphicon glyphicon-minus' style='color:#555;'></span></button></form></td>";
									echo "<td><form method='post' action=''>&nbsp;&nbsp;<button style='border:none;background-color:transparent;' value ='" . $userrow['id'] . "' name='unfreezeuser'><span class='glyphicon glyphicon-plus' style='color:#555;'></span></button></form></td>";
									echo "<td><form method='post' action=''>&nbsp;&nbsp;<button style='border:none;background-color:transparent;' value ='" . $userrow['id'] . "' name='deluser'><span class='glyphicon glyphicon-trash' style='color:#d9534f;'></span></button></form></td>";
									echo "</tr>";
								}

								if (isset($_POST['deluser'])) {
									$id = $_POST['deluser'];
									mysqli_query($con, "DELETE FROM users WHERE id = '$id'");
									header('Location: ' . $_SERVER['PHP_SELF'] . '?alert=1005');
								}
								if (isset($_POST['freezeuser'])) {
									$id = $_POST['freezeuser'];
									mysqli_query($con, "UPDATE users SET active = '0' WHERE id = '$id'");
									header('Location: ' . $_SERVER['PHP_SELF'] . '?alert=1006');
								}
								if (isset($_POST['unfreezeuser'])) {
									$id = $_POST['unfreezeuser'];
									mysqli_query($con, "UPDATE users SET active = '1' WHERE id = '$id'");
									header('Location: ' . $_SERVER['PHP_SELF'] . '?alert=1007');
								}

								?>

							</table>
						</div>
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
<?php } else { header('location: ../'); } ?>
