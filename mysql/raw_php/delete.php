<?php
    include("db.php");
    if(isset($_GET['id']) != "") {
        $delete = $_GET['id'];
        $delete = mysqli_query($connection, "DELETE FROM info WHERE id = '$delete'");
        if($delete) {
            header("Location:index.php");
        } else {
            echo mysqli_error($connection);
        }
    }
?>