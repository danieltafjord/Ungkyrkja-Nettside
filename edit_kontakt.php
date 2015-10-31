<?php
	include_once('account/login.php');

	error_reporting(0);
	if (!empty($_COOKIE['auth-u'])) {
			$authu = $_COOKIE['auth-u'];
	}
	if (!empty($_COOKIE['auth-logged'])) {
			$authlogged = $_COOKIE['auth-logged'];
	}

	# Connect to database
	$con = mysqli_connect('localhost','ungkyrkja','ungkyrkja','ungkyrkja');
	$query = mysqli_query($con, "SELECT * FROM contact");
	$queryusers = mysqli_query($con, "SELECT * FROM users WHERE user = '$authu'");

	if (isset($_POST['email'])) {
			$postemail = $_POST['email'];
	}
	if (isset($_POST['phone'])) {
			$postphone = $_POST['phone'];
	}
	if (isset($_POST['profession'])) {
			$postprofession = $_POST['profession'];
	}

	if (isset($_POST['submit'])) {
		mysqli_query($con, "UPDATE contact SET email='$postemail', phone='$postphone', profession='$postprofession' WHERE user = '$authu'");
	}

	while ($rows = mysqli_fetch_array($queryusers)) {
		$userid = $rows['id'];

		if (isset($_GET['id'])) {
			if ($_GET['id'] != $rows['id']) {
				die('Du kan ikkje redigere denne kontakten! <a href="kontakt.php">Tilbake til kontakter!</a>');
			}
		}
		if ($rows['role'] == 1) {
			$admin = true;
			if (!$_GET['id']) {
			header('Location: index.php');
			}
		}
		if ($rows['role'] == 0) {
			header('Location: index.php');

		}
		$querycontacts = mysqli_query($con, "SELECT * FROM contact WHERE id = '$userid'");

	}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="theme-color" content="#222">
    <link rel="icon" href="img/uk_logo.png" sizes="192x192">
    <title>Ungkyrkja | kontakt</title>
    <script src="bower_components/webcomponentsjs/webcomponents-lite.min.js"></script>
    <link rel="import" href="components/main-css.html">
  </head>
  <body>
    <!--Import navbar-->
    <?php include 'components/navbar.php'; ?>
    <!--Content here-->
				<?php
					#  Loop trough table
					while ($rows = mysqli_fetch_array($querycontacts)) {
						$contentemail = $rows['email'];
						$contentphone = $rows['phone'];
						$contentprofession = $rows['profession'];
					}

				?>

		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3">
					<div class="well">
						<form class="main-form form-group" method="post" action="">
							<Legend>Rediger kontakt</legend>
							<div class="form-group">
								<label for="email" class="control-label">Email:</label>
								<input type="email" name="email" class="form-control floating-label" id="email" value="<?php echo $contentemail ?>">
							</div>

							<div class="form-group">
								<label for="number" class="control-label">Telefon:</label>
								<input type="number" name="phone" class="form-control floating-label" id="number" value="<?php echo $contentphone ?>">
							</div>

							<div class="form-group">
								<label for="text" class="control-label">Stilling:</label>
								<input type="text" name="profession" class="form-control floating-label" value="<?php echo $contentprofession ?>">
							</div>

							<button type="submit" class="btn btn-primary" name="submit">Lagre</button>
							<a href="kontakt.php"><button type="button" class="btn btn-default">Tilbake</button></a>
						</form>
					</div>
				</div>
			</div>
		</div>

    <!--Import footer-->
    <?php include 'components/footer.php'; ?>

    <link rel="import" href="components/main-scripts.html">
  </body>
</html>
