<?php
session_start();

// if no valid session, force login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor - Admin Panel</title>
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
            <li><a href="dashboard.php"><i class="fa fa-tachometer-alt"></i>Dashboard</a></li>
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
                    <li><a href="add_doctor.php" class="active"><i class="fa fa-user-plus"></i>Add Doctor</a></li>
                </ul>
            </li>
            <li>
                Laboratory exams
                <ul>
                    <li><a href="view_lab_exams.php"><i class="fa fa-vial"></i>View Laboratory Exams</a></li>
                    <li><a href="add_lab_exam.php"><i class="fa fa-vials"></i>Add Laboratory Exams</a></li>
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
        <h1>Doctors</h1>

        <!-- Add patient form -->
        <div class="modal" >
            <div class="modal-content">
        
                <h2>Add Doctor </h2>
                <?php
     require_once("connect.php");
     if(isset($_POST['save'])) {
    $name = $con->real_escape_string(trim($_POST['doctor_name']));
    $phone = $con->real_escape_string(preg_replace('/[^0-9]/', '', $_POST['doctor_phone']));
    $qualifications = $con->real_escape_string(trim($_POST['qualifications']));
    

    // if(empty($name) || empty($phone) || empty($district) || empty($dob) || empty($gender)) {
    //     die("All fields are required!");
    // }
    $sql = "INSERT INTO doctors (Doctors_Names,Qualifications,Telephone) 
            VALUES ('$name','$qualifications','$phone')";
    $result=mysqli_query($con,$sql);
    if($result){
            header("location:add_doctor.php");
    }
    else{
            die(mysqli_connect_error());
    }


}

$con->close();
?>
                <form action="" method="post">
                    <label>Name<input type="text" name="doctor_name" required placeholder="Enter full name"></label>
                    <label>Phone<input type="tel" name="doctor_phone" required placeholder="Enter phone number"></label>
                    <label>Qualifications<input type="text" name="qualifications" required placeholder="Enter qualifications"></label>
                    
                    </label>
                    <button type="submit" name="save">Save</button>
                </form>

                
            </div>
        </div>


    </main>
    <script src="app.js"></script>
</body>

</html>