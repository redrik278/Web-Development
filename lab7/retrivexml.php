<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbred";

function retrieveAndDisplay($connection) {
    $query = "SELECT * FROM galaxy";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<table style='border-collapse: collapse;' border='1'>
            <tr>
                <th>Name</th>
                <th>Magnitude</th>
                <th>Distance</th>
            </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$row['name']}</td>
                <td>{$row['magnitude']}</td>
                <td>{$row['distance']}</td>
            </tr>";
        }

        echo "</table>";
    } else {
        echo "No data found in the table.";
    }
}

// Retrieve data from MySQL and display it in an HTML table
$connection = mysqli_connect($servername, $username, $password, $dbname);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

retrieveAndDisplay($connection);

mysqli_close($connection);
?>
