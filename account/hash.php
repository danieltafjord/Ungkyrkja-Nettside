<?php

namespace Project\Helpers;

class Hash {
  public static function create($hashValue) {
    return password_hash($hashValue, PASSWORD_BCRYPT, ['cost' => 10]);
  }
  public static function check($hashValue, $hash) {
    return password_verify($hashValue, $hash);
  }
}

?>
