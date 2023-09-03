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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["userID"]) && $_SESSION["userType"] === 'user' && isset($_POST["bookTicket"])) {
    $routeID = $_POST["routeID"];
    $userID = $_SESSION["userID"];

    // Insert booking information into the bookings table
    $insertBookingQuery = "INSERT INTO bookings (RouteID, UserID) VALUES (?, ?)";
    $stmt = $conn->prepare($insertBookingQuery);
    $stmt->bind_param("ii", $routeID, $userID);

    if ($stmt->execute()) {
        $message = "Ticket booked successfully!";
    } else {
        $message = "Error booking ticket: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch bus routes information with ticket prices
$busRoutes = [];
$getRoutesQuery = "SELECT br.RouteID, br.RouteName, br.TotalDistance, tp.TicketType, tp.PriceAmount
                   FROM bus_routes br
                   LEFT JOIN ticket_prices tp ON br.RouteID = tp.RouteID";
$routesResult = $conn->query($getRoutesQuery);

if ($routesResult->num_rows > 0) {
    while ($row = $routesResult->fetch_assoc()) {
        $busRoutes[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
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
        <?php if (isset($_SESSION["userID"])): ?>
            <!-- Common Content for both Users and Admins -->
            <h2>Welcome to RouteMaster!</h2>
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Route ID</th>
                        <th>Route Name</th>
                        <th>Total Distance</th>
                        <th>Ticket Type</th>
                        <th>Price Amount</th>
                        <?php if ($_SESSION["userType"] === 'user'): ?>
                            <!-- Display Booking Button for Users -->
                            <th>Action</th>
                        <?php elseif ($_SESSION["userType"] === 'admin'): ?>
                            <!-- Display Update and Delete Buttons for Admins -->
                            <th>Update</th>
                            <th>Delete</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($busRoutes)): ?>
                        <?php foreach ($busRoutes as $route): ?>
                            <tr>
                                <td><?php echo $route["RouteID"]; ?></td>
                                <td><?php echo $route["RouteName"]; ?></td>
                                <td><?php echo $route["TotalDistance"]; ?></td>
                                <td><?php echo $route["TicketType"]; ?></td>
                                <td><?php echo $route["PriceAmount"]; ?></td>
                                <?php if ($_SESSION["userType"] === 'user'): ?>
                                    <!-- Display Booking Button for Users -->
                                    <td>
                                        <form method="POST" action="book_ticket.php">
                                            <input type="hidden" name="routeID" value="<?php echo $route["RouteID"]; ?>">
                                            <input type="hidden" name="ticketType" value="<?php echo $route["TicketType"]; ?>">
                                            <input type="hidden" name="priceAmount" value="<?php echo $route["PriceAmount"]; ?>">
                                            <button type="submit" class="btn btn-primary" name="bookTicket">Book</button>
                                        </form>
                                    </td>
                                <?php elseif ($_SESSION["userType"] === 'admin'): ?>
                                    <!-- Display Update and Delete Buttons for Admins -->
                                    <td>
                                        <a href="update_route.php?routeID=<?php echo $route["RouteID"]; ?>" class="btn btn-info">Update</a>
                                    </td>
                                    <td>
                                        <a href="delete_route.php?routeID=<?php echo $route["RouteID"]; ?>" class="btn btn-danger">Delete</a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?php echo ($_SESSION["userType"] === 'user') ? '7' : '6'; ?>">No bus routes found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <p class="mt-3"><?php echo $message; ?></p>
        <?php else: ?>
            <!-- Guest Welcome Message and Links -->
        <?php endif; ?>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
