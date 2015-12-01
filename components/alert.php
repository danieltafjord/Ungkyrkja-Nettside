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
    case '1004':
      $alert = 'Feilmelding slettet.';
      $alert_type = 'success';
      break;
    case '1005':
      $alert = 'Bruker slettet.';
      $alert_type = 'success';
      break;
    case '1006':
      $alert = 'Bruker deaktivert.';
      $alert_type = 'success';
      break;
    case '1007':
      $alert = 'Bruker aktivert.';
      $alert_type = 'success';
      break;
    case '1008':
      $alert = 'Denne brukeren er deaktivert.';
      $alert_type = 'danger';
      break;
    case '1009':
      $alert = 'Du må logge inn for å se denne siden.';
      $alert_type = 'danger';
      break;
    case '1010':
      $alert ='Kunne ikke koble til database.';
      $alert_type = 'danger';
      break;
    case '1011':
      $alert ='Passord endret.';
      $alert_type = 'success';
      break;
    case '1012':
      $alert ='Feil passord.';
      $alert_type = 'danger';
      break;
    case '1013':
      $alert ='Bruker endret.';
      $alert_type = 'success';
      break;
    case '1014':
      $alert ='Tilbakemelding slettet.';
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
        echo htmlentities($alert);
      ?>
    </p>
  </div>
  <?php
}
?>
