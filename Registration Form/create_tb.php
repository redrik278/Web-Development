<?php

$servername = "localhost";  
$username = "root";  
$password = "";  

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS registration";
if ($conn->query($sql) !== TRUE) {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db("registration");

// SQL to create table
$sql = "
CREATE TABLE IF NOT EXISTS Users (
    ID INT NOT NULL AUTO_INCREMENT,
    Name VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    UserType VARCHAR(255) NOT NULL,
    PRIMARY KEY (ID)
)";

if ($conn->query($sql) !== TRUE) {
    die("Error creating table: " . $conn->error);
}

echo "Database and table checked/created successfully.";

$conn->close();

?>
