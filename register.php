<?php
	require_once('load.php');
	$j->register('login.php');
	//date_default_timezone_set('UTC');
?>

<html>
	<head>
		<title>Sign up</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/form.css">
	</head>

	<body>
		<div style="width:320px;height:500px;background: #fff; padding: 20px; margin: 100px auto;">

			<h3 class="header-text">Sign up</h3>

			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<input type="text" name="name" placeholder="Full name"/><br>
				<input type="text" name="username" placeholder="Username"/><br>
				<input type="password" name="password" placeholder="Password" />
        <a href="http://generate.co.nf/password" style="font-size:10px;color:#333;float:right;" target="_blank">Generate password</a><br>
				<input type="text" name="email" placeholder="Email"/><br>
				<input type="hidden" name="date" value="<?php echo date("Y-m-d"); ?>" /><br>
				<input type="submit" name="submit" value="Sign up">
			</form>
			<a href="login.php" style="float:left;font-size:14px;margin-top:-3px;">Sign in</a>
		</div>
	</body>
</html>

