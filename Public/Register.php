<?php 

include '../ConfigBD/config.php';

if(isset($_POST['submit'])){

	$name = $mysqli -> real_escape_string($_POST['name']);
	$email = $mysqli -> real_escape_string($_POST['email']);
	$password = $mysqli -> real_escape_string($_POST['password']);

	$queryUsuarioExistente = "SELECT * FROM  `users` WHERE email = '$email' AND password = '$password' ";
	$existe = $mysqli->query($queryUsuarioExistente);


	if($existe->num_rows < 0){
		$sql="INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

		if (!$mysqli -> query($sql)) {
			printf("%d Row inserted.\n", $mysqli->affected_rows);

		}else{
			$message[] = 'Registro exitoso';
			header('locatio:login.php');
		}
	}else{
		$message[] = 'El usuario ya existe';
	}




	$mysqli -> close();
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registro</title>

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
			<h3>Registrarse ahora</h3>
			<input type="text" name="name" placeholder="Nombre" required class="box">
			<input type="email" name="email" placeholder="E-mail" required class="box">
			<input type="password" name="password" placeholder="Contraseña" required class="box">
			<input type="password" name="cpassword" placeholder="Contraseña" required class="box">
			<input type="submit" name="submit" value="Registrarme" class="btn">
			<p>¿Ya tienes una cuenta? <a href="login.php">Inicia Sesión</a></p>
		</form>
	</div>
</body>
</html>