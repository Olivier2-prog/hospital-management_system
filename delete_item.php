<?php
include("connect.php");


if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 
    $sql = "DELETE FROM facility_service WHERE item_id =$id";
    $result = mysqli_query($con,$sql);
    if ($result) {
       header("location:view_items.php");
    }

}

// Step 4: Close connection
$con->close();
?>