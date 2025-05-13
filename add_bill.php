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
    <title>Add bill - Admin Panel</title>
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
                        <li><a href="add_doctor.php"><i class="fa fa-user-plus"></i>Add Doctor</a></li>
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
                        <li><a href="add_bill.php" class="active"><i class="fa fa-file-medical"></i>Add bill</a></li>
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
        <h1>Billing</h1>
<!-- Add bill form -->
        <div class="modal">
            <div class="modal-content">
                <h2>Add Bill</h2>
                <?php
                require_once("connect.php");
                if (isset($_POST['save'])) {
                    // Sanitize inputs
                    $item_name = $_POST['item_name'];
                    $patient_id = $_POST['patient_id'];
                    $doctor_id =$_POST['doctor_id'];
                    $bill_date =$_POST['bill_date'];
                    $quantity = $_POST['quantity'];
                    $sql = "insert into billing (item_name,Patient_id,Doctor_id,quantity,bill_date)
                    values ('$item_name','$patient_id','$doctor_id','$quantity','$bill_date')";
                    $result = mysqli_query($con, $sql);
                    if($result){
                        header("location:add_bill.php");
                    }                                  
}

                ?>
                <form action="" method="post">
                   
                    <label>Item Name
                        <select name="item_name" required>
                            <option disabled selected>Select item name</option>
                            <?php
            $item_ids = "SELECT item_names FROM facility_service";
            $result = mysqli_query($con, $item_ids);
            // Check if there are results
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $it_name = $row["item_names"];
                    echo "<option value='$it_name'>$it_name</option>"; // Wrap in option tags
                }
            } else {
                echo "<option disabled>No items found</option>";
            }?>
                        </select>
                    </label>
                    <label>Patient ID
                        <select name="patient_id" required>
                            <option disabled selected>Select patient ID</option>
                            <?php
            $item_ids = "SELECT Patient_id FROM patient";
            $result = mysqli_query($con, $item_ids);
            // Check if there are results
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $it_id = $row["Patient_id"];
                    echo "<option value='$it_id'>$it_id</option>"; // Wrap in option tags
                }
            } else {
                echo "<option disabled>No items found</option>";
            }?>
                        </select>
                    </label>
                    <label>Doctor ID
                        <select name="doctor_id" required>
                            <option disabled selected>Select Doctor ID</option>
                            <?php
            $item_ids = "SELECT Doctor_id FROM doctors";
            $result = mysqli_query($con, $item_ids);
            // Check if there are results
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $it_id = $row["Doctor_id"];
                    echo "<option value='$it_id'>$it_id</option>"; // Wrap in option tags
                }
            } else {
                echo "<option disabled>No items found</option>";
            }?>
                        </select>
                    </label>
                    <label>Bill Date<input type="date" name="bill_date" required></label>
                    <label>Quantity<input type="number" name="quantity" min="0" required placeholder="Enter Quantity"></label>

                    <button type="submit" name="save">Save</button>
                </form>
            </div>
        </div>


    </main>
    <script src="app.js"></script>
</body>

</html>