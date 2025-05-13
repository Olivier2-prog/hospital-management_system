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
    <title>Edit Patient - Admin Panel</title>
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
                        <li><a href="add_patients.php" ><i class="fa fa-user-plus"></i>Add patient</a>
                        </li>
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
                <li><a href="logout.php"><i class="fa fa-sign-out"></i>Logout</a></li>
            </ul>
        </nav>
    </aside>
    <main class="main-content">
        <h1>Patients</h1>

        <!-- Add Patient Form -->
        <div class="modal" id="modal-patient-add">
            <div class="modal-content">
                <h2>Edit Patient</h2>
                 <?php
     include("connect.php");
     if(isset($_POST['edit'])) {
    $name = $con->real_escape_string(trim($_POST['name']));
    $age = (int)$_POST['age'];
    $edit_id = (int)$_POST['edit_id'];
    $phone = $con->real_escape_string(preg_replace('/[^0-9]/', '', $_POST['phone']));
    $district = $con->real_escape_string(trim($_POST['district']));
    $dob = $con->real_escape_string($_POST['dob']);
    $gender =$_POST['gender'];

    if(empty($name) || $age < 1 || empty($phone) || empty($district) || empty($dob) || empty($gender)) {
        die("All fields are required!");
    }
    $sql = "UPDATE patient SET 
                Patient_names='$name', 
                age=$age, 
                Telephone='$phone', 
                DOB='$dob', 
                Gender='$gender', 
                district='$district' 
            WHERE Patient_id=$edit_id";
    $result=mysqli_query($con,$sql);
    if($result){
            header("location:view_patients.php");
    }
    else{
            die(mysqli_connect_error());
    }


}

$con->close();
?>
               
<?php   
include("connect.php");
$sql="select * from patient where Patient_id=$id";
$result=mysqli_query($con,$sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $edit_id= $row["Patient_id"];
        $edit_name= $row["Patient_names"];
        $edit_phone= $row["Telephone"];
        $edit_age= $row["age"];
        $edit_gender= $row["Gender"];
        $edit_dob= $row["DOB"];

        ?>
 <form action="" method="post">
                    <label><input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>"></label>
                    <label>Name<input type="text" name="name" required placeholder="Enter full name" value="<?php echo $edit_name; ?>"></label>
                    <label>Age<input type="text" name="age" required placeholder="Enter age" value="<?php echo $edit_age; ?>"></label>
                    <label>Phone<input type="tel" name="phone" required placeholder="Enter phone number" value="<?php echo $edit_phone; ?>"></label>
                    <label>District

                    <select name="district" >
                        <option  disabled> Select district</option>
                        <?php
                        include("connect.php");
                        $sql = "select District_Name from district";
                        $result = mysqli_query($con, $sql);
                        if(mysqli_num_rows($result)>0){
                            while($row=mysqli_fetch_assoc($result)){
                                $name = $row["District_Name"];
                                ?>
                              <option  value="<?php echo $name; ?>"><?php echo $name; ?></option>  
                            <?php
                            }
                        }
                        ?>
        
                    </select>
                    </label>
                    <label>DOB<input type="date" name="dob" required placeholder="Date of Birth" value="<?php echo $edit_dob; ?>"></label>
                    <label>Gender
                        
                            <input type="text" value="<?php echo $edit_gender; ?>" name="gender">

                        </label>
                    <button type="submit" name="edit" onclick="return confirm('Are you sure you want to update this record?')">Save changes</button>
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