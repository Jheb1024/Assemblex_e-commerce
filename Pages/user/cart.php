<?php
include '../../ConfigBD/config.php';
session_start();

$grand_total = 0;

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
	header('location:../../Public/login.php');
}

if (isset($_POST['update_cart'])) {
	$cart_id = $_POST['cart_id'];
	$cart_quantity = $_POST['cart_quantity'];

	$mysqli->query("UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'");

	$message[] = 'Carrito actualizado';
}

if (isset($_GET['delete'])) {
	$delete_id = $_GET['delete'];

	$mysqli->query("DELETE FROM `cart` WHERE id = '$delete_id'");
	header('location:cart.php');
}


if (isset($_GET['delete_all'])) {
	$mysqli->query("DELETE FROM `cart` WHERE user_id = '$user_id'");
	header('location:cart.php');
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
		<h1 class="title">Productos agregados</h1>
		<div class="box-container">
			<?php
			$select_cart = $mysqli->query("SELECT * FROM `cart` WHERE user_id = '$user_id'");
			if ($select_cart->num_rows > 0) {
				while($fetch_cart = $select_cart->fetch_assoc()){

					?>

					<div class="box">
						<a href="cart.php?delete=<?php echo $fetch_cart['id']?>" class="fas fa-times" onclick="return confirm('Eliminar todos los productos');"></a>
						<img src="../admin/uploaded_img/<?php echo $fetch_cart['image']?>">
						<div class="name"><?php echo $fetch_cart['name']?></div>
						<div class="price">$ <?php echo $fetch_cart['price']?></div>
						<form action="" method="post">
							<input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']?>">
							<input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']?>">
							<input type="submit" name="update_cart" value="Actualizar" class="option-btn">
						</form>
						<div class="sub-total">Subtotal: $ <?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']);?> </div>
					</div>
					<?php
					$grand_total += $sub_total;
				}
			}else{
				echo '<p class="empty">No hay productos en el carrito</p>';
			}
			?>
		</div>

		<div style="margin-top: 2rem; text-align: center;">
			<a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled';?>" onclick="return confirm('Eliminar todos los productos');">Eliminar todos los productos</a>
		</div>
		<div class="cart-total">
			<p>Total: <span>$<?php echo $grand_total ?></span></p>
			<div class="flex">
				<a href="shop.php" class="option-btn">Continuar comprando</a>
				<a href="checkout.php" class="btn <?php echo ($grand_total > 1)?'':'disabled';?>">Pagar productos</a>
			</div>
		</div>
	</section>

	<?php
	include 'footer.php';
	?>
	<script type="text/javascript" src="../../js/script.js"></script>
</body>
</html>