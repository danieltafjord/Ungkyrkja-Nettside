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
	<title>Ungkyrkja | Account</title>
	<script src="../bower_components/webcomponentsjs/webcomponents-lite.min.js"></script>
	<link rel="import" href="../components/header-imports.html">
</head>
	<body>
		<style>
		.leftside-container {
			max-width: 400px;
			background-color: #f4f4f4;
			padding: 30px;
			position: relative;
			margin: 50px;
		}
		</style>

<?php
$site_location = '/account/index.php';
 include '../components/navbar.php';
?>

<div class="leftside-container">
	<?php echo $_COOKIE['auth-u']; ?>
</div>

<div class="leftside-container">
	<h2 style="margin:0;margin-bottom:10px;">Last opp bilder her</h2>
	<form enctype="multipart/form-data" action="upload.php" method="POST">
		<div class="form-group">
			<label>Velg filer her: </lable>
			<input name="upload[]" type="file" multiple="multiple" style="width:100%;" />
		</div>
		<div class="form-group" style="width:100%;">
			<label>Description: </lable><br>
			<textarea name="desc" class="form-control" type="text" multiple="multiple"></textarea>
		</div>
		<div class="form-group">
			<button type="submit" value="Upload" class="btn btn-default" style="width:100%;">submit</button>
		</div>
	 </form>
</div>

<?php include '../components/footer.php'; ?>

 	</body>
</html>

<?php } else { header('Location: ../index.php'); } ?>
