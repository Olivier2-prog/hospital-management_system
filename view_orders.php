<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders - Admin Panel</title>
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
                        <li><a href="view_orders.php" class="active"><i class="fa fa-shopping-cart"></i>View Orders</a></li>
                        <li><a href="add_order.php"><i class="fa fa-cart-plus"></i>Add Order</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </aside>
    <main class="main-content">
        <h1>List of available Orders</h1>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Exam Taken</th>
                    <th>Exam Tarrif</th>
                    <th>Order Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
require_once("connect.php");

// Corrected SQL query - fixed table name mismatch
$select = "SELECT orders.*, laboratory_exam.lab_name, laboratory_exam.tarrif
           FROM orders 
           INNER JOIN laboratory_exam ON orders.lab_id = laboratory_exam.lab_id
           ORDER BY orders.order_date DESC";  // Added sorting

$result = mysqli_query($con, $select);


if (!$result) {
   
    die("Database query failed: " . mysqli_error($con));
}
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {  // Using assoc instead of array for clarity
        $order_id = htmlspecialchars($row["order_id"]);
        $lab_name = htmlspecialchars($row["lab_name"]);
        $lab_tarrif = htmlspecialchars($row["tarrif"]);
        $order_date = htmlspecialchars($row["order_date"]);
        ?>
        <tr>
            <td><?php echo $order_id; ?></td>
            <td><?php echo $lab_name; ?></td>
            <td><?php echo $lab_tarrif; ?></td>
            <td><?php echo date('Y-m-d', strtotime($order_date)); // Formatted date ?></td>
            <td class="action-btns">
                <a href="delete_order.php?id=<?php echo $order_id; ?>" 
                   class="btn delete-btn" 
                   onclick="return confirm('Are you sure you want to delete this item?')">
                   Delete
                </a>
                <a href="edit_order.php?id=<?php echo $order_id; ?>" 
                   class="btn edit-btn">
                   Edit
                </a>
            </td>
        </tr>
        <?php 
    }
} else {
    echo '<tr><td colspan="4" class="no-records">No orders found</td></tr>';
}
?>
                </tbody>
            </tbody>
        </table>

        


    </main>
    <script src="app.js"></script>
</body>

</html>