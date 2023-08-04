<link rel="stylesheet" href="style.css">
<?php
    include('db.php');
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $select = mysqli_query($connection, "SELECT * FROM info WHERE id = '$id'");

        while($userrow = mysqli_fetch_array($select)) {
?>
    <div class="display">
        <p> USER NAME : <span><?php echo $userrow['id']; ?></span>
            <a href="delete.php?id=<?php echo $userrow['id']; ?>" onclick="return confirm('Are you sure you wish to delete this Record?');">
                <span class="delete" title="Delete"> Delete </span>
            </a>
        </p>
        <br />
        <p> EMAIL ID : <span><?php echo $userrow['emailid']; ?></span>
            <a href="edit.php?id=<?php echo $userrow['id']; ?>"><span class="edit" title="Edit"> Edit </span></a>
        </p>
        <br />
        <p> MOBILE NO : <span><?php echo $userrow['mobileno']; ?></span>
        </p>
        <br />
        <p> CREATED ON : <span><?php echo $userrow['created']; ?></span>
        </p>
    </div>
<?php } } ?>
