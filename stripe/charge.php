<?php
   require('./stripe/init.php');

   $publishableKey="pk_test_51KoM5qBvh1zRNRmpU0zkyv45Msg2TaKltPcVrFvwsWciJMf5vH9O1EOxEEnCoDMBvtWemO84l4m4RJCo1YKPutia00OhypMxxm";

	$secretKey = "sk_test_51KoM5qBvh1zRNRmpL8GAXUGFpripTwE0Vcg1dbieCHA3dmEGFobW9gVCbFXW0iBomCVfSsuxiIbvsR3CuCvC27l000emCI0YXZ";

	\Stripe\Stripe::setApiKey($secretKey);

    $POST = filter_var_array($_POST, FILTER_UNSAFE_RAW);
    $first_name = $POST['first_name'];
    $first_last = $POST['last_name'];
    $email = $POST['email'];
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
                "amount" => 50000,
                "currency" => 'mxn',
                "description" => 'Intro to react course',
                "customer" => $customer->id
            )
        );

        //print_r($charge);

    header('Location:succes.php?tid='.$charge->id.'&product='.$charge->description);

        ?>
