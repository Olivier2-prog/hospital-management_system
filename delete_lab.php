<?php
include("connect.php");


if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 
    $sql = "DELETE FROM laboratory_exam WHERE lab_id =$id";
    $result = mysqli_query($con,$sql);
    if ($result) {
       header("location:view_lab_exams.php");
    }

}

// Step 4: Close connection
$con->close();
?>