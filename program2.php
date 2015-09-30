<?php
	$con = mysqli_connect("localhost","ungkyrkja","ungkyrkja","ungkyrkja");
	$query = mysqli_query($con, "SELECT * FROM uk_program ORDER BY date ASC");
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
	<title>Ungkyrkja | Program</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php //include "includes/_head.php" ?>
	<link rel="stylesheet" type="text/css" href="css/teststyle.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/program.css">
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

	<!--Main bit-->
	<div class="container-fluid">
		<div class="jumbotron">
			<h1>Program</h1>
		</div>
		<div class="row">
		<?php
			$dateFormatter = new IntlDateFormatter('no_NN', IntlDateFormatter::SHORT, IntlDateFormatter::SHORT);
			
			function createEventPanel($id, $title, $content, $date, $enddate, $dateFormatter){
				//Create panel with event data
				?>
				<div class="<?php if(strlen($content) < 300){echo "col-sm-4";}
					else{echo "col-sm-8";}?>" id="<?php echo $id; ?>">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3><?php echo $title;?></h3>
						</div>
						<div class="panel-body">
							<div class="event_data">
								<div>
									<img src="img/ic_event_black.png">
									<p><?php echo "Veke: " . $date->format("W"); ?></p>
								</div>
								<div>
									<img src="img/ic_access_time_black.png">
									<p><?php
										$dateFormatter->setPattern("EEEE dd. MMMM, HH:mm");
										if($date->format("d.m.Y") == $enddate->format("d.m.Y")){
											echo $dateFormatter->format($date) . " - " . $enddate->format("H:i");
										}
										else{
											echo $dateFormatter->format($date) . " - <br>" . $dateFormatter->format($enddate);
										}
										?></p>
								</div>
								<div>
									<?php if($content != ""){
										?>
										<img src="img/ic_label_black.png">
										<p><?php echo $content;?></p>
										<?php
									}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php		
			}
		
			$month="";
			
			while($rows = mysqli_fetch_array($query)){
				$id = $rows['id'];
				$title = $rows['title'];
				$content = $rows['content'];
				$date = new DateTime($rows['date']);
				$enddate = new DateTime($rows['enddate']);
			
				//Print out stuff
				if($month == $date->format("m")){
					
					//Create panel with event data
					createEventPanel($id, $title, $content, $date, $enddate, $dateFormatter);		
				}
				else{
					//If there is a new month, create a divider
					?>
		</div>			
			<div class="month_divider">
				<p><?php 
					$dateFormatter->setPattern("MMMM");
					echo $dateFormatter->format($date);
					?></p>
				<hr>
			</div>
		<div class="row">
				<?php
					createEventPanel($id, $title, $content, $date, $enddate, $dateFormatter);
				}
				//Update month after every cycle
				$month = $date->format("m");
				
			}
		?>
		</div>
	</div>

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
