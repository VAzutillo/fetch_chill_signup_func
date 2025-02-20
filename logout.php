<?php
session_start();

echo json_encode(["success" => true, "message" => "Logged out"]);

session_destroy();
?>