<?php
session_start();

include("connection.php");
include("functions.php");


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    die;
}


if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':id', $delete_id, PDO::PARAM_INT);
    $stmt->execute();


    header("Location: adminUsers.php");
    exit();
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

if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];

    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':id', $edit_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}


if(isset($_POST['editBtn'])){
    $id = $_POST['user_id'];
    $name = $_POST['user_name'];
    $email = $_POST['user_email'];
    $user_type = $_POST['user_type'];
    $password = $_POST['password'];
    

    $sql = "UPDATE users SET user_name = :name, user_email = :email, user_type = :user_type, password = :password  WHERE user_id = :id";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->bindParam(':user_type', $user_type);
    $stmt->execute();

    header("Location: adminUsers.php");
    exit();
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
    <link rel="stylesheet" href="adminUsers.css?<?php echo time(); ?>">
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

    <h1 class="titulli">USERS</h1>

    <div class="users">
            <?php 
               $sql = "SELECT * FROM users";
               $stmt = $con->prepare($sql);
               $stmt->execute();
               while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {  
            ?>
            <div class="section_user">
                <div class="user_info">
                    <p>User ID: <?php echo $row['user_id']?></p>  
                    <p>User Name: <?php echo $row['user_name']?></p>
                    <p>Date of register: <?php echo $row['date']?></p>
                    <p>User Type: <?php echo $row['user_type']?></p>
                    <p>User Email: <?php echo $row['user_email']?></p>
                    <div class="btns">
                        <a href="adminUsers.php?delete=<?php echo $row['id'];?>" name="delete_id" class="btn" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        <a href="adminUsers.php?edit=<?php echo $row['id'];?>" name="edit_id" class="btn">Edit</a>
                    </div>
                </div>
            </div>    

            <?php } ?>
    </div>
    <div class="editUser" >
                <h3>Edit User</h3>
                <form action="adminUsers.php" method="post">
                    <input type="text" name="user_id" value="<?=$user['user_id']?>" readonly> <br> <br>
                    
                    <input type="text" name="user_name" value="<?=$user['user_name']?>"> <br> <br>
                    
                    <input type="text" name="user_email" value="<?=$user['user_email']?>"> <br> <br>
                    
                    <input type="text" name="user_type" value="<?=$user['user_type']?>"> <br> <br>
                    
                    <input type="text" name="password" value="<?=$user['password']?>"> <br> <br>

                    <input type="submit" name="editBtn" value="Save Changes"> <br> <br>
                </form>
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