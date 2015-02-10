<?php
// Config info
// DB info
define("DB_NAME","blog");
// DB username
define("DB_USER","root");
// DB password
define("DB_PASS","");
// SALTING*
/*
    In cryptography, a SALT is random data that
    is used as an additional input to a one-way
    function that hashes a password or passphrase.
*/
define('SITE_KEY',         'bDBLp6+8yq.O!-d.Voh~:+[9vl-mXc&M8VOMvTz:48^ag%YI=590Q)$MX5DYJP4_');
define('NONCE_SALT',        'Y3u]5SI@3ELz?^)rP7/eLA+3kn0BHTYv-t;1_W+-Bim{^0Eekt~9dF7+Jp#:|En(');
define('AUTH_SALT',        'wtz3W+F j`3GVBrrP}!zq$K-Zt4|_Ln3V D/Qe5JNAJDrqbx&fW`7>yL}:fo8FoB');
error_reporting(E_ALL ^ E_NOTICE);
?>