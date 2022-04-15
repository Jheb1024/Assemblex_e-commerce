<?php
include '../../ConfigBD/config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
	header('location:../../Public/login.php');
}else{
	
}

if (isset($_POST['add_product'])) {
	$name = $mysqli->real_escape_string($_POST['name']);
	$price = $_POST['price'];
	$image = $_FILES['image']['name'];
	$image_size = $_FILES['image']['size'];
	$image_tmp_name = $_FILES['image']['tmp_name'];
	$image_folder = 'uploaded_img/'.$image;

	$select_product_name = $mysqli->query("SELECT name FROM `products` WHERE name = '$name'");

	if ($select_product_name->num_rows > 0) {
		$message[] = 'El nombre del producto ya esxiste'; 
	}else{
		$add_product_query = $mysqli->query("INSERT INTO `products`(name, price, image) 
			VALUES('$name', '$price', '$image')");

		if ($add_product_query) {
			if ($image_size > 2000000) {
				$message[]= 'El tamaño de imagen es muy grande';
			}
			move_uploaded_file($image_tmp_name, $image_folder);

			$message[] = 'Producto agregado satsifactoriamete';	
		}else{

			$message = 'El producto no pudo agregarse.';

		}
	}
}

if (isset($_GET['delete'])) {
	$delete_id = $_GET['delete'];
	$mysqli->query("DELETE FROM `products` WHERE id = '$delete_id'");

	header('location:admin_products.php');
}

if (isset($_POST['update_product'])) {

	$update_id = $_POST['update_p_id'];
	$update_name = $_POST['update_name'];
	$update_price = $_POST['update_price'];

	$sqlquery = $mysqli->query("UPDATE `products` SET name = '$update_name', price = '$update_price' WHERE
		id='$update_id'");
	$update_image = $_FILES['update_image']['name'];
	$update_image_tmp_name = $_FILES['update_image']['tmp_name'];
	$update_image_size = $_FILES['update_image']['size'];
	$update_folder = 'uploaded_img/'.$update_image;
	$update_old_image = $_POST['update_old_image'];

	if (!empty($update_image)) {
		if ($update_image_size > 2000000) {
			$message = 'El tamaño de la imagen es muy grande';
		}else{
			$mysqli->query("UPDATE `products` SET image = '$update_image' WHERE id = '$update_id'");
			move_uploaded_file($update_image_tmp_name, $update_folder);
			unlink('uploaded_img/'.$update_old_image);
		}
	}
	header('location:admin_products.php');

}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Productos</title>
	<!--Fuente-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" type="text/css" href="../../css/admin_style.css">
</head>
<body>
	<?php
	include 'admin_header.php';
	?>
	<section class="add-products">
		<form action="" method="post" enctype="multipart/form-data">
			<h3>Agregar productos</h3>
			<input type="text" name="name" class="box" placeholder="Nombre del producto" required/>
			<input type="number" name="price" class="box" placeholder="Precio del producto" required/>
			<input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required/>
			<input type="submit" value="Agregar producto" name="add_product" class="btn">

		</form>
	</section>

	<section class="show-products">

		<div class="box-container">
			<?php
			$select_products = $mysqli->query("SELECT * FROM `products`");

			if ($select_products->num_rows > 0) {
				while($fetch_products = $select_products->fetch_assoc()){
					?>

					<div class="box">
						<img src="uploaded_img/<?php echo $fetch_products['image'];?>">
						<div class="name"><?php echo $fetch_products['name'];?></div>
						<div class="price"> $<?php echo $fetch_products['price'];?></div>
						<a href="admin_products.php?update=<?php echo $fetch_products['id'];?>" class="option-btn">Actualizar</a>
						<a href="admin_products.php?delete=<?php echo $fetch_products['id'];?>" class="delete-btn"onclick ="return confirm('Eliminar este producto?')">Borrar</a>
					</div>
					<?php
				}
			}else{
				echo '<p class="empty">No hay prodcutos agreagados</p>';
			}
			?>
		</div>
	</section>

	<section class="edit-product-form">
		<?php
		if(isset($_GET['update'])){
			$update_id = $_GET['update'];
			$update_query = $mysqli->query("SELECT * FROM `products` WHERE id = '$update_id'");

			if ($update_query->num_rows > 0) {
				while($fetch_update = $update_query->fetch_assoc()){

					?>
					<form action="" method="post" enctype="multipart/form-data">
						<input type="hidden" name="update_p_id" value="<?php echo  $fetch_update['id'];?>">
						<input type="hidden" name="update_old_image" value="<?php echo  $fetch_update['image'];?>">
						<img src="uploaded_img/<?php echo $fetch_update['image'];?>">
						<input type="text" name="update_name" value=" <?php echo  $fetch_update['name'];?>" class="box" required placeholder="Nombre">
						<input type="number" name="update_price" value="<?php echo  $fetch_update['price'];?>" min="0" class="box" required placeholder="Precio">
						<input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
						<input type="submit" value="Actualizar" name="update_product" class="btn">
						<input type="reset" value="Cancelar" id="close-update" class="btn">
					</form>
					<?php

				}
			}else{
				echo "no encontramos nada ";
			}
		}else{
			echo "<script> document.querySelector('.edit-product-form').style.display = 'none';</script>";
		}
		?>
	</section>

	<script type="text/javascript" src="../../js/admin_script.js"></script>
</body>
</html>

