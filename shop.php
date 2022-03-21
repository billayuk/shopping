<?php
    require "cd.php";
    session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title>Music Without Borders</title>
	<link rel="StyleSheet" href="music.css" type="text/css">
</head>
<body>
<?php
   // This code is the business logic part of the page. It looks to see if any action has
   // previously been requested (such as Add, Delete, etc) and performs the appropriate 
   // action

   // First, look to see if the 'Add to cart' button was pressed
   $totalPrice = "";
   if (isset($_GET["Add"]))
   {
      // Create a new CD object
      $newCD = CD::setCDfromString($_GET["CD"], $_GET["qty"]);
      // Check to see if the cart is stored in the session
      if (!isset($_SESSION["shoppingcart"]))
      {
         // The shopping cart does not already exist, so create it
         $shoppingCart[] = $newCD;
      }
      else
      {
         // Not the first purchase, so check to see if the purchased CD is already
         // in the shopping cart. If it is, then just update the quantity of the CD
         // in the cart.
         $match = FALSE;
         $shoppingCart = $_SESSION["shoppingcart"];
         for ($index = 0; $index < count($shoppingCart); $index++)
         {            
            $existingCD = $shoppingCart[$index];
            if ($existingCD->getAlbum() == $newCD->getAlbum())
            {
               $existingCD->setQuantity($existingCD->getQuantity() + $newCD->getQuantity());
               $match = TRUE;
            }  
         }         
         if (!$match)
         {
            // The new CD is not already in the cart, so add it to the cart
            $shoppingCart[] = $newCD;
         }
      }
      // Update the Session with the new contents of the shopping cart
      $_SESSION["shoppingcart"] = $shoppingCart;
   }
   elseif (isset($_GET["Delete"]))
   {
      // We are deleting an item from the shopping cart
      $shoppingCart = $_SESSION["shoppingcart"];
      // Get the index of the item to delete 
      $itemToDelete = $_GET["delindex"];
      // Remove it from the cart
      unset($shoppingCart[$itemToDelete]);
      $shoppingCart = array_values($shoppingCart);
      // And update the cart
      $_SESSION["shoppingcart"] = $shoppingCart;
   }
?>
<h2>Music Without Borders</h2>
<div class="centered">
  <hr>
  <form name="shoppingform" action="shop.php" method="GET">
    <p><b>CD:</b> 
    <!  The list of CDs should really be extracted from a database rather than being hardcoded >
    <select name="CD" size="1">
      <option>Yuan, The Guo Brothers, China, 14.95</option>
      <option>Drums of Passion, Babatunde Olatunji, Nigeria, 16.95</option>
      <option>Kaira, Tounami Diabate, Mali, 16.95</option>
      <option>The Lion is Loose, Eliades Ochoa, Cuba, 13.95</option>
      <option>Dance the Devil Away, Outback, Australia, 14.95</option>
      <option>Record of Changes, Samulnori, Korea, 12.95</option>
      <option>Djelika, Tounami Diabate, Mali, 14.95</option>
      <option>Rapture, Nusrat Fateh Ali Khan, Pakistan, 12.95</option>
      <option>Cesaria Evora, Cesaria Evora, Cape Verde, 16.95</option>
      <option>Ibuki, Kodo, Japan, 13.95</option>
    </select>
    <b>Quantity: </b><input type="text" name="qty" size="3" value="1" />
    <input type="submit" name="Add" value="Add to Cart" />
	</p>
  </form>
</div>
<?php
    // The following code is used to decide if the shopping cart contains anything. If
    // it does, then the cart is displayed

    $nonEmptyShoppingCart = FALSE;

    // First, check to see if a shopping cart exists in the session
    if (isset($_SESSION["shoppingcart"]))
    {
      // The cart exists. Now, look to see if it empty (it will be if
      // items had previously been in the cart and later been deleted).
      $shoppingCart = $_SESSION["shoppingcart"];
      if (count($shoppingCart) > 0)
      {
          $nonEmptyShoppingCart = TRUE;
      }
    }
    if ($nonEmptyShoppingCart)
    {
      // Output the contents of the shopping cart in a table
?>
      <div class="centered">
        <table>
          <tr>
            <td><b>Album</b></td>
            <td><b>Artist</b></td>
            <td><b>Country</b></td>
            <td><b>Price</b></td>
            <td><b>Quantity</b></td>
            <td>&nbsp;</td>
          </tr>
<?php
  
      for ($index = 0; $index < count($shoppingCart); $index++)
      {
          $orderedCD = $shoppingCart[$index];

          
          
?>
          <tr>
            <td><?php echo $orderedCD->getAlbum(); ?></td>
            <td><?php echo $orderedCD->getArtist(); ?></td>
            <td><?php echo $orderedCD->getCountry(); ?></td>
            <td>&pound;<?php echo $orderedCD->getPrice(); ?></td>
            <td><?php echo $orderedCD->getQuantity(); ?></td>
            <!-- <td><?php echo $price ?>></td> -->
            <td>
              <form name="deleteForm" action="shop.php" method="GET">
                <div>
                  <input type="submit" name="Delete" value="Delete" >
                  <input type="hidden" name= "delindex" value='<?php echo $index; ?>'>
                </div>
              </form> 
            </td>
          </tr> 
<?php  }  
?>
        </table>
        <br>
        <form name="checkoutForm" action="checkout.php" method="POST">
          <p>
            <input type="submit" name="Checkout" value="Checkout" >
          </p> 
        </form>
      </div>
<?php } 
?>
</body>
</html>
