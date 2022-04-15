<?php
    if(!empty($_GET['tid'] && !empty($_GET['product']))){
        $_GET = filter_var_array($_GET, FILTER_UNSAFE_RAW);

        $tid = $_GET['tid'];
        $product = $_GET['product'];

    }else{
        header('location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank you</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
    <div class="container mt-4">
        <h3>Gracias por su compra</h3>
        <hr>
        <p>Tu ID de transacción es: <?php echo$tid;?> </p>
        <p>Revisa tu email para más información</p>
        <p><a href="index.php" class="btn btn-light mt-2">
        Regresar</a></p>
    </div>
</body>
</html>