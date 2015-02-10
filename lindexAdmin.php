<?php 

include_once('resources/init.php');

$posts = get_posts(((isset($_GET['id'])) ? $_GET['id'] : null));

?>

<html>
	<head>
		<title>Members Area</title>
	</head>
	<?php include "includes/_head.php" ?>
	<body>
	

		<div class="container" style="width:90%;">
        
        <div class="grid-layout">

            <div class="grid1">

				<?php include "adminNav.php" ?>
				
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

							<a href="category.php?id=<?php echo $post['category_id']; ?>" class="category-post"><?php echo $post['name'];?> - </a>

							<a href="delete_post.php?id=<?php echo $post["post_id"]; ?>"> Delete this post - </a>
							<a href="edit_post.php?id=<?php echo $post['post_id']; ?>"> Edit post</a>
						
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
            
            <div align="center">
         

            </div>
            
			<div class="grid2">

				<p style="font-size:10px;" align="center"><span style="font-family: arial;">&copy;</span> Copyright 2014 WEBDEV <a href="l_login.php?action=logout" style="font-size:11px;"> -  Logout</a></p>

			</div>

		</div><!-- END GRID-LAYOUT -->

    </div><!-- END CONTAINER -->
	</body>
</html>