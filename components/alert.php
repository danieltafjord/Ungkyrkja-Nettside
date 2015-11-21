<?php
if(isset($_GET['alert'])){
  switch ($_GET['alert']) {
    case '1001':
      $alert = 'Du har blitt registrert.';
      $alert_type = 'success';
      break;
    case '1002':
      $alert = 'Du har blitt logget inn.';
      $alert_type = 'success';
      break;
    case '1003':
      $alert = 'Du har blitt logget ut.';
      $alert_type = 'success';
      break;
  }
}

if($alert != '' && $alert_type != ''){
  ?>
  <div class="alert alert-<?php echo $alert_type; ?>">
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
