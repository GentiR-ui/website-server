<?php
    session_start();

    include("connection.php");
    include("functions.php");

    function merrPermbajtjen($renditja, $con) {
        $sql = "SELECT permbajtja FROM faqja_kryesore WHERE renditja = :renditja";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':renditja', $renditja, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['permbajtja'] : null; 
    }
    if (isset($_SESSION['user_id'])){
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
        <section class="main">
            <div class="first-block">
                
                 <video width="100%" height="100%" autoplay loop muted class="marketing-video">
                <source src="<?php echo merrPermbajtjen(3, $con)?>" type="video/mp4">
                    
                </video>
                
                <div class="text-overvideo">
                    <p>DIGITAL MARKETING AGENCY</p>
                    <h1><?php echo merrPermbajtjen(1, $con)?></h1>
                    
                    <h3><?php echo merrPermbajtjen(2, $con)?></h3>
                    <button class="first-block-button"><a href="contactUs.php">REQUEST A QUOTE</a></button>
                </div>
            
                
            </div>
            <div class="second-block">
                <div class="left-block">
                    <div class="head-part">
                        <p class="first-line">WHO WE ARE</p>
                        <h1><?php echo merrPermbajtjen(4, $con)?></h1>
                    </div>
                    <div class="main-part">
                        <p>
                        <?php echo merrPermbajtjen(5, $con)?>
                        </p>
                    </div>
                    <div class="button-part">
                        <button class="discover-more-button"><a href="AboutUs.php">DISCOVER MORE</a></button>
                    </div>
                    
                </div>
                <div class="right-block">
                    <div class="right-block-img">
                        <img src="<?php echo merrPermbajtjen(6, $con)?>" class="marketingImg">
                    </div>
                    <div class="right-block-second-img">
                        <img src="<?php echo merrPermbajtjen(7, $con)?>">
                    </div>
                    
                </div>
            </div>
            <div class="third-block">
                <div class="third-block-title">
                    <p>WHAT WE OFFER</p>
                    <h1><?php echo merrPermbajtjen(8, $con)?></h1>
                </div>
                <div class="third-block-body">
                    <div class="block-form">
                        <img src="faqjaKryesoreIcons/web-programming.png">
                        <h1 ><?php echo merrPermbajtjen(9, $con)?></h1>
                        <p ><?php echo merrPermbajtjen(10, $con)?></p>
                        <button class="block-form-button"><a href="ourwork.php">LEARN MORE</a></button>     
                    </div>
                    <div class="block-form">
                        <img src="faqjaKryesoreIcons/video-editing.png">
                        <h1 class=""><?php echo merrPermbajtjen(11, $con)?></h1>
                        <p><?php echo merrPermbajtjen(12, $con)?></p>
                        <button class="block-form-button"><a href="ourwork.php">LEARN MORE</a></button>     
                    </div>
                    <div class="block-form">
                        <img src="faqjaKryesoreIcons//digital-services.png">
                        <h1 class=""><?php echo merrPermbajtjen(13, $con)?></h1>
                        <p><?php echo merrPermbajtjen(14, $con)?></p>
                        <button class="block-form-button"><a href="ourwork.php">LEARN MORE</a></button>     
                    </div>
                    <div class="block-form">
                        <img src="faqjaKryesoreIcons/logo-design.png">
                        <h1 class=""><?php echo merrPermbajtjen(16, $con)?></h1>
                        <p><?php echo merrPermbajtjen(17, $con)?></p>
                        <button class="block-form-button"><a href="ourwork.php">LEARN MORE</a></button>     
                    </div>
                </div>
            </div>
            <div class="fourth-block">
                <h2>What's holding you back?</h2>
                <div class="slider-container">
                    <div class="slider">
                        <div class="fourth-block-body-form">
                            <img src="faqjaKryesoreIcons/smartphone.png" class="smartphone">
                            <h3>MISSED ENGAGEMENT</h3>
                            <p><?php echo merrPermbajtjen(18, $con)?></p>
                        </div>
                        <div class="fourth-block-body-form">
                            <img src="faqjaKryesoreIcons/ask.png">
                            <h3>EXPERTISE</h3>
                            <p><?php echo merrPermbajtjen(19, $con)?></p>
                        </div>
                        <div class="fourth-block-body-form">
                            <img src="faqjaKryesoreIcons/time.png">
                            <h3>LACK OF TIME</h3>
                            <p><?php echo merrPermbajtjen(20, $con)?></p>
                        </div>
                    </div>
                    <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
                    <button class="next" onclick="moveSlide(1)">&#10095;</button>
                </div>
                <hr style="border: 1px solid rgb(223, 223, 223); width: 99%; margin: 20px auto;">
                <div>
                    <img src="<?php echo merrPermbajtjen(21, $con)?>" class="fourth-block-img">
                </div>
            </div>

            <div class="fifth-block">
                <div class="fifth-block-left-section">
                    <div class="fifth-block-left-section-title">
                        <p class="wcu">WHY CHOOSE US</p>
                        <h1>Our Commitment to Your Growth</h1>
                        <p><?php echo merrPermbajtjen(22, $con)?></p>
                    </div>
                    <div class="fifth-block-left-section-block">
                        <div class="fifth-block-left-section-logo">
                            <img src="faqjaKryesoreIcons/checked.png" class="fifth-block-left-section-logo-img">
                        </div>
                        <div class="fifth-block-left-section-text">
                            <h1>Comprehensive Services</h1>
                            <p><?php echo merrPermbajtjen(23, $con)?></p>
                        </div>
                    </div>
                    <div class="fifth-block-left-section-block">
                        <div class="fifth-block-left-section-logo">
                            <img src="faqjaKryesoreIcons/checked.png" class="fifth-block-left-section-logo-img">
                        </div>
                        <div class="fifth-block-left-section-text">
                            <h1>Tailored Solutions</h1>
                            <p><?php echo merrPermbajtjen(24, $con)?></p>
                        </div>
                    </div>
                    <div class="fifth-block-left-section-block">
                        <div class="fifth-block-left-section-logo">
                            <img src="faqjaKryesoreIcons/checked.png" class="fifth-block-left-section-logo-img">
                        </div>
                        <div class="fifth-block-left-section-text">
                            <h1>Creative Excellence</h1>
                            <p><?php echo merrPermbajtjen(25, $con)?></p>
                        </div>
                    </div>
                </div>
                <div class="fifth-block-right-section">
                    <div class="fifth-block-right-section-first-img">
                        <img src="<?php echo merrPermbajtjen(26, $con)?>">
                    </div>
                    <div class="fifth-block-right-section-second-img">
                        <img src="<?php echo merrPermbajtjen(27, $con)?>">
                    </div>
                    
                </div>
            </div>
            <div class="need-help">
                <h1>Need more help?</h1>
                <p><?php echo merrPermbajtjen(28, $con)?></p>
                <button class="need-help-button"><a href="contactUs.php">CONTACT US</a></button>
            </div>
            <div class="footer">
                <div class="footer-first">
                    <img src="<?php echo merrPermbajtjen(29, $con)?>" class="footerImg">
                    <p><?php echo merrPermbajtjen(30, $con)?></p>
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
    
        </section>
    </main>

    
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
    
        let currentSlide = 0;

        function moveSlide(direction) {
            const slider = document.querySelector('.slider');
            const totalSlides = document.querySelectorAll('.fourth-block-body-form').length;
            currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
            slider.style.transform = `translateX(-${currentSlide * 100}%)`;
        }
        
        </script>
  
</body>
</html>