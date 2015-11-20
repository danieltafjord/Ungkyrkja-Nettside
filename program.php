<?php
include_once('account/login.php');
$islogged = false;
if(!empty($_COOKIE['auth-logged'])) {
$islogged = true;
}
?>
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
    <style media="screen">
    .box {
      margin-top: 15px;
      margin-bottom: 15px;
      background-color: #fff;
      padding:20px;
      border: 1px solid #e3e3e3;
      border-radius: 3px;
    }
    .month_divider hr{
      background-color: #666;
      height: 1px;
    }
    .event-card .content p{
      font-size: 16px;
      overflow: hidden;
    }
    .event-card .content i{
      float: left;
      margin-right: 8px;
    }
    .fab-main{
      width: 60px;
      height: 60px;
      border-radius: 100%;
      border: none;
      background-color: #F44336;
      box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    }
    .fab-main i{
      vertical-align: middle;
    }
    .btn-icon{
      border: none;
      background-color: #fff;
    }
    .modal-footer form{
      display: inline-block;
    }
    </style>
  </head>
  <body>
    <!--Import navbar-->
    <?php
      $site_location = '/program.php';
      include 'components/navbar.php';
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

			$role = 0;
			if($user){
				$role = (int) $user['role'];
				if($role > 0){
					?>
          <a href="edit_program.php"><button type="button" class="fab-main"><i class="material-icons md-light">add</i></button></a>
					<?php
				}
			}

      $alert = '';
      if(isset($_GET['alert'])){
        switch ($_GET['alert']) {
          case '9001':
            $alert = 'Hendelsen ble lagret.';
            break;

          case '9002':
            $alert = 'Hendelsen ble oppdatert.';
            break;

          case '9003':
            $alert = 'Hendelsen ble slettet.';
            break;
        }
      }
      if($alert != ''){
        ?>
        <div class="alert alert-success">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <p>
            <?php
              echo $alert;
            ?>
          </p>
        </div>
        <?php
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
					<div class="<?php echo "event-card col-md-" . $columns;?>" id="<?php echo $id; ?>">
            <div class="box">
              <h3><?php echo $title;?></h3>
              <hr>
              <div class="content">
                <i class="material-icons">event</i>
                <p><?php echo "Veke: " . $date->format("W"); ?></p>
                <i class="material-icons">schedule</i>
                <p>
                  <?php
                  $dateFormatter->setPattern("EEEE dd. MMMM, HH:mm");
                  if($date->format("d.m.Y") == $enddate->format("d.m.Y")){
                    echo $dateFormatter->format($date) . " - " .$enddate->format("H:i");
                  }
                  else{
                    echo $dateFormatter->format($date) . " - "  .$dateFormatter->format($enddate);
                  }
                  ?>
                </p>
                <?php if($content != ""){ ?>
                  <i class="material-icons">label</i>
                  <p><?php echo $content;?></p>
                  <?php } ?>
                </div>
                <?php if($role > 0){ ?>
                  <hr>
                  <div class="actions">
                    <button class="btn-icon btn-edit"> <i class="material-icons">create</i></button>
                    <button class="btn-icon btn-delete"> <i class="material-icons" data-toggle="modal"  data-target="#deleteModal">delete</i></button>
                  </div>
                  <?php } ?>
            </div>
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

    <div id="deleteModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Slett</h4>
          </div>
          <div class="modal-body">
            <p>Er du sikker? Dette kan ikke gjøres om.</p>
          </div>
          <div class="modal-footer">
            <form id="deleteForm" action="edit_program.php" method="post">
              <button id="deleteButton" class="btn btn-danger" type="submit" name="delete">Slett</button>
              <input id="deleteId" hidden type="text" name="id" value="">
            </form>
            <button class="btn btn-default" type="button" data-dismiss="modal">Lukk</button>
          </div>
        </div>
      </div>
    </div>

    <!--Import footer-->
    <?php include 'components/footer.php'; ?>

		<script>
    var main = function(){
    	$('.event-panel').click(function(){
    		//Highlight the clicked element
    		if($(this).hasClass('panel-primary')){
    			$('.event-panel').removeClass('panel-primary').addClass('panel-default');
    			$('.btn-edit').addClass('hidden');
    		}
    		else{
    			$('.event-panel').removeClass('panel-primary').addClass('panel-default');
    			$(this).removeClass('panel-default').addClass('panel-primary');
    			$('.btn-edit').addClass('hidden');
    			$('.btn-edit', this).removeClass('hidden');
    		}

    		//show the edit button in the clicked element

    	});
    	$('.btn-edit').click(function(){
    		var url = window.location.href;
    		var id = $(this).closest('div[id]').attr('id');
    		url = 'edit_program.php' + "?id=" + id;
    		//Redirect to the edit-program page
    		window.location.assign(url);
    	});
      $('.btn-delete').click(function(){
        var id = $(this).closest('div[id]').attr('id');
        $('#deleteId').attr('value', id);
      })
    }

    $(document).ready(main);
    </script>
  </body>
</html>
