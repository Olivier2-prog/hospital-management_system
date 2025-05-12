<?php
include("connect.php");


if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 
    $sql = "DELETE FROM billing WHERE bill_id =$id";
    $result = mysqli_query($con,$sql);
    if ($result) {
       header("location:view_bills.php");
    }

}

// Step 4: Close connection
$con->close();
?>