<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbred";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    echo "connection successfull<br>";
}

// Create the database if it doesn't exist
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql_create_db) === TRUE) {
    echo "Database created successfully.<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select the database
$conn->select_db($dbname);

// Create the 'stars' table if it doesn't exist
$sql_create_table = "CREATE TABLE IF NOT EXISTS galaxy (
    name VARCHAR(255),
    magnitude FLOAT,
    distance INT
)";

if ($conn->query($sql_create_table) === TRUE) {
    echo "Table created successfully.<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Read the XML content from the file
$xmlContent = file_get_contents('lab7.xml');

// Parse the XML content
$xml = new SimpleXMLElement($xmlContent);

// Prepare and execute the insert query for each planet
foreach ($xml->planet as $planet) {
    $name = $conn->real_escape_string((string) $planet->name);
    $magnitude = (float) $planet->magnitude;
    $distance = (int) $planet->distance;

    $sql = "INSERT INTO galaxy (name, magnitude, distance) VALUES ('$name', '$magnitude', '$distance')";
    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully for planet: $name<br>";
    } else {
        echo "Error inserting data for planet: $name - " . $conn->error . "<br>";
    }
}

$conn->close();
?>
