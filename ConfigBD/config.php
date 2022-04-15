<?php  

	//Configuracion de la base de datos

	
	$mysqli = new mysqli("localhost","root","","assemblexbd");

if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
	

?>