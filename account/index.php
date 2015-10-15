<?php
	include_once('login.php');

	if(!empty($_COOKIE['auth-logged'])) {
		$islogged = false;
	} else {
		$islogged = true;
	}
	if (!empty($_COOKIE['auth-u'])) {
?>
<!DOCTYPE html>
<html lang="no">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#009688">
	<title>Ungkyrkja | kontakt</title>
	<script src="../bower_components/webcomponentsjs/webcomponents-lite.min.js"></script>
	<link rel="import" href="../components/main-css.html">
</head>
	<body>

<?php include '../components/navbar.php'; ?>
<p>123</p>
<?php include '../components/footer.php'; ?>
<link rel="import" href="../components/main-scripts.html">

 	</body>
</html>

<?php } else { header('Location: ../index.php'); } ?>
