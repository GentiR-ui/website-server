<?php 
    session_start();

    include("connection.php"); 
    include("functions.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        try {
            
            $sql = "INSERT INTO contact_form (name, email, subject, message) VALUES (:name, :email, :subject, :message)";
            $stmt = $con->prepare($sql);

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':subject', $subject);
            $stmt->bindParam(':message', $message);

            $stmt->execute();
            
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function merrPermbajtjen($renditja, $con) {
        $sql = "SELECT permbajtja FROM contactus WHERE renditja = :renditja";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':renditja', $renditja, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['permbajtja'] : null; 
    }

    $sql = "SELECT * FROM contact_info";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $contactInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="header.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="general.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="contactUs.css?<?php echo time(); ?>">
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
    <main class="main"> 
        <div class="first-block">
            <img class="contactImg" src="<?php echo merrPermbajtjen(1, $con)?>">
            <h1><?php echo merrPermbajtjen(2, $con)?></h1>
            <p><?php echo merrPermbajtjen(3, $con)?></p>
        </div>
        <div class="sc-block">
                <h2><?php echo merrPermbajtjen(4, $con)?></h2>
                <div class="contact-details">
                    <div class="detail-item">
                        <h3><?php echo merrPermbajtjen(5, $con)?></h3>
                        <?php
                            foreach ($contactInfo as $info) {
                                echo '<p>' . $info['Adress'] . '</p>';
                            }
                        ?>
                    </div>
                    <div class="detail-item">
                        <h3><?php echo merrPermbajtjen(6, $con)?></h3>
                        <?php
                            foreach ($contactInfo as $info) {
                                echo '<p>' . $info['Contact'] . '</p>';
                            }
                        ?>
                    </div>
                    <div class="detail-item">
                        <h3><?php echo merrPermbajtjen(7, $con)?></h3>
                        <?php
                            foreach ($contactInfo as $info) {
                                echo '<p>' . $info['Hours'] . '</p>';
                            }
                        ?>
                    </div>
                </div>

        </div>
        <div class="th-block">
            <div class="message">
                <h1><?php echo merrPermbajtjen(8, $con)?></h1>
                <p>
                <?php echo merrPermbajtjen(9, $con)?>
                </p>
            </div>
            
            <div class="container">
                    <form id="contact" method="POST">
                        <div class="form-group">
                            <input type="text" id="name" name="name" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" id="email" name="email" placeholder="Your Email" required>
                        </div>
                        <div class="form-group">
                            <input type="text" id="subject" name="subject" placeholder="Subject" required>
                        </div>
                        <div class="form-group">
                            <textarea id="message" name="message" rows="5" placeholder="Your Message" required></textarea>
                        </div>
                        <button class="sendMessage" type="submit">Send Message</button>
                    </form>
            </div>
            
        </div>
    </main>
    <div class="footer">
                <div class="footer-first">
                    <img src="<?php echo merrPermbajtjen(10, $con)?>" class="footerImg">
                    <p><?php echo merrPermbajtjen(11, $con)?></p>
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
                        <li><a href="contactUs.php">Contact Us</a></li>
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