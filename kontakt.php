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
$person = $_GET['p'];

if ($person == 'Johannes') {
	$img = 'https://scontent.xx.fbcdn.net/hphotos-xpf1/v/t1.0-9/954725_847834458580329_5032481761037889532_n.jpg?oh=61e8af90d178c807a811634524ed7615&oe=562DC2CA';
	$jbb = 'Ungdomspastor';
	$tlf = '951 42 602';
	$eml = 'johannes.kleppe@time-kyrkja.no';
}

if ($person == 'Marion') {
	$img = 'img/standard.jpg';
	$jbb = 'Barne- og ungdomsarbeider';
	$tlf = '';
	$eml = 'marion.lende@time-kyrkja.no';
}

if ($person == 'Håkon') {
	$img = 'img/standard.jpg';
	$jbb = 'Formann og kyrkjetenar';
	$tlf = '';
	$eml = '';
}
?>
</div>

<!DOCTYPE html>
<html lang="no">
<head>
	<title>Ungkyrkja | Kontakt</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php //include "includes/_head.php" ?>
	<link rel="stylesheet" type="text/css" href="css/teststyle.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<link href="http://ungkyrkja.co.nf/logo.png" rel="icon" type="image/png"/>
</head>
	<body>

	<!-- Header -->
	<div style="width:100%;height:60px;background-color:#fff;">
	<a href="index.php"><img src="img/uk_logo.png" class="logo-img"></a>
		<a href="program.php" style="float:right;margin-right:40px;margin-top:14px;padding:5px;">Program</a>
		<a href="bilder.php" style="float:right;margin-right:40px;margin-top:14px;padding:5px;">Bilder</a>
		<a href="index.php" style="float:right;margin-right:40px;margin-top:14px;padding:5px;">Heim</a>
	</div>

	<section class="kontakt-container">
	<div align="center">
		<img src="<?php echo $img ?>">
	</div>
	<div align="center">
		<p style="width:300px;background-color:#fff;padding:20px;"><?php echo $jbb ?></p>
		<p style="width:300px;background-color:#fff;padding:20px;">Tlf: <?php echo $tlf ?></p>
		<p style="width:300px;background-color:#fff;padding:20px;">Email: <?php echo '<a href="email:' . $eml . '">' . $eml . '<a/>'; ?></p>
	</div>
	</section>


	<!-- Section 2 -->
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
	    		<li><a href="index.php">Info</a></li>
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
