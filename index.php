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
?>
<?php
	include_once('resources/init.php');
	#$posts = ( isset($_GET['id']) ) ? get_posts($_GET['id']) : get_posts();
	$posts = get_posts(((isset($_GET['id'])) ? $_GET['id'] : null));
	setlocale(LC_ALL, 'no');
?>
<div style="display:none;">
<?php
$postid = $_GET['id'];
?>
</div>

<!DOCTYPE html>
<html lang="no">
<head>
	<title>Ungkyrkja | Heim</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php //include "includes/_head.php" ?>
	<link rel="stylesheet" type="text/css" href="css/teststyle.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<link href="http://ungkyrkja.co.nf/logo.png" rel="icon" type="image/png"/>
</head>
	<body>

	<!-- Header -->
	<div style="width:100%;height:60px;background-color:#fff;">
	<a href=""><img src="img/uk_logo.png" class="logo-img"></a>
		<a href="program.php" style="float:right;margin-right:40px;margin-top:14px;padding:5px;">Program</a>
		<a href="bilder.php" style="float:right;margin-right:40px;margin-top:14px;padding:5px;">Bilder</a>
		<a href="" style="float:right;margin-right:40px;margin-top:14px;padding:5px;">Heim</a>
	</div>

	<!-- Section 1 -->
	<?php if(!$postid) { echo '  
	<section style="background-color:#f1f1f1;background-image:url(\'img/hero.png\');background-size:cover;background-attachment:fixed;min-height:500px;margin-top:-50px;">
		<div align="center">
			<!--<a href=""><img src="img/uk_logo.png" class="logo"></a>-->
<<<<<<< HEAD
			<h1 style="position:relative;top:100px;font-size:60px;color:#fff;text-shadow: 1px 1px 3px rgba(150, 150, 150, 0.88);">website</h1>
			<p style="position:relative;top:100px;font-size:22px;font-weight:bold;text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.88);color:#fff;max-width:600px;">For ungdom fr&aring; 8. klasse. Torsdagar kl.19.00-22.00. Interessegrupper, samlingar og ungdomsgudsteneste, kiosk, weekend og andre utflukter.</p>
=======
			<h1 style="position:relative;top:100px;font-size:60px;color:#444;text-shadow: 1px 1px 3px rgba(150, 150, 150, 0.88);">Ungkyrkja</h1>
			<p style="position:relative;top:100px;font-size:20px;color:#444;max-width:600px;">For ungdom fr&aring; 8. klasse. Torsdagar kl.19.00-22.00. Interessegrupper, samlingar og ungdomsgudsteneste, kiosk, weekend og andre utflukter.</p>
>>>>>>> origin/master
		</div>
	</section>
	';} ?>

	<!-- Section 2 -->
	<?php if(!$postid) { echo '
	<section align="center" style="margin: 100px 0px;" id="kontakt">

		<h1 style="font-size:32px;">Kontakt</h1>
		<hr width="1000px" align="center" class="divider">

		<div class="kontakt-con">
			<a href="kontakt.php?p=Johannes"><img src="https://scontent.xx.fbcdn.net/hphotos-xpf1/v/t1.0-9/954725_847834458580329_5032481761037889532_n.jpg?oh=61e8af90d178c807a811634524ed7615&oe=562DC2CA"></a>
			<p>Johannes Kleppe</p>
			<small>Ungdomspastor</small>
		</div>
		<div class="kontakt-con">
			<a href="kontakt.php?p=Marion"><img src="img/standard.jpg"></a>
			<p>Marion Lende</p>
			<small>Barne- og ungdomsarbeider</small>
		</div>
		<div class="kontakt-con">
			<a href="kontakt.php?p=Håkon"><img src="img/standard.jpg"></a>
			<p>H&aring;kon Espevik</p>
			<small>Formann og kyrkjetenar</small>
		</div>

	</section>
	';} ?>

	<!-- Section 4 -->
	<section>
	<div class="container" align="center" id="container">

	                <div class=<?php if(isset($_GET['id'])){echo '"post-container-large"';} else {echo '"post-container"';} ?> id="post">

						<br>

	                    <?php

		                    foreach ( $posts as $post ) {
		                            if ( ! category_exists('name', $post ['name'] ) ){
		                                    $post['name'] = 'Uncategorised';
		                            }
						?>

						<div class="post">

							<!--<button class=<?php if(isset($_GET['id'])){echo '"post-readall-large"';}else {echo '"post-readall"';} ?> onclick="javascript:location.href='index.php?id=<?php echo $post['post_id']; ?>'">READ ALL ...</button>-->

							<h2><a href="category.php?id=<?php echo $post['category_id']; ?>" class="category-post"><img src="<?php if($post['category_id'] == 13) { echo "img/samling.png";} elseif($post['category_id'] == 14) {echo "img/warning.png";} ?>" style="width:17px;"></a>
							<a href="index.php?id=<?php echo $post['post_id']; ?>" class=<?php if(isset($_GET['id'])){echo '"title-large"';}else {echo '"title"';} ?>><?php echo $post['title']; ?></a></h2>
							
							<small class="date"><img src="img/time.png" style="width:9px;margin-bottom:-1px;"> Postet <?php echo date('d / m / Y h:i', strtotime($post['date_posted'])); ?></small>

							<hr style="border:0;border-bottom:1px solid #e6e6e6;;"></hr>

							<p class="post-content" id="content"><?php echo nl2br($post['contents']);?></p>
							<br>

							<a href="index.php?id=<?php echo $post['post_id']; ?>#disqus_thread" style="float:left;padding:-20px;"><img src="img/comment.png" style="width:13px;"></a>

	                    </div>

	                    <!-- COMMENT SECTION -->
		                    <?php

		                    # Display comment section only if id is selected
		                    if (isset($_GET['id'])) {
		                    	echo "

			                    <div id='disqus_thread' style='padding:20px;'></div>
							    <script type='text/javascript'>
							        var disqus_shortname = 'ungkyrkjabryne';
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
						<!-- End Post -->

					</div>
	    </div></section><!-- END CONTAINER -->

	<!-- Section 5 -->
	<section style="background-color:#fff;min-height:200px;">
	<div style="padding-top:25px;border-bottom:1px solid #e5e5e5;" align="center">
	    	<ul>
	    		<li>&copy; Ungkyrkja Bryne</li>
	    	</ul>
		</div>
		<div style="padding-top:0px;" align="center">
	    	<ul>
	    		<li><a href="index.php">Heim</a></li>
	    		<li><a href="#kontakt">Kontakt</a></li>
	    		<li><a href="index.php">App</a></li>
	    		<li><a href="program.php">Program</a></li>
	    		<li><a href="admin.php">Admin</a></li>
	    	</ul>
		</div>
	</section>

	<script type="text/javascript">
		$(window).scroll(function(){

		  var wScroll = $(this).scrollTop();

		  $('.123').css({
		    'transform' : 'translate(0px, -'+ wScroll /40 +'%)'
		  });
	  	});

	$('a[href^="#"]').on('click', function(event) {

	    var target = $( $(this).attr('href') );

	    if( target.length ) {
	        event.preventDefault();
	        $('html, body').animate({
	            scrollTop: target.offset().top
	        }, 800);
	    }

	});

	</script>

 	</body>
</html>
