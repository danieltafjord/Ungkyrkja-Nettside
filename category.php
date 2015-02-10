<?php 
include_once('resources/init.php');

$posts = get_posts(null, $_GET['id']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Hello world blog</title>
	<?php include "includes/_head.php" ?>
</head>

<body>
	<div class="container">
	        
	        <div class="grid-layout">
				
				<div class="grid1">

					<?php include "includes/_nav.php" ?>
					
	                <div class="post-container" id="post">
					
						<br>

	                    <?php

		                    foreach ( $posts as $post ) {
		                            if ( ! category_exists('name', $post ['name'] ) ){
		                                    $post['name'] = 'Uncategorised';
		                            }
						?>

						<div class="post">

							<h2><a href="index.php?id=<?php echo $post['post_id']; ?>" class="title"><?php echo $post['title']; ?></a></h2>

							<small class="date"> Posted on <?php echo date('d-m-Y', strtotime($post['date_posted'])); ?> in 

								<a href="category.php?id=<?php echo $post['category_id']; ?>" class="category-post"><?php echo $post['name'];?></a>
							
							</small>
							
							<p class="post-content"><?php echo nl2br($post['contents']);?></p>

							<div class="post-functions">

							</div>
	                                                                      
							<br />
						
	                    </div>
						
						<?php
							}
						?>

					</div>

	            </div><!-- END GRID1 -->

	            <div class="grid-social" align="center">
					
					<a href="#"><img src="img/twitter.png" class="social-icons"></a>
					<a href="#"><img src="img/facebook.png" class="social-icons"></a>
					<a href="#"><img src="img/youtube.png" class="social-icons"></a>

				</div>
	            
				<div class="grid2">

					<p style="font-size:10px;" align="center"><span style="font-family: arial;">&copy;</span> Copyright 2014 WEBDEV</p>

				</div>

			</div><!-- END GRID-LAYOUT -->

	</div><!-- END CONTAINER -->

	</body>
	</html>