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

   <div class="flex">

      <a href="admin_page.php" class="logo">Admin<span>Panel</span></a>

      <nav class="navbar">
         <a href="admin_page.php">Информационно Табло</a>
         <a href="admin_products.php">Добавяне на Продукти</a>
         <a href="admin_orders.php">Поръчки</a>
         <a href="admin_users.php">Потребители</a>
         <a href="admin_contacts.php">Съобщения</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="account-box">
         <p>Потребител : <span><?php echo $_SESSION['admin_name']; ?></span></p>
         <p>имейл : <span><?php echo $_SESSION['admin_email']; ?></span></p>
         <a href="logout.php" class="delete-btn">Излез</a>
      </div>

   </div>

</header>