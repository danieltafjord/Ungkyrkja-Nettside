<?php
	include_once('account/login.php');
	# Connect to database
	$con = mysqli_connect('localhost','ungkyrkja','ungkyrkja','ungkyrkja');
	$query = mysqli_query($con, "SELECT * FROM contact");

	if(!empty($_COOKIE['auth-logged'])) {
		echo "You do not have permission!";
	} else {

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#009688">
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
					while ($rows = mysqli_fetch_array($query)) {

					}

				?>

		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3">
					<div class="well">
						<form class="main-form form-group" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
							<Legend>Rediger kontakt</legend>
							<div class="form-group">
								<label for="email" class="control-label">Email:</label>
								<input type="email" class="form-control floating-label" id="email" placeholder="email">
							</div>

							<div class="form-group">
								<label for="number" class="control-label">Telefon:</label>
								<input type="number" class="form-control floating-label" id="number" placeholder="telefon">
							</div>

							<button type="submit" class="btn btn-primary">Lagre</button>
							<a href="program.php"><button type="button" class="btn btn-default">Tilbake</button></a>
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

<?php } ?>
