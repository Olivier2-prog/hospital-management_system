<?php
include("connect.php");


if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 
    $sql = "DELETE FROM patient WHERE Patient_id =$id";
    $result = mysqli_query($con,$sql);
    if ($result) {
       header("location:view_patients.php");
    }

}

// Step 4: Close connection
$con->close();
?>
