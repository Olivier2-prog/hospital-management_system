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
    <title>View doctors - Admin Panel</title>
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
                        <li><a href="view_doctors.php" class="active"><i class="fa fa-user-md"></i>View Doctor</a></li>
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
                        <li><a href="add_lab_exam.php"><i class="fa fa-vials"></i>Add Laboratory Exams</a></li>
                    </ul>
                </li>
                <li>
                    Districts
                    <ul>
                        <li><a href="view_districts.php"><i class="fa fa-map-marker-alt"></i>View Districts</a></li>
                        <li><a href="add_district.php"><i class="fa fa-map"></i>Add District</a></li>
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
        <h1>List of available Doctors</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Names</th>
                    <th>Qualifications</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
            require_once("connect.php");
            $select="select * from doctors";
            $result=mysqli_query($con,$select);
                while ($row = mysqli_fetch_array($result)) {
                    $id = $row["Doctor_id"];
                    $name = $row["Doctors_Names"];
                    $qualifications = $row["Qualifications"];
                    $phone = $row["Telephone"];
                    ?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $name; ?></td>
                    <td><?php echo $qualifications; ?></td>
                    <td><?php echo $phone; ?></td>
                    <td class="action-btns">
                        <a href="delete_doctor.php?id=<?php  echo $id; ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                        <a href="edit_doctor.php?id=<?php  echo $id; ?>" class="btn edit-btn">Edit</a>
                    </td>
                    </tr>
                    <?php
                }
                    ?>
            </tbody>
        </table>


    </main>
    <script src="app.js"></script>
</body>

</html>