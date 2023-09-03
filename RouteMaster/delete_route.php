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

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_SESSION["userID"]) && $_SESSION["userType"] === 'admin' && isset($_GET["routeID"])) {
    $routeID = $_GET["routeID"];

    // Delete associated ticket prices records first
    $deleteTicketPricesQuery = "DELETE FROM ticket_prices WHERE RouteID = ?";
    $stmtTicketPrices = $conn->prepare($deleteTicketPricesQuery);
    $stmtTicketPrices->bind_param("i", $routeID);

    if ($stmtTicketPrices->execute()) {
        // Once ticket prices are deleted, delete corresponding route stops
        $deleteRouteStopsQuery = "DELETE FROM route_stops WHERE RouteID = ?";
        $stmtRouteStops = $conn->prepare($deleteRouteStopsQuery);
        $stmtRouteStops->bind_param("i", $routeID);

        if ($stmtRouteStops->execute()) {
            // Once route stops are deleted, delete the route itself
            $deleteRouteQuery = "DELETE FROM bus_routes WHERE RouteID = ?";
            $stmt = $conn->prepare($deleteRouteQuery);
            $stmt->bind_param("i", $routeID);

            if ($stmt->execute()) {
                $message = "Route deleted successfully!";
            } else {
                $message = "Error deleting route: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $message = "Error deleting route stops: " . $stmtRouteStops->error;
        }

        $stmtRouteStops->close();
    } else {
        $message = "Error deleting ticket prices: " . $stmtTicketPrices->error;
    }

    $stmtTicketPrices->close();

    header("Location: homepage.php");
    exit();
}


$conn->close();
?>
