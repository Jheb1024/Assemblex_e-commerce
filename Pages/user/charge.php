<?php
   require('./stripe/init.php');
   include '../../ConfigBD/config.php';

   $publishableKey="pk_test_51KoM5qBvh1zRNRmpU0zkyv45Msg2TaKltPcVrFvwsWciJMf5vH9O1EOxEEnCoDMBvtWemO84l4m4RJCo1YKPutia00OhypMxxm";

	$secretKey = "sk_test_51KoM5qBvh1zRNRmpL8GAXUGFpripTwE0Vcg1dbieCHA3dmEGFobW9gVCbFXW0iBomCVfSsuxiIbvsR3CuCvC27l000emCI0YXZ";

	\Stripe\Stripe::setApiKey($secretKey);

    $POST = filter_var_array($_POST, FILTER_UNSAFE_RAW);
    $user_id = $POST['user_id'];
    $total_products = $POST['total_products'];
    $name = $POST['name'];
    $number = $POST['number'];
    $email = $POST['email'];
    $address = $POST['address'];
    $amount = $POST['amount'];
    $token = $POST['stripeToken'];

    //echo $token;

    $customer = \Stripe\Customer::create(
        array(
            "email" => $email,
            "source" => $token
        )
        );

        $charge = \Stripe\Charge::create(
            array(
                "amount" => $amount,
                "currency" => 'mxn',
                "description" => 'Intro to react course',
                "customer" => $customer->id
            )
        );

    
    $orderInserted = $mysqli->query("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, 
    total_price, placed_on, payment_status) values('$user_id', '$name','$number', '$email','Tarjeta', '$address','$total_products',
    '$amount', 'orders', 'pagado')");

    if ($orderInserted) {
        $mysqli->query("DELETE FROM `cart` WHERE user_id='$user_id'");
    }else{

    }


    header('Location:succes.php?tid='.$charge->id.'&product='.$charge->description);

?>