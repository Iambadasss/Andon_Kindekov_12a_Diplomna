<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:index.php');
   exit(); 
}

if(isset($_POST['order_btn'])){
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $number = $_POST['number'];
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $method = mysqli_real_escape_string($conn, $_POST['method']);
   $address = mysqli_real_escape_string($conn, $_POST['street'].', '. $_POST['city'].', '. $_POST['country'].' - '. $_POST['pin_code']);
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products = array();

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   if(mysqli_num_rows($cart_query) > 0){
      while($cart_item = mysqli_fetch_assoc($cart_query)){
         $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      }
   }

   $total_products = implode(', ',$cart_products);

   if($method == "cash on delivery") {
      // Запазване на поръчката в базата данни
      mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
      // Изтриване на продуктите от кошницата
      mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      $message = 'поръчката беше заявена успешно!';
   } else if ($method == "paypal") {
      // Пренасочване към страницата за плащане с PayPal
      $_SESSION['order_details'] = array(
         'user_id' => $user_id,
         'name' => $name,
         'number' => $number,
         'email' => $email,
         'method' => $method,
         'address' => $address,
         'total_products' => $total_products,
         'total_price' => $cart_total,
         'placed_on' => $placed_on
      );
      header("Location: paypal_payment.php");
      exit();
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <!-- custom js file link  -->
   <script src="js/script.js"></script>
</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Заплащане</h3>
</div>

<section class="display-order">
   <?php  
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_cart) > 0){
         while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
   ?>
   <p> <?php echo $fetch_cart['name']; ?> <span>(<?php echo ''.$fetch_cart['price'].'Лв'.' x '. $fetch_cart['quantity']; ?>)</span> </p>
   <?php
      }
   }else{
      echo '<p class="empty">Количката ти е празна!</p>';
   }
   ?>
   <div class="grand-total"> Обща ценна : <span><?php echo $grand_total; ?>Лв</span> </div>

</section>

<section class="checkout">
   <!-- Форма за плащане -->
   <form id="paymentForm" method="post"> <!-- Променете action с цел да изпратите данните към текущата страница -->
      <h3>Информация за поръчката</h3>
      <div class="flex">
         <div class="inputBox">
            <span>Ваше име :</span>
            <input type="text" name="name" required placeholder="Напишете си името">
         </div>
         <div class="inputBox">
            <span>Ваш телефонен номер :</span>
            <input type="number" name="number" required placeholder="Напишете си телефония номер">
         </div>
         <div class="inputBox">
            <span>Ваш имейл :</span>
            <input type="email" name="email" required placeholder="Напишете си имейла">
         </div>
         <div class="inputBox">
            <span>Начин на плащане :</span>
            <select id="paymentMethod" name="method">
               <option value="cash on delivery">наложен платеж</option>
               <option value="paypal">paypal</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Улица :</span>
            <input type="text" name="street" required placeholder="Напиши си улицата">
         </div>
         <div class="inputBox">
            <span>Град :</span>
            <input type="text" name="city" required placeholder="Напиши си градът">
         </div>
         <div class="inputBox">
            <span>Държава :</span>
            <input type="text" name="country" required placeholder="Напиши си държавата">
         </div>
         <div class="inputBox">
            <span>Пощенски код :</span>
            <input type="number" min="0" name="pin_code" required placeholder="Напиши си пощенския код">
         </div>
      </div>
      <input type="hidden" name="total_amount" value="<?php echo $grand_total; ?>"> <!-- Скрито поле за общата сума -->
      <input type="submit" value="Плащане" class="btn" name="order_btn"> <!-- Запазване на submit бутона -->
   </form>
</section>

<?php include 'footer.php'; ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var paymentForm = document.getElementById('paymentForm');
    if (paymentForm) {
        paymentForm.addEventListener('submit', function(event) {
            var paymentMethod = document.getElementById('paymentMethod').value;
            if (paymentMethod === 'наложен платеж') {
                // Не правим нищо, формата ще се изпрати към същата страница
            } else if (paymentMethod === 'paypal') {
                // Променяме action атрибута на формата
                document.getElementById('paymentForm').action = 'paypal_payment.php';
            }
        });
    }
});
</script>

</body>
</html>
