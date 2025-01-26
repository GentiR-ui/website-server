<?php
session_start();
include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Merr të dhënat nga forma
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        try {
            // Përdor një pyetje të përgatitur për të lexuar nga databaza
            $query = "SELECT * FROM users WHERE user_name = :user_name LIMIT 1";
            $stmt = $con->prepare($query);
            $stmt->bindParam(':user_name', $user_name);
            $stmt->execute();

            

            if ($stmt->rowCount() > 0) {
                $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

                // Kontrollo për admin dhe fjalëkalimin
                if ($user_data['user_name'] === 'admin') {
                    if (password_verify($password, $user_data['password'])) {
                        $_SESSION['user_id'] = $user_data['user_id'];
                        $_SESSION['user_name'] = $user_data['user_name'];
                        header("Location: adminPage.php");
                        die;
                    } else {
                        $error_message = "Incorrect password";
                    }
                } 
                // Kontroll për përdorues normal
                else if (password_verify($password, $user_data['password'])) {
                    $_SESSION['user_id'] = $user_data['user_id'];
                    $_SESSION['user_name'] = $user_data['user_name'];
                    header("Location: faqjaKryesore.php");
                    die;
                } else {
                    $error_message = "Incorrect password.";
                }
            } else {
                $error_message = "This user doesn't exist.";
            }
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    } else {
        $error_message = "Please enter valid username and password.";
    }
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css?<?php echo time(); ?>">
</head>
<body>
    <style>
        .error_message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }
    </style>
    <!-- Login Form -->
    <div class="form-container" id="login-form">
        <div class="form-card">
            <img src="faqjaKryesoreImg/logo.png" class="form-logo">
            <h2>LOG IN</h2>
            <form id="login" method="post">
                <div class="input-group">
                    <label for="login-email">Username or Email</label>
                    <input type="text" id="login-email" placeholder="Enter your email" required name="user_name">
                    <?php if(isset($error_message)): ?>
                    <div class="error_message"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                </div>
                <div class="input-group">
                    <label for="login-password">Password</label>
                    <input type="password" id="login-password" placeholder="Enter your password" required name="password">
                </div>
                <button type="submit" class="btn" value="login">Login</button>
                <p class="switch-form">Don't have an account? <a style="color:rgb(9, 94, 179);"  href="signup.php">Register</a></p>
            </form>
        </div>
    </div>


    <script src="script.js"></script>
</body>
</html>
