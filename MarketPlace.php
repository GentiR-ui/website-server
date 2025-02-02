<?php
    session_start();

    include 'connection.php';
    include 'functions.php';

    if (!isset($_SESSION['user_id'])) {
    
        header("Location: login.php");
        exit();
    }
    if (isset($_POST['order'])) {
        $_SESSION['ordered_products'][] = $_POST['product_name'];
    }
    if (isset($_POST['order'])) {
        
        if (isset($_SESSION['user_name']) && isset($_SESSION['user_email'])) {
            $user_id = $_SESSION['user_id'];
            $user_name = $_SESSION['user_name'];
            $user_email = $_SESSION['user_email'];
            $product_name = $_POST['product_name'];
            $product_price = $_POST['product_price'];
    
            
            $sql = "INSERT INTO orders (user_id, user_name, user_email, product_name, product_price) VALUES (:user_id ,:user_name, :user_email, :product_name, :product_price)";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':user_name', $user_name);
            $stmt->bindParam(':user_email', $user_email);
            $stmt->bindParam(':product_name', $product_name);
            $stmt->bindParam(':product_price', $product_price);
            $stmt->execute();
    
            
        } 
    } 
    
    


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="general.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="header.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="MarketPlace.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
</head>

<body>
<navbar class="header">
        <div class="left-section">
            <img src="faqjaKryesoreImg/logo.png" class="logo">
        </div>
        <div class="middle-section">
            <a href="FaqjaKryesore.php">HOME</a>
            <li class="menu-item" id="services-menu"><a href="">SERVICES</a>
                <ul class="submenu-content">
                    <li><a href="MarketPlace.php">MARKETPLACE</a></li>
                </ul>
            </li>
            <a href="OurWork.php">OUR WORK</a>
            <a href="AboutUs.php">ABOUT US</a>
            <a href="ContactUs.php">CONTACT US</a>
        </div>
        <div class="right-section">
            <?php
                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];
                    $user_sql = "SELECT * FROM users WHERE user_id = ?";
                    $user_stmt = $con->prepare($user_sql);
                    $user_stmt->execute([$user_id]);
                    $user_data = $user_stmt->fetch(PDO::FETCH_ASSOC);
                    echo '
                        <div class="icons">
                        <i class="bi bi-person" id="user-btn"></i>
                        <i class="bi bi-list" id="menu-btn"></i>
                        </div>   
                        <ul class="user-box" id="myDiv">
                        <p>Username : <span>' . $user_data["user_name"] . '</span></p>
                        <p>Email : <span>' . $user_data["user_email"] . '</span></p>
                        <form action="logout.php" method="post">
                        <button type="submit" class="btn" value="logout">Logout</button>
                        </form>      
                        </ul> 
                    ';
                } else {
                    echo '
                    <button class="log-in-button"><a href="login.php">LOG IN</a></button>
                    <div class="icons">
                        <i class="bi bi-list" id="menu-btn"></i>
                    </div>  
                    ';
                }
            ?>
            
            
        </div>
        <div class="mid">
            <a href="FaqjaKryesore.php">HOME</a>
            <a href="MarketPlace.php">MARKETPLACE</a>
            <a href="OurWork.php">OUR WORK</a>
            <a href="AboutUs.php">ABOUT US</a>
            <a href="ContactUs.php">CONTACT US</a>
        </div>
    </navbar>

    <main>           
    <h1 class="Category">WEBSITES</h1>
    <hr class="line">
        <div class="products">
            <?php 
               $sql = "SELECT * FROM products";
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
                                <form method="post">
                                    <input type="hidden" name="product_name" value="<?= $row['name'] ?>">
                                    <input type="hidden" name="product_price" value="<?= $row['price'] ?>">
                                    <button type="submit" name="order" class="purchase-btn">ORDER</button>
                                    
                                </form>
                            </div>       

                        </div>
                        
                    </div>          
                </div>
                
            <?php } ?>
        </div>
        <div class="orderForm">

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
                                <form method="post">
                                <form method="post">
                                    <input type="hidden" name="product_name" value="<?= $row['name'] ?>">
                                    <input type="hidden" name="product_price" value="<?= $row['price'] ?>">
                                    <button type="submit" name="order" class="purchase-btn">ORDER</button>
                                </form>
                                </form>
                            </div>                          
                        </div>
                        
                    </div>          
                </div>
                
            <?php } ?>
        </div>
        </main> 
        <div class="footer">
                <div class="footer-first">
                    <img src="faqjaKryesoreImg/logo.png" class="footerImg">
                    <p>We help you grow and get recognized through digital marketing. 
                        Our mission is to help build and elevate your business, as if it were our own.</p>
                </div>
                <div class="footer-second">
                    <h1>Services</h1>
                    <ul class="list">
                        <li><a href="MarketPlace.php">MarketPlace</a></li>
                    </ul>

                    </form>
                    
                </div>
                <div class="footer-third">
                    <h1>Company</h1>
                    <ul class="list">
                        <li><a href="ourwork.php">Our Work</a></li>
                        <li><a href="AboutUs.php">About Us</a></li>
                        <li><a href="ContactUs.php">Contact Us</a></li>
                    </ul>
                </div>
                <div class="footer-fourth">
                    <h1>Contacts</h1>
                    <ul class="list">
                        <li>Address: Prishtine,Kosova</li>
                        <li>E-mail: info@adspire.org </li>
                        <li>Phone / WhatsApp: +383 111 111</li>
                    </ul>
                </div>
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