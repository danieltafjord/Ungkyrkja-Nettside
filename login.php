<?php
    require_once('load.php');
    if ( $_GET['action'] == 'logout' ) {
        $loggedout = $j->logout();
    }
    $logged = $j->login('admin.php');
?>
<html>
	<head>
		<title>Sign in</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/form.css">
    <link rel="icon" type="image/png" href="logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=320, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; minimum-scale=1.0; user-scalable=0;"/>
    <meta name="viewport" content="width=device-width, target-densityDpi=medium-dpi"/>
	</head>

	<body>


		<?php if ( $logged == 'invalid' ) : ?>
				<p>
					The username password combination you entered is incorrect. Please try again.
				</p>
			<?php endif; ?>

		<div style="width:320px;background: #fff; padding: 20px; margin: 100px auto;">

			<h3 class="header-text">Sign in</h3>

			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<input type="text" name="username" placeholder="Username" /><br>
				<input type="password" name="password" placeholder="Password"/><br>
				<input type="submit" value="Sign in" />
			</form>
			<p><a href="register.php" style="float:left;font-size:14px;margin-top:-3px;">Sign up</a></p>
		</div>

	</body>
</html>
