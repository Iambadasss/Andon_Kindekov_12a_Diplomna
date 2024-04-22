<?php
// Включване на файловете за връзка с базата данни и настройки
include 'config.php';
session_start();

// Проверка дали потребителят е влязъл в системата
$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location: index.php');
    exit(); // След пренасочването, прекратяваме изпълнението на скрипта
}

// Проверка за наличие на product_id в URL-а
if (isset($_GET['product_id'])) {
    // Извличане на product_id от URL-а
    $product_id = $_GET['product_id'];

    // Заявка за извличане на информация за продукта от базата данни
    $query = "SELECT * FROM `products` WHERE `id` = $product_id";
    $result = mysqli_query($conn, $query);

    // Проверка за наличие на резултати
    if (mysqli_num_rows($result) > 0) {
        // Извличане на данните за продукта
        $product = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title><?php echo $product['name']; ?></title>

   <!-- Връзка към Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Връзка към персонализиран CSS файл -->
   <link rel="stylesheet" href="css/style.css">
   <style>
  .footer {
   background-color: black;
   color: white;
   padding: 20px;
   position: fixed;
   bottom: 0;
   width: 100%;
}

.footer .box-container {
   max-width: 1200px;
   margin: 0 auto;
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(25rem, 1fr));
   gap: 3rem;
}

.footer .box-container .box h3 {
   text-transform: uppercase;
   color: white;
   font-size: 2rem;
   padding-bottom: 2rem;
}

.footer .box-container .box p,
.footer .box-container .box a {
   display: block;
   font-size: 1.7rem;
   color: #ccc; /* Замени този цвят с твоя желан цвят за текста */
   padding: 1rem 0;
}

.footer .box-container .box p i,
.footer .box-container .box a i {
   color: purple; /* Замени този цвят с твоя желан цвят за иконките */
   padding-right: 0.5rem;
}

.footer .box-container .box a:hover {
   color: purple;
   text-decoration: underline;
}

.footer .credit {
   text-align: center;
   font-size: 2rem;
   color: #ccc; /* Замени този цвят с твоя желан цвят за текста */
   border-top: 1px solid #ccc; /* Замени този цвят с твоя желан цвят за горната рамка */
   margin-top: 2.5rem;
   padding-top: 2.5rem;
}

.footer .credit span {
   color: purple; /* Замени този цвят с твоя желан цвят за текста */
}

  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f5f5f5;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.product-details {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    margin-top: 20px;
}

.product-image {
    flex: 1;
    margin-right: 20px;
}

.image-wrapper {
    display: flex;
    justify-content: center;
}

.product-image-container {
    max-width: 100%;
    height: auto;
    border: 1px solid #ccc;
    border-radius: 5px;
    overflow: hidden;
}

.product-image img {
    max-width: 100%;
    height: auto;
}

.product-info {
    flex: 1;
}

.product-info h2 {
    font-size: 24px;
    margin-bottom: 10px;
}

.product-info p {
    font-size: 18px;
    line-height: 1.5;
    margin-bottom: 10px;
}

.product-info label {
    font-size: 18px;
    margin-bottom: 5px;
}

.product-info input[type="number"] {
    width: 50px;
    padding: 5px;
    margin-right: 10px;
}

.product-info button {
    padding: 10px 20px;
    font-size: 18px;
    background-color: #8e44ad;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.product-info button:hover {
    background-color: #6c3483;
}


   </style>
</head>

<body>

<?php include 'header.php'; ?>

<div class="product-details">
    <div class="product-image">
        <div class="image-wrapper">
            <div class="product-image-container">
                <img src="uploaded_img/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
            </div>
        </div>
    </div>
    <div class="product-info">
        <h2><?php echo $product['name']; ?></h2>
        <p><?php echo $product['book_info']; ?></p>
        <p>Цена: <?php echo $product['price']; ?> Лв</p>
        <!-- Форма за добавяне на продукта в количката -->
        <form action="add_to_cart.php" method="post">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
            <label for="quantity">Количество:</label>
            <input type="number" id="quantity" name="product_quantity" min="1" value="1">
            <button type="submit" name="add_to_cart">Добави в количката</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>

<!-- Връзка към персонализиран JavaScript файл -->
<script src="js/script.js"></script>

</body>
</html>
<?php
    } else {
        // Ако не се намери продукт с дадения product_id
        echo "Продуктът не беше намерен.";
    }
} else {
    // Ако не е предоставен product_id в URL-а
    echo "Не е предоставен идентификатор на продукта.";
}
?>
