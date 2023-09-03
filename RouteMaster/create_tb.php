<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "RouteMaster";

// Create a connection
$conn = new mysqli($servername, $username, $password);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database
$createDatabaseQuery = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($createDatabaseQuery) === TRUE) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . $conn->error;
    $conn->close();
    exit();
}

// Select the created database
$conn->select_db($database);

// Define your SQL queries
$sqlQueries = [
    "CREATE TABLE IF NOT EXISTS bus_routes (
        RouteID INT AUTO_INCREMENT PRIMARY KEY,
        RouteName VARCHAR(255),
        RouteDescription TEXT,
        TotalDuration TIME,
        TotalDistance FLOAT
    )",
    "CREATE TABLE IF NOT EXISTS bus_stops (
        StopID INT AUTO_INCREMENT PRIMARY KEY,
        StopName VARCHAR(255),
        Latitude FLOAT,
        Longitude FLOAT
    )",
    "CREATE TABLE IF NOT EXISTS route_stops (
        RouteStopID INT AUTO_INCREMENT PRIMARY KEY,
        RouteID INT,
        StopID INT,
        StopOrder INT,
        FOREIGN KEY (RouteID) REFERENCES bus_routes(RouteID),
        FOREIGN KEY (StopID) REFERENCES bus_stops(StopID)
    )",
    "CREATE TABLE IF NOT EXISTS ticket_prices (
        PriceID INT AUTO_INCREMENT PRIMARY KEY,
        RouteID INT,
        TicketType VARCHAR(50),
        PriceAmount DECIMAL(10, 2),
        FOREIGN KEY (RouteID) REFERENCES bus_routes(RouteID)
    )",
    "CREATE TABLE IF NOT EXISTS users (
        UserID INT AUTO_INCREMENT PRIMARY KEY,
        Username VARCHAR(50),
        Email VARCHAR(255),
        Password VARCHAR(255),
        UserType ENUM('admin', 'user'),
        OtherUserInfo TEXT
    )",
    "CREATE TABLE IF NOT EXISTS bookings (
        BookingID INT AUTO_INCREMENT PRIMARY KEY,
        RouteID INT,
        UserID INT,
        BookingDate DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (RouteID) REFERENCES bus_routes(RouteID),
        FOREIGN KEY (UserID) REFERENCES users(UserID)
    )"
    // Add more queries if needed
];

// Execute SQL queries
foreach ($sqlQueries as $query) {
    if ($conn->query($query) === TRUE) {
        echo "Table created successfully\n";
    } else {
        echo "Error creating table: " . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
