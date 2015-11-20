<?php
namespace Project\Error;

/**
 * This class makes sure every error is logged into a database.
 */
class error
{
  public static function report($page, $message, $type, $ip, $time) {
    # Connecting to databse
    $con = mysqli_connect('localhost','ungkyrkja','ungkyrkja','ungkyrkja');

    $t = date('Y-m-d h:i:sa');

    # Check if a row allready contains the ip and message of an error
    $checkrow = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM error WHERE ip = '$ip' AND message = '$message'"));
    # and if it does, add 1 to count
    if ($checkrow) {
      $addtocount = $checkrow['count'] + 1;
      # Add 1 to count
      mysqli_query($con, "UPDATE error SET count='$addtocount', time='$t' WHERE ip = '$ip' AND message = '$message'");
      # If it dosn't exist inesrt error into databse
    } else {
      $sql = mysqli_query($con, "INSERT INTO error (page, message, type, ip, time) VALUES ('$page', '$message', '$type', '$ip', '$time')");
      if (!$sql) {
        echo "Error: could not log this error!";
      }
    }
  }
}


?>
