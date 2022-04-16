<?php
include '../../ConfigBD/config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
	header('location:../../Public/login.php');
}else{
	
}

$data = json_decode(file_get_contents("http://localhost:57144/api/values"),true);

$mostSellings = json_decode(file_get_contents("http://localhost:57144/api/getMostSellings"),true);
$totalOrders = json_decode(file_get_contents("http://localhost:57144/api/totalOrders"),true);
$totalProductsStock = json_decode(file_get_contents("http://localhost:57144/api/totalProductsStock"),true);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ususarios</title>
	<!--Fuente-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" type="text/css" href="../../css/admin_style.css">
</head>
<body>
	<?php
	include 'admin_header.php';
	?>

<?php
   echo '<p>'.$data.'</p>';
   echo '<br/>';
   echo '<br/>';
   foreach ($mostSellings as $key => $value) {
     
          echo $value.'<br/>';
      
   }
   echo '<br/>';
   echo '<br/>';
   var_dump($mostSellings);

   echo '<br/>';
   echo '<p>Total Ordenes:'.$totalOrders.'</p>';

   echo '<br/>';
   echo '<p>Total Productos en stock:'.$totalProductsStock.'</p>';


?>

	

	<script type="text/javascript" src="../../js/admin_script.js"></script>
</body>
</html>