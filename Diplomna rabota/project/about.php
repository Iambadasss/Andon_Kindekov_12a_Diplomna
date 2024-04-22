<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>За нас</h3>
</div>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>Защо бихте избрали нас?</h3>
         <p>Добре дошли в "Четиво на клик"! Ние сме вашето предпочитано място за пазаруване на книги и манга, където гарантираме бърза и надеждна доставка на вашите поръчки. С нас, вие получавате не само качествени продукти, но и изключително внимателно обслужване. Всяка книга е подложена на стриктен контрол на качеството, за да можем да ви осигурим само най-доброто. Изберете "Четиво на клик" за вашето следващо литературно приключение и се насладете на удоволствието от четене, без стрес и грижи за доставката!</p>
         <a href="contact.php" class="btn">Връзка с нас</a>
      </div>

   </div>

</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>