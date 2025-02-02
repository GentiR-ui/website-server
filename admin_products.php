<?php
session_start();

include("connection.php");
include("functions.php");


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    die;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = trim($_POST['product_name']);
    $product_price = trim($_POST['product_price']);
    $product_image = trim($_POST['product_image']);
    $category = trim($_POST['Category']);
    $sales = trim($_POST['sales']);
    $rating = trim($_POST['Rating']);

    
    if (!empty($product_name) && !empty($product_price) && !empty($product_image) && !empty($category) && !empty($sales) && !empty($rating)) {

     
        $sql = "INSERT INTO products (name, price, image_url, category, sales, rating) VALUES (:name, :price, :image_url, :category, :sales, :rating)";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':name', $product_name);
        $stmt->bindParam(':price', $product_price);
        $stmt->bindParam(':image_url', $product_image);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':sales', $sales);
        $stmt->bindParam(':rating', $rating);
        $stmt->execute();

  
        header("Location: admin_products.php");
        exit();
    } else {
        echo "Please fill all fields.";
    }
}
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $sql = "DELETE FROM products WHERE id = :id";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':id', $delete_id, PDO::PARAM_INT);
    $stmt->execute();

   
    header("Location: admin_products.php");
    exit();
}



if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];

    $sql = "SELECT * FROM products WHERE id = :id";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':id', $edit_id, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetch(PDO::FETCH_ASSOC);
}


if(isset($_POST['editBtn'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $img = $_POST['image_url'];
    $category = $_POST['category'];
    $sales = $_POST['sales'];
    $rating = $_POST['rating'];
    
    if (!empty($name) && !empty($price) && !empty($img) && !empty($category) && !empty($sales) && !empty($rating)) {
        $sql = "UPDATE products SET name = :name, price = :price, image_url = :image_url, category = :category, sales = :sales, rating = :rating WHERE id = :id";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':image_url', $img, PDO::PARAM_STR);
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        $stmt->bindParam(':sales', $sales, PDO::PARAM_INT);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_STR);
        $stmt->execute();

        header("Location: admin_products.php");
        exit();
    } else {
        echo "Please fill all fields.";
    }
    
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
    <link rel="stylesheet" href="admin_products.css?<?php echo time(); ?>">
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
                                <a href="admin_products.php?delete=<?php echo $row['id'];?>" name="delete_id" class="btn" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                                <a href="admin_products.php?edit=<?php echo $row['id'];?>" name="edit_id" class="btn">Edit</a>
                            </div>                          
                        </div>
                        
                    </div>          
                </div>
                
            <?php } ?>
        </div>

        <form action="" method="post" enctype="multipart/form-data">
            <h2 class="addProd">ADD PRODUCT</h2>
            <div class="addProduct">
                <div class="input">  
                    <label for="product_name">Product Name:</label>
                    <input class="inputt" type="text" name="product_name" placeholder="Product Name">
                </div>  
                <div class="input">
                    <label for="product_price">Product Price:</label>
                    <input class="inputt" type="text" name="product_price" placeholder="Product Price">
                </div>
                <div class="input">
                    <label for="product_image">Product Image Link:</label>
                    <input class="inputt" type="text" name="product_image" placeholder="Product Image Link">
                </div>
                <div class="input">
                    <label for="Category">Category:</label>
                    <input class="inputt" type="text" name="Category" placeholder="Category">
                </div>
                <div class="input">
                    <label for="sales">Sales:</label>
                    <input class="inputt" type="text" name="sales" placeholder="Sales">
                </div>
                <div class="input">
                    <label for="Rating">Rating:</label>
                    <input class="inputt" type="text" name="Rating" placeholder="Rating">
                </div>
                <?php
                
                ?>
                <button type="submit" class="btn" value="Add Product">Add Product</button>
            </div>
        </form>  
        
        <div class="editProducts" >
                <h3>Edit Products</h3>
                <form action="admin_products.php" method="post">
                    <input type="hidden" name="id" value="<?=$products['id']?>" readonly> <br> <br>
                    
                    <input type="text" name="name" value="<?=$products['name']?>"> <br> <br>
                    
                    <input type="text" name="price" value="<?=$products['price']?>"> <br> <br>
                    
                    <input type="text" name="image_url" value="<?=$products['image_url']?>"> <br> <br>
                    
                    <input type="text" name="category" value="<?=$products['category']?>"> <br> <br>
                    
                    <input type="text" name="sales" value="<?=$products['sales']?>"> <br> <br>
                    
                    <input type="text" name="rating" value="<?=$products['rating']?>"> <br> <br>

                    <input type="submit" name="editBtn" value="Save Changes"> <br> <br>
                </form>
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