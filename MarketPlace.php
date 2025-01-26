<?php
    include 'connection.php';

    
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="header.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="MarketPlace.css?<?php echo time(); ?>">
    
</head>
<main>
<body>
<navbar class="header">
        <div class="left-section">
            <img src="faqjaKryesoreImg/logo.png" class="logo">
        </div>
        <div class="middle-section">
            <a href="FaqjaKryesore.html">HOME</a>
            <li class="menu-item" id="services-menu"><a href="Services.html">SERVICES</a>
                <ul class="submenu-content">
                    <li><a href="MarketPlace.php">MARKETPLACE</a></li>
                    <li><a href="VideoEditing.html">Video Editing</a></li>
                    <li><a href="WebsiteMenagement.html">Website Menagement</a></li>
                    <li><a href="LogoDesignServices.html">Logo Design Services</a></li>
                </ul>
            </li>
            <a href="OurWork.html">OUR WORK</a>
            <a href="AboutUs.html">ABOUT US</a>
            <a href="ContactUs.html">CONTACT US</a>
        </div>
        <div class="right-section">
            <button class="log-in-button"><a href="login.php">LOG IN</a></button>
        </div>
    </navbar>


    <h1 class="Category">WEBSITES</h1>
    <hr class="line">
        <div class="products">
            <?php 
               $sql = "SELECT * FROM products WHERE category = 'Website'";
               $stmt = $con->prepare($sql);
               $stmt->execute();
               while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {  
            ?>
                <div class="product-card">
                    <div>
                        <img src="<?= $row['image_url'] ?>" alt="<?= $row['name']?>" class="img">
                    </div>
                    <div class="product-info"> 
                        <div>
                            <h2 class="titulli"><?= $row['name'] ?></h2>
                        </div>
                        <div class="product-details">
                            <div class="product-details-left">
                                <p class="price">$<?= $row['price'] ?></p>
                                <p class="rating"><?= $row['rating'] ?>/5☆</p>
                            </div>
                            <div class="product-details-right">
                                <button class="purchase-btn">PURCHASE</button>
                            </div>                          
                        </div>
                        
                    </div>          
                </div>
                
            <?php } ?>
        </div>
        
        <h1 class="Category2">LOGOS</h1>
        <hr class="line">
        <div class="products">
            <?php 
                $sql = "SELECT * FROM products WHERE category = 'Logo'";
                $stmt = $con->prepare($sql);
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {  
            ?>
                <div class="product-card">
                    <div>
                        <img src="<?= $row['image_url'] ?>" alt="<?= $row['name']?>" class="img">
                    </div>
                    <div class="product-info"> 
                        <div>
                            <h2 class="titulli"><?= $row['name'] ?></h2>
                        </div>
                        <div class="product-details">
                            <div class="product-details-left">
                                <p class="price">$<?= $row['price'] ?></p>
                                <p class="rating"><?= $row['rating'] ?>/5☆</p>
                            </div>
                            <div class="product-details-right">
                                <button class="purchase-btn">PURCHASE</button>
                            </div>                          
                        </div>
                        
                    </div>          
                </div>
                
            <?php } ?>
        </div>

        
</main>    
</body>  
</html>