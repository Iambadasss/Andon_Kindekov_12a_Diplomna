<?php
if(isset($message)){
    if(is_array($message)){
        foreach($message as $msg){
            echo '
            <div class="message">
                <span>'.$msg.'</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
            ';
        }
    } else {
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



   <div class="header-2">
      <div class="flex">
         <a href="home.php" class="logo">Четиво на Клик</a>

         <nav class="navbar">
            <a href="home.php">Главна страница</a>
            <a href="about.php">За нас</a>
            <a href="shop.php">Книжарница</a>
            <a href="contact.php">Връзка с нас</a>
            <a href="orders.php">Поръчки</a>
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php
               $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
               $cart_rows_number = mysqli_num_rows($select_cart_number); 
            ?>
            <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
         </div>

         <div class="user-box">
            <p>профил : <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>имейл : <span><?php echo $_SESSION['user_email']; ?></span></p>
            <a href="logout.php" class="delete-btn">Излез от профил</a>
         </div>
      </div>
   </div>

</header>