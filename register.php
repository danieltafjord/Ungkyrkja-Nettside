<?php 
	include_once('resources/init.php'); 
	
	$post = get_posts($_GET['id']);

	if ( isset($_POST['title'], $_POST['contents'], $_POST['category']) ) {
			//var_dump($_POST);
		$errors = array();

		$title 		= trim($_POST['title']);
		$contents 	= trim($_POST['contents']);
                

		if ( empty($title)) {
			$errors[] = 'You need to supply a title';
		} else if ( strlen($title) > 255 ){
			$errors[] = 'The title can not be longer than 255  characters';	
		}
		if ( empty($contents) ) {
			$errors[] = 'You need to supply some text';
		}
                
		if ( ! category_exists('id', $_POST['category']) ){
			$errors[] = 'That category does not exist';	
		}

		if ( empty($errors) ) {
			edit_post($_GET['id'], $title, $contents, $_POST['category']);
			#echo json_encode($post);
			header('location: index.php?id=' . $post[0]['post_id']);
			
			die();
		}
	}
?>
<?php
	require_once('load.php');
	$j->register('login.php');
?>

<html>
	<head>
		<title>Sign up</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>

	<body>
		<div style="width:320px;background: #fff; padding: 20px; margin: 100px auto;">

			<h3 class="header-text">Sign up</h3>

			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<input type="text" name="name" placeholder="Full name"/><br>
				<input type="text" name="username" placeholder="Username"/><br>
				<input type="password" name="password" placeholder="Password" />
        <a href="http://generate.co.nf/password" style="font-size:10px;color:#333;float:right;" target="_blank">Generate password</a><br>
				<input type="text" name="email" placeholder="Email"/><br>
				<input type="hidden" name="date" value="<?php echo time(); ?>" /><br>
				<input type="submit" value="Sign up" />
			</form>
			<a href="login.php" style="float:left;font-size:14px;margin-top:-3px;">Sign in</a>
		</div>
	</body>
</html>
<?php } ?>
