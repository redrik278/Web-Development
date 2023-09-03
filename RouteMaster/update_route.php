<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "RouteMaster";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateRoute"])) {
    $routeID = $_POST["routeID"];
    $routeName = $_POST["routeName"];
    $totalDistance = $_POST["totalDistance"];
    $ticketType = $_POST["ticketType"];
    $priceAmount = $_POST["priceAmount"];

    // Update route information in the bus_routes table
    $updateRouteQuery = "UPDATE bus_routes SET RouteName = ?, TotalDistance = ? WHERE RouteID = ?";
    $stmt = $conn->prepare($updateRouteQuery);
    $stmt->bind_param("sdi", $routeName, $totalDistance, $routeID);

    if ($stmt->execute()) {
        // Update ticket price information in the ticket_prices table
        $updatePriceQuery = "UPDATE ticket_prices SET PriceAmount = ? WHERE RouteID = ? AND TicketType = ?";
        $stmt2 = $conn->prepare($updatePriceQuery);
        $stmt2->bind_param("dis", $priceAmount, $routeID, $ticketType);

        if ($stmt2->execute()) {
            $message = "Route information updated successfully!";
        } else {
            $message = "Error updating route information: " . $stmt2->error;
        }

        $stmt2->close();
    } else {
        $message = "Error updating route information: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch route information for the specified routeID
if (isset($_GET["routeID"])) {
    $routeID = $_GET["routeID"];

    $getRouteQuery = "SELECT br.RouteID, br.RouteName, br.TotalDistance, tp.TicketType, tp.PriceAmount
                      FROM bus_routes br
                      LEFT JOIN ticket_prices tp ON br.RouteID = tp.RouteID
                      WHERE br.RouteID = ?";
    $stmt = $conn->prepare($getRouteQuery);
    $stmt->bind_param("i", $routeID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $routeName = $row["RouteName"];
        $totalDistance = $row["TotalDistance"];
        $ticketType = $row["TicketType"];
        $priceAmount = $row["PriceAmount"];
    } else {
        // Route not found, handle the error here
        header("Location: index.php"); // Redirect to the homepage or an error page
        exit();
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Route</title>
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
                        <a class="nav-link" href="homepage.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Update Route Information</h2>
        <p><?php echo $message; ?></p>
        <form method="POST" action="">
            <input type="hidden" name="routeID" value="<?php echo $routeID; ?>">
            <div class="form-group">
                <label for="routeName">Route Name:</label>
                <input type="text" class="form-control" id="routeName" name="routeName" value="<?php echo $routeName; ?>">
            </div>
            <div class="form-group">
                <label for="totalDistance">Total Distance:</label>
                <input type="number" class="form-control" id="totalDistance" name="totalDistance" value="<?php echo $totalDistance; ?>">
            </div>
            <div class="form-group">
                <label for="ticketType">Ticket Type:</label>
                <input type="text" class="form-control" id="ticketType" name="ticketType" value="<?php echo $ticketType; ?>">
            </div>
            <div class="form-group">
                <label for="priceAmount">Price Amount:</label>
                <input type="number" class="form-control" id="priceAmount" name="priceAmount" value="<?php echo $priceAmount; ?>">
            </div>
            <button type="submit" class="btn btn-primary" name="updateRoute">Update Route</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
