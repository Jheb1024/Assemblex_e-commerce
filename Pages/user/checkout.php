<?php
include '../../ConfigBD/config.php';
session_start();



$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
	header('location:../../Public/login.php');
}
$grand_total = 0;
$total_products = 0;
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Compra</title>
	<!--Fuente-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!--Estilos de la API (tarjeta)-->
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../../css/style.css">

</head>

<body>
	<?php
	include 'header.php';
	?>

	<section class="display-order">
		<?php
		$select_cart = $mysqli->query("SELECT * FROM `cart` WHERE user_id = '$user_id'");

		if ($select_cart->num_rows > 0) {
			while ($fetch_cart = $select_cart->fetch_assoc()) {
				$total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
				$grand_total += $total_price;
				$total_products +=$fetch_cart['quantity'];
		?>

				<p><?php echo $fetch_cart['name']; ?> <span>(<?php echo '$' . $fetch_cart['price'] . ' x ' . $fetch_cart['quantity']; ?>)</span></p>
		<?php
			}
		} else {
			echo '<p class="empty">Tu carrito está vacío</p>';
		}
		?>

		<div class="grand-total">Total: $ <?php echo $grand_total; ?> </div>
	</section>



	<section class="checkout">

		<div class="container">
			<h2 class="my-4 text-center">Rellene los datos de pago</h2>
			<form action="./charge.php" method="post" id="payment-form">
				<div class="form-row">
					<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
					<input type="hidden" name="total_products" value="<?php echo  $total_products;?>">
					<input type="text" name="name" class="form-control mb-3 StripeElement StripeElement--empty" placeholder="Nombre completo">
					<input type="number" name="number" class="form-control mb-3 StripeElement StripeElement--empty" placeholder="Teléfono">
					<input type="email" name="email" class="form-control mb-3 StripeElement StripeElement--empty" placeholder="Correo">
					<input type="text" name="address" class="form-control mb-3 StripeElement StripeElement--empty" placeholder="Dirección">
					<div class="grand-total">Total: $ <?php echo $grand_total;?> </div>
					<input type="hidden" name="amount" value="<?php echo $grand_total; ?>">
					<br>
					<div id="card-element" class="form-control">
						<!-- a Stripe Element will be inserted here. -->
					</div>
					<!-- Used to display form errors -->
					<div id="card-errors" role="alert"></div>
				</div>
				<button>Submit Payment</button>
			</form>
		</div>


	</section>
	<?php
	include 'footer.php';
	?>
	<script type="text/javascript" src="../../js/script.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://js.stripe.com/v3/"></script>
	<script src="./js/charge.js"></script>
</body>

</html>