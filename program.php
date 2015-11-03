<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="57x57" href="icon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="icon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="icon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="icon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="icon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="icon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="icon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="icon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="icon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="icon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="icon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="icon/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#222">
    <meta name="msapplication-TileImage" content="icon/ms-icon-144x144.png">
    <meta name="theme-color" content="#222">
    <title>Program | Ungkyrkja</title>
    <script src="bower_components/webcomponentsjs/webcomponents-lite.min.js"></script>
    <link rel="import" href="components/header-imports.html">
		<link rel="stylesheet" type="text/css" href="css/program.css">
    <!--Element imports-->
    <link rel="import" href="bower_components/paper-fab/paper-fab.html">
    <link rel="import" href="bower_components/iron-icons/iron-icons.html">
    <link rel="import" href="bower_components/iron-icon/iron-icon.html">
    <link rel="import" href="bower_components/paper-icon-button/paper-icon-button.html">
    <link rel="import" href="bower_components/paper-card/paper-card.html">
    <link rel="import" href="bower_components/paper-button/paper-button.html">
  </head>
  <body>
    <!--Import navbar-->
    <?php include 'components/navbar.php'; ?>
		<?php
			include_once('account/login.php');

			if(empty($_COOKIE['auth-logged'])) {
				$islogged = false;
			} else {
				$islogged = true;
			}

			# Connect to database
			$conn = new mysqli("localhost","ungkyrkja","ungkyrkja","ungkyrkja");
      if($conn->connect_errno){
        die("Could not connect to database!" . $conn->connect_error);
      }
			$program = $conn->query("SELECT * FROM uk_program ORDER BY date ASC");
			$user = false;
			if($islogged){
  			$user = $_COOKIE['auth-u'];
  			$user = $conn->query("SELECT user, role FROM users WHERE user LIKE $user");
        if($conn->error){
          $user = false;
        }
        else{
          $user = $user->fetch_array();
        }
			}
			$conn->close();
		?>

		<?php
			$role = 0;
			if($user){
				$role = (int) $user['role'];
				if($role > 0){
					?>
          <a href="edit_program.php" class="fab-main"><paper-fab icon="add"></paper-fab></a>
					<?php
				}
			}
		?>

		<!--Main bit-->
		<div class="container-fluid">

			<div class="row">
			<?php
				$dateFormatter = new IntlDateFormatter('no_NB.utf-8', IntlDateFormatter::FULL, IntlDateFormatter::LONG);

				function createEventPanel($id, $title, $content, $date, $enddate, $columns, $dateFormatter, $role){
					//Create panel with event data
					?>
					<div class="<?php echo "event-card container-fluid col-sm-" . $columns;?>" id="<?php echo $id; ?>">
            <paper-card heading="<?php echo $title;?>">
              <div class="card-content">
                <iron-icon icon="event"></iron-icon>
                <p><?php echo "Veke: " . $date->format("W"); ?></p>
                <iron-icon icon="schedule"></iron-icon>
                <p><?php
                  $dateFormatter->setPattern("EEEE dd. MMMM, HH:mm");
                  if($date->format("d.m.Y") == $enddate->format("d.m.Y")){
                    echo $dateFormatter->format($date) . " - " .$enddate->format("H:i");
                  }
                  else{
                    echo $dateFormatter->format($date) . " - " .$dateFormatter->format($enddate);
                  }
                  ?></p>
                  <?php if($content != ""){ ?>
                  <iron-icon icon="label"></iron-icon>
                  <p><?php echo $content;?></p>
                  <?php } ?>
              </div>
              <?php if($role > 0){ ?>
              <div class="card-actions">
                <paper-icon-button class="btn-edit" icon="create"></paper-icon-button>
              </div>
              <?php } ?>
            </paper-card>
					</div>
				<?php
				}

				$month="";
				$row = 0;

				while($rows = $program->fetch_array()){
					$id = $rows['id'];
					$title = $rows['title'];
					$content = $rows['content'];
					$date = new DateTime($rows['date']);
					$enddate = new DateTime($rows['enddate']);

					//Create a divider if there is a new month
					if($month != $date->format("Ym")){
						$row = 0;
						?>
			</div>
				<div class="month_divider">
					<p><?php
						$dateFormatter->setPattern("MMMM Y");
						echo $dateFormatter->format($date);
						?></p>
					<hr>
				</div>
			<div class="row">
					<?php
					}
					//Create a wide panel if there is more than 500 chars in the content
					$columns = 4;
					if(strlen($content) >= 500){
						$columns = 8;
					}
					//Check if the row has enough space
					if($row + $columns <= 12){
						$row += $columns;
						createEventPanel($id, $title, $content, $date, $enddate, $columns, $dateFormatter, $role);
					}
					//Else, create a new row
					else{
						$row = 0;
						?>
			</div>
			<div class="row">
						<?php
						createEventPanel($id, $title, $content, $date, $enddate, $columns, $dateFormatter, $role);
					}
					//Update month after every cycle
					$month = $date->format("Ym");
				}
			?>
			</div>
		</div>
    <!--Import footer-->
    <?php include 'components/footer.php'; ?>

		<script src="js/program.js"></script>
  </body>
</html>
