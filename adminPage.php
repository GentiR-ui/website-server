<?php
session_start();

include("connection.php");
include("functions.php");

// Kontrollo nëse përdoruesi është i loguar
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    die;
}

try {
    $user_id = trim($_SESSION['user_id']);
    $user_id = (int)$user_id; // Sigurohuni që user_id është numerik

    // Pyetja e përgatitur për të marrë të dhënat e përdoruesit
    $query = "SELECT * FROM users WHERE user_id = :user_id";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    // Kontrollo nëse përdoruesi ekziston
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
            <a href="FaqjaKryesore.html">HOME</a>
            <li class="menu-item" id="services-menu"><a href="Services.html">SERVICES</a>
                <ul class="submenu-content">
                    <li><a href="MarketPlace.html">MARKETPLACE</a></li>
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
    </navbar>  
    <div class="dashboard">
        <div class="detail">
            <h1>ADMIN DASHBOARD</h1>
        </div>
    </div>  

    <script>
    // Merr ikonën dhe div-in
    const userBtn = document.getElementById("user-btn");
    const userBox = document.getElementById("myDiv");

    // Event listener për të hapur/mbyllur div-in
    userBtn.addEventListener("click", (e) => {
        e.stopPropagation(); // Parandalon që klikimi të shpërndahet
        if (userBox.style.display === "block") {
            userBox.style.display = "none";
        } else {
            userBox.style.display = "block";
        }
    });

    // Mbyll div-in kur klikon diku tjetër
    document.addEventListener("click", (e) => {
        if (!userBox.contains(e.target) && e.target !== userBtn) {
            userBox.style.display = "none";
        }
    });
</script>

</body>
</html>

