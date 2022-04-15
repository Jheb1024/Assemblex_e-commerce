<?php
include '../../ConfigBD/config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
	header('location:../../Public/login.php');
}else{
	
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Administrador</title>
	<!--Fuente-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" type="text/css" href="../../css/admin_style.css">
</head>
<body>
	<?php
	include 'admin_header.php';
	?>
	<section class="dashboard">
		<h1 class="title">Panel de administración</h1>
		<div class="box-container">
			<div class="box">
				
				<?php
				$total_pendings = 0;
				$sql = "SELECT total_price FROM `orders` WHERE payment_status = 'pending'";
				$select_pending  = $mysqli->query($sql);

				if ($select_pending->num_rows > 0 ){
					while ($fetch_pendings = $select_pending->fetch_assoc()) {
						$total_price = $fetch_pendings['total_price'];
						$total_pendings += $total_price;
					};
				};
				?>
				<h3><?php echo $total_pendings; ?></h3>
				<p>Total Pendientes</p>
			</div>
			<div class="box">
				
				<?php
				$total_completed = 0;
				$sql = "SELECT total_price FROM `orders` WHERE payment_status = 'completed'";
				$select_completed  = $mysqli->query($sql);

				if ($select_completed->num_rows > 0 ){
					while ($fetch_completed = $select_completed->fetch_assoc()) {
						$total_price = $fetch_completed['total_price'];
						$total_completed += $total_price;
					};
				};
				?>
				<h3><?php echo $total_completed; ?></h3>
				<p>Completados</p>
			</div>

			<div class="box">
				<?php
					$select_orders = $mysqli->query("SELECT * FROM `orders`");
					$number_of_orders = $select_orders->num_rows;				
				?>
				<h3><?php echo $number_of_orders ?></h3>
				<p>Órdenes</p>
			</div>

			<div class="box">
				<?php
					$select_products = $mysqli->query("SELECT * FROM `products`");
					$number_of_products = $select_products->num_rows;				
				?>
				<h3><?php echo $number_of_products ?></h3>
				<p>Productos agregados</p>
			</div>

			<div class="box">
				<?php
					$select_users = $mysqli->query("SELECT * FROM `users` WHERE user_type = 'user'");
					$number_of_users = $select_users->num_rows;				
				?>
				<h3><?php echo $number_of_users ?></h3>
				<p>Usuarios</p>
			</div>
			<div class="box">
				<?php
					$select_account = $mysqli->query("SELECT * FROM `users`");
					$number_of_account = $select_account->num_rows;				
				?>
				<h3><?php echo $number_of_account ?></h3>
				<p>Cuentas</p>
			</div>
			<div class="box">
				<?php
					$select_messages = $mysqli->query("SELECT * FROM `message` ");
					$number_of_messages = $select_messages->num_rows;				
				?>
				<h3><?php echo $number_of_messages ?></h3>
				<p>Mensajes</p>
			</div>
		</div>
	</section>

	<script type="text/javascript" src="../../js/admin_script.js"></script>
</body>
</html>