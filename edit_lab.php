<?php
session_start();

// if no valid session, force login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
?>

<?php 
if(isset($_GET["id"])){
    $id = $_GET["id"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Laboratory Exam - Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="humberg">
        <i class="fa fa-bars"></i>
    </div>
    <aside class="sidebar">
        <h2>HealthSys Admin</h2>
        <nav>
            <ul>
                <li><a href="dashboard.php" ><i class="fa fa-tachometer-alt"></i>Dashboard</a></li>
                <li>
                    Patients
                    <ul>
                        <li><a href="view_patients.php"><i class="fa fa-user-injured"></i>View Patient</a></li>
                        <li><a href="add_patients.php"><i class="fa fa-user-plus"></i>Add patient</a></li>
                    </ul>
                </li>
                <li>
                    Doctors
                    <ul>
                        <li><a href="view_doctors.php"><i class="fa fa-user-md"></i>View Doctor</a></li>
                        <li><a href="add_doctor.php"><i class="fa fa-user-plus"></i>Add Doctor</a></li>
                    </ul>
                </li>
                <li>
                    Drugs
                    <ul>
                        <li><a href="view_drugs.php"><i class="fa fa-pills"></i>View drugs</a></li>
                        <li><a href="add_drug.php"><i class="fa fa-plus-square"></i>Add drug</a></li>
                    </ul>
                    </a>
                </li>
                <li>
                    Laboratory exams
                    <ul>
                        <li><a href="view_lab_exams.php"><i class="fa fa-vial"></i>View Laboratory Exams</a></li>
                        <li><a href="add_lab_exam.php" class="active"><i class="fa fa-vials"></i>Add Laboratory Exams</a></li>
                    </ul>
                </li>
                <li>
                    Districts
                    <ul>
                        <li><a href="view_districts.php"><i class="fa fa-map-marker-alt"></i>View Districts</a></li>
                    </ul>
                </li>
                <li>
                    Billings
                    <ul>
                        <li><a href="view_bills.php"><i class="fa fa-file-invoice-dollar"></i>View Bills</a></li>
                        <li><a href="add_bill.php"><i class="fa fa-file-medical"></i>Add bill</a></li>
                    </ul>
                </li>
                <li>
                    Facility Items
                    <ul>
                        <li><a href="view_items.php"><i class="fa fa-hospital"></i>View Facility items</a></li>
                        <li><a href="add_item.php"><i class="fa fa-plus-circle"></i>Add facility items</a></li>
                    </ul>
                </li>
                <li>
                    Orders
                    <ul>
                        <li><a href="view_orders.php"><i class="fa fa-shopping-cart"></i>View Orders</a></li>
                        <li><a href="add_order.php"><i class="fa fa-cart-plus"></i>Add Order</a></li>
                    </ul>
                </li>
                <li><a href="logout.php" onclick="return confirm('Are you sure you want to logout?')"><i class="fa fa-sign-out"></i>Logout</a></li>
            </ul>
        </nav>
    </aside>
    <main class="main-content">
        <h1>Lab exams</h1>
        <!-- Add lab exam form -->
        <div class="modal" id="modal-patient-add">
            <div class="modal-content">
                <h2>Edit Laboratory Exam</h2>
                    <?php
     require_once("connect.php");
     if(isset($_POST['edit'])) {
    $edit_id= $_POST["edit_id"];
    $name = $con->real_escape_string(trim($_POST['lab_exam']));
    $tarrif = $con->real_escape_string(trim($_POST['tarrif']));
    $sql = "UPDATE laboratory_exam SET lab_name='$name',
    tarrif='$tarrif' WHERE lab_id=$edit_id ";
    $result=mysqli_query($con,$sql);
    if($result){
        echo "<script>Alert('Insertion is successfull')</script>";
            header("location:view_lab_exams.php");
    }
    else{
            die(mysqli_connect_error());
    }


}

$con->close();
?>
<?php   
include("connect.php");
$sql="select * from laboratory_exam where lab_id=$id";
$result=mysqli_query($con,$sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $edit_id= $row["lab_id"];
        $edit_name= $row["lab_name"];
        $edit_tarrif= $row["tarrif"];
      
        ?>
                <form action="" method="post">
                    <label><input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>"></label>
                    <label>Laboratory Exam<input type="text" name="lab_exam" required value="<?php echo $edit_name;?>"></label>
                    <label>Tariff<input type="text" name="tarrif"  required value="<?php echo $edit_tarrif;?>"></label>
                    
                    
                    <button type="submit" name="edit" onclick="return confirm('Are you sure you want to update this record?')">Save</button>
                </form>
                <?php
    }
}

?>
            </div>
        </div>


    </main>
    <script src="app.js"></script>
</body>

</html>