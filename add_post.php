<?php 
	include_once('resources/init.php'); 
	
	if ( isset($_POST['title'], $_POST['contents'], $_POST['category']) ) {
			
		$errors = array();

		$title 		= trim($_POST['title']);
		$contents 	= trim($_POST['contents']);
               

		if ( empty($title)) {
			$errors[] = 'You need to supply a title';
		} else if ( strlen($title) > 1000 ){
			$errors[] = 'The title can not be longer than 1000  characters';	
		}
		if ( empty($contents) ) {
			$errors[] = 'You need to supply some text';
		} else if ( strlen($contents) > 5000 ){
			$errors[] = 'The title can not be longer than 5000  characters';	
		}
                
		if ( ! category_exists('id', $_POST['category']) ){
			$errors[] = 'That category does not exist';	
		}

		if ( empty($errors) ) {
			add_post($title, $contents, $_POST['category']);

			$id = mysql_insert_id();

			header('location: index.php?id=' . $id);
			die();
		}
	}
?>
<!DOCTYPE html>
	<html lang="en">
<head>
	<title>Add Post</title>
	<?php include "includes/_head.php" ?>
</head>

<body>
<div class="container">
	<div class="row">
		<div class="span6 offset3">
			<h1>Add Post</h1>
				<?php include "includes/_nav.php" ?>
				<?php
				if ( isset($errors) && ! empty($errors) ) {
					echo '<div class="alert alert-block"><button type="button" class="close" data-dismiss="alert">&times;</button><ul><li>', implode('<li></li>', $errors), '</li></ul></div>';
				}
				?>
				<form action="" method="post" class="form-post">
					<div>
							
						<input type="text" name="title" class="form-title" maxlenght="1500" placeholder="Title" value="<?php if ( isset($_POST['title']) ) echo $_POST['title']; ?>">
					
					</div>

					<br>

					<div>
					
						<textarea name="contents" rows="12" cols="50" placeholder="Content" class="form-contents" ><?php if ( isset($_POST['contents']) ) echo $_POST['contents']; ?></textarea>
						<span class="countdown"></span>
					
					</div>
                                      
					<div>

						<br>

						<select name="category" class="form-category">
							<?php 
								foreach ( get_categories() as $category) {
									echo("<option value=\"" .  $category["id"] . "\">{$category['name']}</option>");
								?>
							<?php 
								}
							?>
						</select>
						<br>
						
					</div>
					<div>
						<input type="submit" value="Add Post" class="form-submit-button">
					</div>
				</form>
		</div>
	</div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript">
function updateCountdown() {
    // 140 is the max message length
    var remaining = 5000 - jQuery('.form-contents').val().length;
    jQuery('.countdown').text(remaining + ' characters remaining.');
}
</script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
    updateCountdown();
    $('.form-contents').change(updateCountdown);
    $('.form-contents').keyup(updateCountdown);
});
</script>
</script>
</body>
</html>