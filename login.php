<?php
include "connection.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST["email"];
    $password =$_POST["password"];

    $stmt = $con->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0){
        $stmt->bind_result($id, $username, $hashed_password);
        $stmt->fetch();

        if(password_verify($password, $hashed_password)){
            $_SESSION["user_id"] = $id;
            $_SESSION["name"]= $username;

            echo json_encode(["Success" => true, "message" => "Login successful!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Invalid credentials"]);
        }
    }
    $stmt->close();
    $con->close();
}
?>
