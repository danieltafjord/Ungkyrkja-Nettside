<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ungkyrkja</title>
    <script src="bower_components\webcomponentsjs\webcomponents-lite.min.js"></script>
    <link rel="import" href="compontents\main-css.html">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="css/index.css" rel="stylesheet">
  </head>
  <body>
    <!--Import navbar-->
    <?php include 'compontents\navbar.php'; ?>
		<?php
	include_once('resources/init.php');
	include_once('account/login.php');

	if(!empty($_COOKIE['auth-logged'])) {
		$islogged = false;
	} else {
		$islogged = true;
	}

	$posts = get_posts(((isset($_GET['id'])) ? $_GET['id'] : null));
	setlocale(LC_ALL, 'no');
?>

<div style="display:none;">
<?php
$postid = $_GET['id'];
?>
</div>

<div class="jumbotron">
	<div class="container">
		<h1>Website</h1>
		<p>For ungdom fr&aring; 8. klasse. Torsdagar kl.19.00-22.00. Interessegrupper, samlingar og ungdomsgudsteneste,
		 kiosk, weekend og andre utflukter.</p>
	</div>
</div>
<!-- Section 1 -->
	<section>
	<div align="center" id="container">

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

				<h2><a href="category.php?id=<?php echo $post['category_id']; ?>" class="category-post"><img src="<?php if($post['category_id'] == 13) { echo "img/samling.png";} elseif($post['category_id'] == 14) {echo "img/warning.png";} ?>style="width:17px;"></a>
				<a href="index.php?id=<?php echo $post['post_id']; ?>" class=<?php if(isset($_GET['id'])){echo '"title-large"';}else {echo '"title"';} ?>><?php echo $post['title']; ?></a></h2>

				<small class="date"><img src="img/time.png" style="width:9px;margin-bottom:-1px;"> Postet <?php echo date('d / m / Y h:i', strtotime($post['date_posted'])); ?></small>

				<hr style="border:0;border-bottom:1px solid #e6e6e6;;"></hr>

				<p class="post-content" id="content"><?php echo nl2br($post['contents']);?></p>
				<br>

	    </div>

			<?php
				}
				?>
			<!-- End Post -->

			</div>
	  </div>
	</section><!-- END CONTAINER -->

<!-- Section 2 -->
	<section style="margin: 100px 0px;" id="program-next">

		<h1 align="center" style="font-size:32px;">Neste samling</h1>
		<hr width="1000px" align="center" class="divider">
		<?php

		$conn = new mysqli("localhost", "ungkyrkja", "ungkyrkja", "ungkyrkja");
		$query = false;
		if($conn){
			$query = $conn->query("SELECT * FROM uk_program ORDER BY date ASC");
		}
		else{
			//Connection to the database has failed
		}
		$conn->close();
		$dateFormatter = new IntlDateFormatter('no_NB.utf-8', IntlDateFormatter::FULL, IntlDateFormatter::LONG);
		if($query){
			while($rows = $query->fetch_array()){
				$id = $rows['id'];
				$title = $rows['title'];
				$content = $rows['content'];
				$date = new DateTime($rows['date']);
				$enddate = new DateTime($rows['enddate']);
				$currentDate = new DateTime();
				if($date >= $currentDate){
					//Create panel with event data
			?>
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3 col-lg-4 col-lg-offset-4" id="<?php echo $id; ?>">
					<div class="event-panel panel panel-default">
						<div class="panel-heading withripple">
							<button type="button" class="btn-edit btn btn-primary btn-fab btn-raised hidden"><i class="material-icons md-light">edit</i></button>
							<h3><?php echo $title;?></h3>
						</div>
						<div class="panel-body">
							<div class="event_data">
								<div>
									<i class="material-icons md-dark">event</i>
									<p><?php echo "Veke: " . $date->format("W"); ?></p>
								</div>
								<div>
									<i class="material-icons md-dark">access_time</i>
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
										<i class="material-icons md-dark">label</i>
										<p><?php echo $content;?></p>
										<?php
									}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
					break;
				}
			}
		}
		?>
		</section>
    <!--Import footer-->
    <?php include 'compontents\footer.php'; ?>

    <link rel="import" href="compontents\main-scripts.html">
		<script src="js/program.js"></script>
  </body>
</html>
