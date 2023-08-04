<?php

//connecting to the database
$servername = "localhost";
$username = "root";
$password="";
$database="summer2023";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Die if connection was not successful
if(!$conn){
    die("Sorry we failed to connect: ". mysqli_connect_error());
}
else{
    echo "Connection was successful";
}


// Create a table database
$sql = "CREATE TABLE user (
    id INT AUTO_INCREMENT,
    name VARCHAR(30),
    email VARCHAR(255),
    password VARCHAR(255),
    ip_address VARCHAR(255),
    website VARCHAR(255),
    dob DATE,
    gender ENUM('male', 'female', 'other'),
    mobile_number VARCHAR(20),
    brief_info TEXT,
    PRIMARY KEY (id)
)";
$result = mysqli_query($conn, $sql);

// Check for the database creation success
if($result){
    echo "The table was created succesfull <br>";
}
else{
    echo "The table was not created succesfull because of this error---> ".mysqli_error($conn);
}
?>
