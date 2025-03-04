<?php
session_start();

header("CONTENT_TYPE: application/json", true, 200);
include "connection.php";


$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($input["name"]) && isset($input["email"]) && isset($input["password"]) && 
        !empty($input["name"]) && !empty($input["email"]) && !empty($input["password"])) {

        $name = $input["name"];
        $email = $input["email"];
        $password = $input["password"];
        
        $user = $conn->prepare("SELECT * FROM users WHERE email ='$email'");

        if(!$user){
            echo json_encode(["message" => "Email Already Exist!"]);
            return;
        } else {
               
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
            
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashed_password);
    
             
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "Registered Successfully", "user" => $user]);
            } else {
                echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
            }
        }

          
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "All fields are required"]);
    }


 
    $conn->close();
}
?>