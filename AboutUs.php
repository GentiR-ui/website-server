<?php
session_start();

include("connection.php");
include("functions.php");

function merrPermbajtjen($renditja, $con) {
    $sql = "SELECT permbajtja FROM aboutus WHERE renditja = :renditja";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':renditja', $renditja, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? $row['permbajtja'] : null; 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADSPIRE</title>
    <link rel="stylesheet" href="faqjaKryesore.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="general.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="header.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="Aboutus.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
</head>
<body>
<navbar class="header">
        <div class="left-section">
            <img src="faqjaKryesoreImg/logo.png" class="logo">
        </div>
        <div class="middle-section">
            <a href="FaqjaKryesore.php">HOME</a>
            <li class="menu-item" id="services-menu"><a >SERVICES</a>
                <ul class="submenu-content">
                    <li><a href="MarketPlace.php">MARKETPLACE</a></li>
                </ul>
            </li>
            <a href="ourwork.php">OUR WORK</a>
            <a href="AboutUs.php">ABOUT US</a>
            <a href="contactUs.php">CONTACT US</a>
        </div>
        <div class="right-section">
            <?php
                if (isset($_SESSION['user_id'])) {
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
            <a href="ourwork.php">OUR WORK</a>
            <a href="AboutUs.php">ABOUT US</a>
            <a href="contactUs.php">CONTACT US</a>
        </div>
    </navbar>
    
    <div class="AboutUs">
        <h1>About Us</h1>
       <P>
       <?php echo merrPermbajtjen(1, $con)?>
       </P>
        
</div>
    <div class="divi">
   <div class="WhoWeAre">

    <div class="img1">

        <img src="<?php echo merrPermbajtjen(2, $con)?>">

    </div>
    <div class="divi2">
    <div class="WhoWeAre1">

        <h2>WHO WE ARE</h2>
        <h3>Unleashing Digital Potential</h3>
        <p><?php echo merrPermbajtjen(3, $con)?>
           </p>

           
    </div>


</div>

    <div class="WhoWeAre2">
           
        <div class="img2">

            <img src="<?php echo merrPermbajtjen(4, $con)?>" alt="pic2">
    
        </div>
    
        <div class="WhoWeAre3">
             <h1>Customized Digital Solutions for your Success</h1>
            <p><?php echo merrPermbajtjen(5, $con)?>
               </p>
    
               
        </div>
    </div>
        

    </div>
    </div>
    <div class="Motive">
        <h1>The Best Solutions for Your Business</h1>
       <P><?php echo merrPermbajtjen(6, $con)?>   
       </P>
        
</div>

<div class="fifth-block">
    <div class="fifth-block-left-section">
        <div class="fifth-block-left-section-title">
            <p class="wcu">WHY CHOOSE US</p>
            <h1>Our Commitment to Your Growth</h1>
            <p><?php echo merrPermbajtjen(7, $con)?></p>
        </div>
        <div class="fifth-block-left-section-block">
            <div class="fifth-block-left-section-logo">
                <img src="faqjaKryesoreIcons/checked.png" class="fifth-block-left-section-logo-img">
            </div>
            <div class="fifth-block-left-section-text">
                <h1>Comprehensive Services</h1>
                <p><?php echo merrPermbajtjen(8, $con)?></p>
            </div>
        </div>
        <div class="fifth-block-left-section-block">
            <div class="fifth-block-left-section-logo">
                <img src="faqjaKryesoreIcons/checked.png" class="fifth-block-left-section-logo-img">
            </div>
            <div class="fifth-block-left-section-text">
                <h1>Tailored Solutions</h1>
                <p><?php echo merrPermbajtjen(9, $con)?></p>
            </div>
        </div>
        <div class="fifth-block-left-section-block">
            <div class="fifth-block-left-section-logo">
                <img src="faqjaKryesoreIcons/checked.png" class="fifth-block-left-section-logo-img">
            </div>
            <div class="fifth-block-left-section-text">
                <h1>Creative Excellence</h1>
                <p><?php echo merrPermbajtjen(10, $con)?></p>
            </div>
        </div>
    </div>
    <div class="fifth-block-right-section">
        <div class="fifth-block-right-section-first-img">
            <img src="<?php echo merrPermbajtjen(11, $con)?>">
        </div>
        <div class="fifth-block-right-section-second-img">
            <img src="<?php echo merrPermbajtjen(12, $con)?>">
        </div>
        
    </div>
</div>
<div class="need-help">
    <h1>Need more help?</h1>
    <p><?php echo merrPermbajtjen(13, $con)?></p>
    <button class="need-help-button"><a href="contactUs.php">CONTACT US</a></button>
</div>
<div class="footer">
    <div class="footer-first">
        <img src="<?php echo merrPermbajtjen(14, $con)?>" class="footerImg">
        <p><?php echo merrPermbajtjen(15, $con)?></p>
    </div>
    <div class="footer-second">
        <h1>Services</h1>
        <ul class="list">
            <li><a href="">Website development</a></li>
            <li><a href="">Video Editing</a></li>
            <li><a href="">Website Menagement</a></li>
            <li><a href="">Logo Design Services</a></li>
        </ul>

        </form>
        
    </div>
    <div class="footer-third">
        <h1>Company</h1>
        <ul class="list">
            <li><a href="">Services</a></li>
            <li><a href="">Our Work</a></li>
            <li><a href="">About Us</a></li>
            <li><a href="">Contact Us</a></li>
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