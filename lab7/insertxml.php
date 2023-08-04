<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbred";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$xmlContent = file_get_contents('lab7.xml');

$xml = new SimpleXMLElement($xmlContent);

foreach ($xml->planet as $planet) {
    $name = $planet->name;
    $magnitude = (float) $planet->magnitude;
    $distance = (int) $planet->distance;

    $sql = "INSERT INTO galaxy (name, magnitude, distance) VALUES ('$name', $magnitude, $distance)";
    $conn->query($sql);
}

echo "Data inserted successfully.";

$conn->close();
?>
