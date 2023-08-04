<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>

<?php
    include('db.php');
    $select = mysqli_query($connection, "SELECT * FROM info order by id desc");
    $num_row = mysqli_num_rows($select);

    if( $num_row ) {
?>
      <table>
          <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Action</th>
          </tr>
          <?php while( $userrow = mysqli_fetch_array($select) ) { ?>
          <tr>
              <td><?php echo $userrow['id']; ?></td>
              <td><?php echo $userrow['username']; ?></td>
              <td><?php echo $userrow['emailid']; ?></td>
              <td><?php echo $userrow['mobileno']; ?></td>
              <td>
                  <a href="view.php?id=<?php echo $userrow['id']; ?>"><span class="view" title="View"> View</span></a> /
                  <a href="edit.php?id=<?php echo $userrow['id']; ?>"><span class="edit" title="Edit"> Edit</span></a> /
                  <a href="delete.php?id=<?php echo $userrow['id']; ?>" onclick="return confirm('Are you sure you wish to delete this Record?');">
                      <span class="delete" title="Delete"> Delete</span>
                  </a>
              </td>
          </tr>
          <?php } ?>
      </table>
<?php } ?>
