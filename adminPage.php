<?php
session_start();

include("connection.php");
include("functions.php");


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    die;
}

try {
    $user_id = trim($_SESSION['user_id']);
    $user_id = (int)$user_id; 

    $query = "SELECT * FROM users WHERE user_id = :user_id";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    
    if ($stmt->rowCount() > 0) {
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        die("User not found.");
    }
} catch (PDOException $e) {
    die("Gabim në query: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="header.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="adminPage.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="general.css?<?php echo time(); ?>">
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
    <div class="dashboard">
        <div class="detail">
            <h1>ADMIN DASHBOARD</h1>
        </div>
        
        <div class="boxes">
            <div class="box">
                <?php
                    $select_orders = "SELECT * FROM orders";
                    $num_of_orders = $con->prepare($select_orders);
                    $num_of_orders->execute();
                    
                ?>
                <h2>ORDERS</h2>
                <p><?php echo $num_of_orders->rowCount();?></p>
            </div>
            <div class="box">
                <?php
                    $select_products = "SELECT * FROM products";
                    $num_of_products = $con->prepare($select_products);
                    $num_of_products->execute();
                    
                ?>
                <h2>NUMBER OF PRODUCTS</h2>
                <p><?php echo $num_of_products->rowCount();?></p>
            </div>
            <div class="box">
                <?php
                    $select_users = "SELECT * FROM users WHERE user_type = 'user'";
                    $num_of_users = $con->prepare($select_users);
                    $num_of_users->execute();
                    
                ?>
                <h2>NUMBER OF USERS</h2>
                <p><?php echo $num_of_users->rowCount();?></p>
            </div>
            <div class="box">
                <?php
                    $select_messages = "SELECT * FROM contact_form";
                    $num_of_msg = $con->prepare($select_messages);
                    $num_of_msg->execute();
                    
                ?>
                <h2>NUMBER OF MESSAGES</h2>
                <p><?php echo $num_of_msg->rowCount();?></p>
            </div>
        </div>

            <style>
                .contact-info {
                    background-color: #f9f9f9;
                    border: 1px solid #ddd;
                    padding: 20px;
                    margin-top: 20px;
                    border-radius: 5px;
                }

                .contact-info h2 {
                    margin-bottom: 15px;
                    text-align: center;
                    font-size: 24px;
                    color: #333;
                }

                .contact-info p {
                    margin: 5px 0;
                    font-size: 18px;
                    color: #555;
                }

                .contact-info p strong {
                    color: #000;
                }
            </style>
            
                
                <?php
                    $select_all_contact_info = "SELECT * FROM contact_info";
                    $all_contact_info_stmt = $con->prepare($select_all_contact_info);
                    $all_contact_info_stmt->execute();
                    ?><div class="contact-info">
                    <h2>Contact Info</h2>
                    <?php
                    while ($row = $all_contact_info_stmt->fetch(PDO::FETCH_ASSOC)) {
                        
                        echo "<p><strong>Address:</strong> " . $row['Adress'] . "</p>";
                        echo "<p><strong>Contact:</strong> " . $row['Contact'] . "</p>";
                        echo "<p><strong>Hours:</strong> " . $row['Hours'] . "</p>";
                        
                    }?>
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

