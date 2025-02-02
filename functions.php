<?php





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