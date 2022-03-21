<?php
    require "cd.php";
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
	<link rel="StyleSheet" href="music.css" type="text/css">
</head>
<body>

    <?php

        $nonEmptyShoppingCart = FALSE;

        if (isset($_SESSION["shoppingcart"])) {
            $shoppingCart = $_SESSION["shoppingcart"];

            if (count($shoppingCart) > 0) {
                $nonEmptyShoppingCart = TRUE;
            }
        }

        if ($nonEmptyShoppingCart) {

    ?>

        <h2>Music Without Borders</h2>
        <div class="centered">
        <hr></hr>

            <table>

                <tr>
                    <td><b>Album</b></td>
                    <td><b>Artist</b></td>
                    <td><b>Country</b></td>
                    <td><b>Price</b></td>
                    <td><b>Quantity</b></td>
                </tr>

    <?php }

        $price = 0;
        for ($index = 0; $index < count($shoppingCart); $index++)
        {
            $orderedCD = $shoppingCart[$index];
            $price = $price + $orderedCD->getPrice();

    ?>

        <tr>
            <td><?php echo $orderedCD->getAlbum(); ?></td>
            <td><?php echo $orderedCD->getArtist(); ?></td>
            <td><?php echo $orderedCD->getCountry(); ?></td>
            <td>&pound;<?php echo $orderedCD->getPrice(); ?></td>
            <td><?php echo $orderedCD->getQuantity(); ?></td>
        </tr>

    <?php  }
    ?>

        <tr>
            <td></td>
            <td></td>
            <td>Total</td>
            <td>&pound;<?php echo '<span style = "color:red; font-size: 20px;">' .$price.'<a href="something.php"><a/></span>'; ?></td>
            <td></td>
        </tr>

            </table>

        <br><br><a href="./shop.php">Back to shopping cart</a>

        </div>

</body>
</html>