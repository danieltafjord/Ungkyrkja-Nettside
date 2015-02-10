<?php
//launch if mobile 
function mobileDevice()
{
	$type = $_SERVER['HTTP_USER_AGENT'];
	if(strpos((string)$type, 'Windows Phone') != false || strpos((string)$type, 'iPhone') != false || strpos((string)$type, 'Android') != false)
	return true;
	else
	return false;
}
if(mobileDevice() == true)
	header('Location: ');
?>
<?php 
	include_once('resources/init.php');
	#$posts = ( isset($_GET['id']) ) ? get_posts($_GET['id']) : get_posts();
	$posts = get_posts(((isset($_GET['id'])) ? $_GET['id'] : null));
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<title>Web Dev</title>

	<?php include "includes/_head.php" ?>

</head>

<body>

	<div class="container">
        
        <div class="grid-layout">
			
			<div class=<?php if(isset($_GET['id'])){echo '"grid1-large"';}else {echo '"grid1"';} ?>>

				<?php include "includes/_nav.php" ?>
				
                <div class=<?php if(isset($_GET['id'])){echo '"post-container-large"';}else {echo '"post-container"';} ?> id="post">
				
					<br>

                    <?php

	                    foreach ( $posts as $post ) {
	                            if ( ! category_exists('name', $post ['name'] ) ){
	                                    $post['name'] = 'Uncategorised';
	                            }
					?>

					<div class="post">

						<button class=<?php if(isset($_GET['id'])){echo '"post-readall-large"';}else {echo '"post-readall"';} ?> onclick="javascript:location.href='index.php?id=<?php echo $post['post_id']; ?>'">READ ALL ...</button>						

						<h2><a href="index.php?id=<?php echo $post['post_id']; ?>" class=<?php if(isset($_GET['id'])){echo '"title-large"';}else {echo '"title"';} ?>><?php echo $post['title']; ?></a></h2>

						<small class="date"> Posted on <?php echo date('d-m-Y', strtotime($post['date_posted'])); ?> in 
							<a href="category.php?id=<?php echo $post['category_id']; ?>" class="category-post"><?php echo $post['name'];?></a>
						</small>

						<p class="post-content" id="content"><?php echo nl2br($post['contents']);?></p>               
						<br />
					
                    </div>

                    <!-- COMMENT SECTION -->
	                    <?php

	                    # Display comment section only if id is selected
	                    if (isset($_GET['id'])) {
	                    	echo "

		                    <div id='disqus_thread' style='padding:20px;'></div>
						    <script type='text/javascript'>
						        var disqus_shortname = 'mortensivertsen';
						        (function() {
						            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
						            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
						            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
						        })();
						    </script>
						    <noscript>Please enable JavaScript to view the <a href='http://disqus.com/?ref_noscript'>comments powered by Disqus.</a></noscript></div>

	                    	";
	                    }

	                    ?>

                    <!-- END COMMENT SECTION -->
					<?php
						}
					?>

				</div>

            </div><!-- END GRID1 -->

            <div class=<?php /*Removes div if selected id*/ if(isset($_GET['id'])){echo '"gridsocial-large"';}else {echo '"grid-social"';} ?> align="center">
				
				<a href="#"><img src="img/twitter.png" class="social-icons"></a>
				<a href="#"><img src="img/facebook.png" class="social-icons"></a>
				<a href="#"><img src="img/youtube.png" class="social-icons"></a>

			</div>
            
			<div class=<?php /*Removes div if selected id*/ if(isset($_GET['id'])){echo '"grid2-large"';}else {echo '"grid2"';} ?>>

				<a href="#"><img src="img/ad.png"8></a>

				<p style="font-size:10px; border-top:1px solid #d3d3d3;" align="center"><span style="font-family: arial;">&copy;</span> Copyright 2014 WEBDEV</p>

			</div>

		</div><!-- END GRID-LAYOUT -->

    </div><!-- END CONTAINER -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

</body>
</html>