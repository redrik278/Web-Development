<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION["userID"]) || $_SESSION["userType"] !== 'admin') {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "RouteMaster";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $routeName = isset($_POST["routeName"]) ? $_POST["routeName"] : "";
    $routeDescription = isset($_POST["routeDescription"]) ? $_POST["routeDescription"] : "";
    $totalDuration = isset($_POST["totalDuration"]) ? $_POST["totalDuration"] : "";
    $totalDistance = isset($_POST["totalDistance"]) ? $_POST["totalDistance"] : "";
    $stopNames = isset($_POST["stopName"]) ? $_POST["stopName"] : [];
    $ticketTypes = isset($_POST["ticketType"]) ? $_POST["ticketType"] : [];
    $ticketPrices = isset($_POST["ticketPrice"]) ? $_POST["ticketPrice"] : [];

    // Insert route information into the bus_routes table
    $insertRouteQuery = "INSERT INTO bus_routes (RouteName, RouteDescription, TotalDuration, TotalDistance) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertRouteQuery);
    $stmt->bind_param("ssss", $routeName, $routeDescription, $totalDuration, $totalDistance);
    $stmt->execute();
    $routeID = $stmt->insert_id;
    $stmt->close();

    // Insert stop information into the bus_stops table
    foreach ($stopNames as $stopName) {
        $insertStopQuery = "INSERT INTO bus_stops (StopName) VALUES (?)";
        $stmt = $conn->prepare($insertStopQuery);
        $stmt->bind_param("s", $stopName);
        $stmt->execute();
        $stopID = $stmt->insert_id;
        $stmt->close();

        // Insert route-stop relationship into the route_stops table
        $insertRouteStopQuery = "INSERT INTO route_stops (RouteID, StopID) VALUES (?, ?)";
        $stmt = $conn->prepare($insertRouteStopQuery);
        $stmt->bind_param("ii", $routeID, $stopID);
        $stmt->execute();
        $stmt->close();
    }

    // Insert ticket price information into the ticket_prices table
    foreach ($ticketTypes as $index => $ticketType) {
        $ticketPrice = $ticketPrices[$index];
        $insertTicketPriceQuery = "INSERT INTO ticket_prices (RouteID, TicketType, PriceAmount) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertTicketPriceQuery);
        $stmt->bind_param("iss", $routeID, $ticketType, $ticketPrice);
        $stmt->execute();
        $stmt->close();
    }

    // Clear form fields
    $_POST = array();

    // Set a success message
    $successMessage = "Bus information added successfully!";
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Bus Information</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <a class="navbar-brand" href="/">RouteMaster</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <?php if (isset($_SESSION["userID"])): ?>
                    <!-- Common Navigation Links for both Users and Admins -->
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION["userID"]) && $_SESSION["userType"] === 'admin'): ?>
                    <!-- Admin Navigation Links -->
                    <li class="nav-item">
                        <a class="nav-link" href="add_bus_info.php">Add Bus Info</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

<div class="container mt-5">
    <h2>Add Bus Information</h2>
    <?php if (isset($successMessage)): ?>
        <!-- Display success message if it's set -->
        <div class="alert alert-success">
            <?php echo $successMessage; ?>
        </div>
    <?php endif; ?>
    <form action="add_bus_info.php" method="post">
        <!-- Input field for route name -->
        <div class="form-group">
            <label for="routeName">Route Name:</label>
            <input type="text" class="form-control" id="routeName" name="routeName" required value="<?php echo $routeName; ?>">
        </div>

        <!-- Input field for route description -->
        <div class="form-group">
            <label for="routeDescription">Route Description:</label>
            <textarea class="form-control" id="routeDescription" name="routeDescription"><?php echo $routeDescription; ?></textarea>
        </div>

        <!-- Input field for total duration -->
        <div class="form-group">
            <label for="totalDuration">Total Duration:</label>
            <input type="text" class="form-control" id="totalDuration" name="totalDuration" value="<?php echo $totalDuration; ?>">
        </div>

        <!-- Input field for total distance -->
        <div class="form-group">
            <label for="totalDistance">Total Distance:</label>
            <input type="number" class="form-control" id="totalDistance" name="totalDistance" required value="<?php echo $totalDistance; ?>">
        </div>

        <!-- Input fields for bus stops -->
        <div id="stopFields">
            <?php if (!empty($stopNames)): ?>
                <?php foreach ($stopNames as $stop): ?>
                    <div class="form-group">
                        <label for="stopName">Stop Name:</label>
                        <input type="text" class="form-control" name="stopName[]" required value="<?php echo $stop; ?>">
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="form-group">
                    <label for="stopName">Stop Name:</label>
                    <input type="text" class="form-control" name="stopName[]" required>
                </div>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-primary" id="addStop">Add Another Stop</button>
        </div>

        <!-- Input fields for ticket prices -->
        <div id="ticketPriceFields">
            <?php if (!empty($ticketTypes)): ?>
                <?php foreach ($ticketTypes as $index => $ticketType): ?>
                    <div class="form-group ticket-price-field">
                        <label for="ticketType">Ticket Type:</label>
                        <input type="text" class="form-control" name="ticketType[]" required value="<?php echo $ticketType; ?>">
                        <label for="ticketPrice">Ticket Price:</label>
                        <input type="number" class="form-control" name="ticketPrice[]" required value="<?php echo $ticketPrices[$index]; ?>">
                        <button type="button" class="btn btn-danger remove-ticket-price">Remove</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="form-group ticket-price-field">
                    <label for="ticketType">Ticket Type:</label>
                    <input type="text" class="form-control" name="ticketType[]" required>
                    <label for="ticketPrice">Ticket Price:</label>
                    <input type="number" class="form-control" name="ticketPrice[]" required>
                    <button type="button" class="btn btn-danger remove-ticket-price">Remove</button>
                </div>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-primary" id="addTicketPrice">Add Another Ticket Price</button>
        </div>

        <button type="submit" class="btn btn-primary">Add Bus Information</button>
    </form>
</div>

<!-- Include Bootstrap JS and your JavaScript code -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- ... (your JavaScript code) ... -->
</body>
</html>
