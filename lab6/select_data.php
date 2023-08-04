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
    echo "<h1>Connection was successful</h1> <br>";
}


// sql query to be executed
$sql = "SELECT * FROM `user`";
if($result = mysqli_query($conn, $sql)){
    if(mysqli_num_rows($result) > 0){
        // Add border attribute to the table tag
        echo "<table border='1' style='border-collapse: collapse;'>";
            echo "<tr>";
                echo "<th>Id</th>";
                echo "<th>Name</th>";
                echo "<th>Email</th>";
                echo "<th>Password</th>";
                echo "<th>Ip</th>";
                echo "<th>Website</th>";
                echo "<th>DOB</th>";
                echo "<th>Gender</th>";
                echo "<th>Mobile</th>";
                echo "<th>Description</th>";
            echo "</tr>";
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['password'] . "</td>";
                echo "<td>" . $row['ip_address'] . "</td>";
                echo "<td>" . $row['website'] . "</td>";
                echo "<td>" . $row['dob'] . "</td>";
                echo "<td>" . $row['gender'] . "</td>";
                echo "<td>" . $row['mobile_number'] . "</td>";
                echo "<td>" . $row['brief_info'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        // Free result set. mysqli_free_result() function frees the memory associated with the result.
        mysqli_free_result($result);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}
?>