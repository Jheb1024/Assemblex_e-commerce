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
<header class="header">
	<div class="header-1">
		<div class="flex">
			<div class="share">
				<a href="#" class="fab fa-facebook-f"></a>
				<a href="#" class="fab fa-twitter"></a>
				<a href="#" class="fab fa-instagram"></a>
				<a href="#" class="fab fa-linkedin"></a>
			</div>
			<p><a href="../../Public/login.php">Iniciar Sesión</a> | <a href="../../Public/Register.php">Registrarse</a> </p>
		</div>		
	</div>

	<div class="header-2">
		<div class="flex">
			<a href="home.php" class="logo">Assemblex</a>
			<nav class="navbar">
				<a href="home.php">Home</a>
				<a href="about.php">Nosotros</a>
				<a href="shop.php">Tienda</a>
				<a href="contact.php">Contacto</a>
				<a href="orders.php">Órdenes</a>
			</nav>
			<div class="icons">
				<div id="menu-btn" class="fas fa-bars"></div>
				<a href="search_page.php" class="fas fa-search"></a>
				<div id="user-btn" class="fas fa-user"></div>
				<a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(00)</span></a>
			</div>
			<div class="user-box">
				<p>Usuario : <span><?php echo $_SESSION['user_name']; ?></span></p>
				<p>E-mail : <span><?php echo $_SESSION['user_email']; ?></span></p>
				<a href="../../Public/logout.php" class="delete-btn">Salir</a>
			</div>
		</div>

	</div>


	
	

</header>