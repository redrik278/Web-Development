<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$database = 'summer2023';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $database);
if(! $conn )
{
die('Could not connect: ' . mysql_error());
}
echo 'Connected successfully<br />';
$sql = "DROP TABLE user";
$result = mysqli_query(  $conn, $sql);
if(! $result)
{
die('Could not delete table: ' . mysqli_error());
}
echo "Table deleted successfully\n";
mysqli_close($conn);
?>