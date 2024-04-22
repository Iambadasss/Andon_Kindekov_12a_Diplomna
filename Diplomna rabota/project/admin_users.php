<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:index.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_users.php');
}
if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $user_type = 'admin';

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'Потребителя вече съществува!';
   }else{
      if($pass != $cpass){
         $message[] = 'Паролите не са еднакви!';
      }else{
         mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', '$user_type')") or die('query failed');
         $message[] = 'Регистрирането беше успешно!';
        
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="users">

   <h1 class="title"> Потребителски акаунти </h1>
 
   
<div class="form-container-admin">

   <form action="" method="post">
      <h3>Добави админ</h3>
      <input type="text" name="name" placeholder="напиши име" required class="box">
      <input type="email" name="email" placeholder="напиши имейл" required class="box">
      <input type="password" name="password" placeholder="напиши парола" required class="box">
      <input type="password" name="cpassword" placeholder="потварди паролата" required class="box">
      <input type="submit" name="submit" value="Регистрирай нов администратор" class="btn">
   </form>

</div>
   <div class="box-container">
      <?php
         $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
         while($fetch_users = mysqli_fetch_assoc($select_users)){
      ?>
      
      <div class="box">
         
         <p> Потребителско id : <span><?php echo $fetch_users['id']; ?></span> </p>
         <p> Име на потребителя : <span><?php echo $fetch_users['name']; ?></span> </p>
         <p> Имейл : <span><?php echo $fetch_users['email']; ?></span> </p>
         <p> Вид на потребителя : <span style="color:<?php if($fetch_users['user_type'] == 'admin'){ echo 'var(--orange)'; } ?>"><?php echo $fetch_users['user_type']; ?></span> </p>
         <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('Delete this user?');" class="delete-btn">Премахни потребителя</a>
      </div>
      <?php
         };
      ?>
   </div>

</section>









<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>