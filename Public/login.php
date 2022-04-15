<?php 

include '../ConfigBD/config.php';
session_start();

if(isset($_POST['submit'])){

	$name = $mysqli -> real_escape_string($_POST['name']);
	$email = $mysqli -> real_escape_string($_POST['email']);
	$password = $mysqli -> real_escape_string($_POST['password']);

	$queryUsuarioExistente = "SELECT * FROM  `users` WHERE email = '$email' AND password = '$password' ";
	$existe = $mysqli->query($queryUsuarioExistente);


	if($existe->num_rows > 0){

		$row = $existe->fetch_assoc();

		if ($row['user_type'] == 'admin') {

			$_SESSION['admin_name'] =$row['name'];
			$_SESSION['admin_email'] =$row['email'];
			$_SESSION['admin_id'] =$row['id'];
			echo $_SESSION['admin_name'];
			header('location:../Pages/admin/admin_page.php');
		}else{
			if ($row['user_type'] == 'user') {
				$_SESSION['user_name'] =$row['name'];
				$_SESSION['user_email'] =$row['email'];
				$_SESSION['user_id'] =$row['id'];
				header('location:../Pages/user/home.php');
			}
		}

	}else{
		$message[] = 'E-mail o contraseña incorrecto';
	}




	$mysqli -> close();
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Inicio Sesión</title>

	<!--Fuente-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" type="text/css" href="../css/style.css">

	


</head>
<body>
	<?php
	if(isset($message)){
		foreach($message as $message){
			echo '
			<div class="message">
			<span>'.$message.'</span>
			<i class="fas fa-times" onclick="this.parentElement.remove();"></i>
			</div>
			';
		}
	}
	?>

	<div class="form-container">
		<form action="" method="post">
			<h3>Iniciar Sesión</h3>
			<input type="email" name="email" placeholder="E-mail" required class="box">
			<input type="password" name="password" placeholder="Contraseña" required class="box">
			<input type="submit" name="submit" value="Iniciar Sesión" class="btn">
			<p>¿No tienes una cuenta? <a href="Register.php">Registrarse</a></p>
		</form>
	</div>
</body>
</html>