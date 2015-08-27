<?php
	# Connecting to Database
	$con = mysqli_connect('localhost', 'root', '', 'blog');

	# Retrive images
	$get_img = mysqli_query($con, 'SELECT * FROM bilder');
?>
<div style="display:none;">
<?php
$postid = $_GET['img'];
?>
</div>

<!DOCTYPE html>
<html lang="no">
<head>
	<title>Ungkyrkja | Heim</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
	<?php //include "includes/_head.php" ?>
	<link rel="stylesheet" type="text/css" href="css/teststyle.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<link href="http://ungkyrkja.co.nf/logo.png" rel="icon" type="image/png"/>
</head>
	<body>

	<!-- Header -->
	<div style="width:100%;height:60px;background-color:#fff;">
	<a href="index.php"><img src="img/uk_logo.png" class="logo-img"></a>
		<a href="index.php" style="float:right;margin-right:40px;margin-top:13px;padding:5px;">Heim</a>
		<a href="" style="float:right;margin-right:40px;margin-top:13px;padding:5px;">Bilder</a>
		<a href="#" style="float:right;margin-right:40px;margin-top:13px;padding:5px;">Home</a>
	</div>

	<!-- Section 4 -->
	<section>
		<div class="container" align="center" id="container">
		<div style="width:1150px;">
		<section id="photos">
			<?php
				# Displaying images
			if (!$postid) {

				while($img = mysqli_fetch_array($get_img,MYSQLI_ASSOC)){
					$img_img = $img['img'];
					
					echo "<div style='display:inline;'>";
					echo "<a href='bilder.php?img=" . $img_img . "'><img style='max-width:500px;' src='bilder/" . $img_img . "'></a>";
					echo "</div>";
				}
			}
			?>
		</section>
		<?php 
			if($postid) {
				echo "<img id='getimg' src='bilder/" . $postid . "' style='max-width:750px;margin-top:50px;'>";
				echo "<br><br><br><br><br>";
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
			</div>
		</div>
	</section><!-- END CONTAINER -->

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
	    		<li><a href="index.php">Kontakt</a></li>
	    		<li><a href="index.php">Info</a></li>
	    		<li><a href="index.php">App</a></li>
	    		<li><a href="index.php">Program</a></li>
	    		<li><a href="admin.php">Admin</a></li>
	    	</ul>
		</div>
	</section>

	</body>
</html>
