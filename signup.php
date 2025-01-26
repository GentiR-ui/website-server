<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Kontrollo nëse përdoruesi është i kyçur
if (isset($_SESSION['user_id'])) {
    header("Location: faqjaKryesore.php");
    die;
    return;
}

include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Merr të dhënat nga forma
    $user_name = trim($_POST['user_name']);
    $user_email = trim($_POST['user_email']);
    $password = $_POST['password'];
    $retypePassword = $_POST['retypePassword'];

    if (!empty($user_name) && !empty($user_email) && !empty($password) && !is_numeric($user_name) && !empty($retypePassword) && $password === $retypePassword) {
        try {
            // Kontrollo nëse email-i ekziston në databazë
            $query = "SELECT * FROM users WHERE user_email = :user_email LIMIT 1";
            $stmt = $con->prepare($query);
            $stmt->bindParam(':user_email', $user_email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $message = "User with this email already exists!";
            } else {
                // Gjenero një ID të rastësishme për përdoruesin
                $user_id = random_num(20);

                // Hasho fjalëkalimin
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Ruaj të dhënat e reja në databazë
                $query = "INSERT INTO users (user_id, user_name, user_email, password) 
                          VALUES (:user_id, :user_name, :user_email, :password)";
                $stmt = $con->prepare($query);

                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':user_name', $user_name);
                $stmt->bindParam(':user_email', $user_email);
                $stmt->bindParam(':password', $hashed_password);

                $stmt->execute();

                // Ridrejto përdoruesin në faqen e kyçjes
                header("Location: login.php");
                die;
            }
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    } else {
        $message = "Please fill in all fields and ensure passwords match.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="login.css?<?php echo time(); ?>">
</head>
<body>
    <style>
        .alert-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }
    </style>
    <!-- Register Form -->
    <div class="form-container" id="register-form">
        <div class="form-card">
            <img src="faqjaKryesoreImg/logo.png"class="form-logo" action="register.php" method="POST">
            <h2>REGISTER</h2>
            <form id="register" method="post">
                <div class="input-group">
                    <label for="register-name">Full Name</label>
                    <input type="text" id="register-name" name="user_name" placeholder="Enter your full name" required>
                    <?php if(isset($message)): ?>
                    <div class="alert-message"><?php echo $message; ?></div>
                    <?php endif; ?>
                </div>
                <div class="input-group">
                    <label for="register-email">Email</label>
                    <input type="email" id="register-email" placeholder="Enter your email" required name="user_email">
                </div>
                <div class="input-group">
                    <label for="register-password">Password</label>
                    <input type="password" id="register-password" placeholder="Enter your password" required name="password">
                </div>
                <div class="input-group">
                    <label for="register-retype-password">Retype Password</label>
                    <input type="password" id="register-retype-password" placeholder="Retype your password" required name="retypePassword">
                </div>
                <button type="submit" class="btn" value="Signup" action="signup.php">Register</button>
                <p class="switch-form">Already have an account? <a style="color:rgb(9, 94, 179);" href="login.php">Login</a></p>
            </form>
        </div>
    </div>

    <script src="script.js?<?php echo time(); ?>"></script>
</body>
</html>
