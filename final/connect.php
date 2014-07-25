<?php

$conn_string = "host=ec2-54-204-24-202.compute-1.amazonaws.com port=5432 dbname=dc2h854dssr07h user=xdqaaikikvbrpj password=TOAra6WPOCUps0jlGtMY5u0uBW";
// die("ok");
$dbconn = pg_connect($conn_string);

if (!$dbconn) {
  die("SERVER_CONNECTION_ERROR");
}
?>