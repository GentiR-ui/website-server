<?php
session_start();

include("connection.php");
include("functions.php");


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    die;
}

try {
    $query = "SELECT * FROM orders";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="header.css?<?php echo time(); ?>">

    <link rel="stylesheet" href="general.css?<?php echo time(); ?>">

    <link rel="stylesheet" href="adminOrder.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
</head>
<body>

<navbar class="header">
        <div class="left-section">
            <img src="faqjaKryesoreImg/logo.png" class="logo">
        </div>
        <div class="middle-section">
            <a href="adminPage.php">HOME</a>
            <a href="admin_products.php">PRODUCTS</a>
            <a href="adminOrder.php">ORDERS</a>
            <a href="adminUsers.php">USERS</a>
            <a href="adminMessages.php">MESSAGES</a>
        </div>
        <div class="right-section">
            <div class="icons">
                <i class="bi bi-person" id="user-btn"></i>
                <i class="bi bi-list" id="menu-btn"></i>
            </div>   
            <ul class="user-box" id="myDiv">
               <p>Username : <span><?php echo $user_data['user_name'];?></span></p>
               <p>Email : <span><?php echo $user_data['user_email'];?></span></p>
               <form action="logout.php" method="post">
                   <button type="submit" class="btn" value="logout">Logout</button>
               </form>      
            </ul>  
        </div>
        <div class="mid">
            <a href="adminPage.php">HOME</a>
            <a href="admin_products.php">PRODUCTS</a>
            <a href="adminOrder.php">ORDERS</a>
            <a href="adminUsers.php">USERS</a>
            <a href="adminMessages.php">MESSAGES</a>
        </div>
    </navbar>

    <div class="orders">
        <?php foreach ($orders as $order): ?>
            <div class="order">
                <p>Order ID: <?php echo $order['id']; ?></p>
                <p>Ordered from: <?php echo $order['user_name']; ?></p>
                <p>Email: <?php echo $order['user_email']; ?></p>
                <p>Product name: <?php echo $order['product_name']; ?></p>
                <p>Total: $<?php echo $order['product_price']; ?></p>
                <p>Order Date: <?php echo $order['order_date']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    
    
   



    <script>
        
    const userBtn = document.getElementById("user-btn");
    const userBox = document.getElementById("myDiv");

  
    userBtn.addEventListener("click", (e) => {
        e.stopPropagation(); 
        if (userBox.style.display === "block") {
            userBox.style.display = "none";
        } else {
            userBox.style.display = "block";
        }
    });

    
    document.addEventListener("click", (e) => {
        if (!userBox.contains(e.target) && e.target !== userBtn) {
            userBox.style.display = "none";
        }
    });

    
    
    
    const menuBtn = document.getElementById("menu-btn");
    const middleSection = document.querySelector(".mid");
    
        window.addEventListener("click", (e) => {
            if (!userBox.contains(e.target) && !userBtn.contains(e.target)) {
            }
            if (!middleSection.contains(e.target) && !menuBtn.contains(e.target)) {
                middleSection.style.display = "none";
            }
        });
        
        menuBtn.addEventListener("click", (e) => {
            e.stopPropagation(); 
            if (middleSection.style.display === "block") {
                middleSection.style.display = "none";
            } else {
                middleSection.style.display = "block";
            }
        });
    
        
        window.addEventListener("resize", () => {
            if (window.innerWidth > 768) {
                middleSection.style.display = "none";
            }
        });
    </script>
</body>
</html>    