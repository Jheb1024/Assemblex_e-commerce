<?php
include '../../ConfigBD/config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
	header('location:../../Public/login.php');
}

if (isset($_POST['add_to_cart'])) {
	$product_name = $_POST['product_name'];
	$product_price = $_POST['product_price'];
	$product_image = $_POST['product_image'];
	$product_quantity = $_POST['product_quantity'];
	$product_id = $_POST['product_id'];

	$check_cart_numbers = $mysqli->query("SELECT * FROM `cart` WHERE name = '$product_name'
		AND user_id = '$user_id'");

	if ($check_cart_numbers->num_rows > 0) {
		$message[] = 'Ya se ha agregado al carrito';
	}else{
		$mysqli->query("INSERT INTO `cart`(user_id,product_id,name, price, quantity, image)
			VALUES('$user_id','$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image' )");
		$message[] = 'Producto agregado al carrito';
	}
}


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home</title>
	<!--Fuente-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" type="text/css" href="../../css/style.css">
</head>
<body>
	<?php
	include 'header.php';
	?>
	

	<section class="shopping-cart">
		<h1 class="title">Nuestros Productos</h1>
		<div class="box-container">
			<?php
			$select_products = $mysqli->query("SELECT * FROM `products`");
			if ($select_products->num_rows > 0) {

				while($fetch_products = $select_products->fetch_assoc()){
					?>
					<div class="box">
						<form action="" method="post">
							<img src="../admin/uploaded_img/<?php echo $fetch_products['image']?>">
							<div class="name"><?php echo $fetch_products['name']?></div>
							<div class="price">$ <?php echo $fetch_products['price']?></div>
							<input type="number" min="1" name="product_quantity" value="1" class="qty">
							<input type="hidden" name="product_name" value="<?php echo $fetch_products['name']?>">
							<input type="hidden" name="product_price" value="<?php echo $fetch_products['price']?>">
							<input type="hidden" name="product_image" value="<?php echo $fetch_products['image']?>">
							<input type="hidden" name="product_id" value="<?php echo $fetch_products['id']?>">
							<input type="submit" name="add_to_cart" class="btn" value="Agregar al carrito">
						</form>
					</div>
					<?php

				}
			}else{
				echo '<p class="empty">No hay productos registrados</p>';
			}




			?>
		</div>
	</section>

	<?php
	include 'footer.php';
	?>
	<script type="text/javascript" src="../../js/script.js"></script>
</body>
</html>