<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'demo';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
if(! $conn )
{
die('Could not connect: ' . mysql_error());
}
echo 'Connected successfully<br />';
$sql = "DROP TABLE persons";
$retval = mysqli_query( $conn, $sql );
if(! $retval )
{
die('Could not delete table: ' . mysqli_error());
}
echo "Table deleted successfully\n";
mysqli_close($conn);
?>