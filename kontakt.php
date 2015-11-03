<?php
	include_once('account/login.php');
	//error_reporting(0);
	if (!empty($_COOKIE['auth-u'])) {
			$authu = $_COOKIE['auth-u'];
	}
	if (!empty($_COOKIE['auth-logged'])) {
			$authlogged = $_COOKIE['auth-logged'];
	}

	if(empty($_COOKIE['auth-logged'])) {
		$islogged = true;
	} else {
		$islogged = false;
	}

	# Connect to database
	$conn = mysqli_connect('localhost','ungkyrkja','ungkyrkja','ungkyrkja');
	$query = mysqli_query($conn, "SELECT * FROM contact");
	$queryusers = mysqli_query($conn, "SELECT * FROM users WHERE user = '$authu'");
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="apple-touch-icon" sizes="57x57" href="icon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="icon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="icon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="icon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="icon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="icon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="icon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="icon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="icon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="icon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="icon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="icon/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#222">
    <meta name="msapplication-TileImage" content="icon/ms-icon-144x144.png">
    <meta name="theme-color" content="#222">
    <title>Ungkyrkja | kontakt</title>
    <script src="bower_components/webcomponentsjs/webcomponents-lite.min.js"></script>
    <link rel="import" href="components/header-imports.html">
  </head>
	<style>
	.kontakt-img {
		border: 2px solid #fff;
		border-radius: 50%;
		width:250px;
		margin-bottom: 20px;
	}
	.divider {
		border-bottom: 1px solid #e3e3e3;
		margin: 10px;
	}

	.glyphicon {
		font-size: 12px;
		color: #444;
	}

	h6 {
		color:#777;
	}
	</style>
  <body>
    <!--Import navbar-->
    <?php include 'components/navbar.php'; ?>
    <!--Content here-->
		<div class="container-fluid" align="center" style="max-width:100%;margin-top:15px;font-weight:300;">
			<div class="row">
				<?php

				# Connect to database
				$con = mysqli_connect('localhost','ungkyrkja','ungkyrkja','ungkyrkja');
				if(!$con){
					die('Failed to connect to database: ' . mysqli_error($con));
				}
				$query = mysqli_query($con, "SELECT * FROM contact");
				mysqli_close($con);

				while ($rows = mysqli_fetch_array($queryusers)) {
					if ($rows['role'] == 1) {
						$admin = true;
					}
					if ($rows['role'] == 0) {
						$admin = false;

					}
				}

					#  Loop trough table
					while ($rows = mysqli_fetch_array($query)) {
						echo "<div class='col-md-3'>";
							echo "<div class='panel panel-default'>";
								echo "<div class='panel-body'>";
								if ($rows['user'] == $_COOKIE['auth-u'] && $admin == true) {
									echo "<a style='float:right;font-size:15px;' href='edit_kontakt.php?id=" . $rows['id'] . "'><span class='glyphicon glyphicon-cog' aria-hidden='true'></span></a>";
								}
									echo "<div><img class='kontakt-img' src='img/" . $rows['img'] . "'></div>";
									echo "<div><h3>" . $rows['name'] . "</h3></div>";
									echo "<div><h6>" . $rows['profession'] . "</h6></div>";
									echo "<div class='divider'></div>";
									echo "<div align='left'>";
										echo "<span class='glyphicon glyphicon-envelope'></span>&nbsp;&nbsp;<a href='mailto:" . $rows['email'] . "'>" . $rows['email'] . "</a><br>";
										echo "<p><span class='glyphicon glyphicon-earphone'></span>&nbsp;&nbsp;" . $rows['phone'] . "</p>";
									echo "</div>";
								echo "</div>";
							echo "</div>";
						echo "</div>";
						}
				?>
			</div>
		</div>
    <!--Import footer-->
    <?php include 'components/footer.php'; ?>

  </body>
</html>
