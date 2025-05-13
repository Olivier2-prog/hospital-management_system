
<?php
include("connect.php");
if (isset($_POST['download'])) {
    // 1. Sanitize input
    $search = mysqli_real_escape_string($con, $_POST['search_query'] ?? '');

    // 2. Build your query (same as on‐page search)
    $sql = "SELECT 
              p.Patient_names,
              p.Telephone,
              p.DOB,
              p.Gender,
              p.district,
              p.age,
              b.item_name,
              b.quantity,
              b.bill_date,
              d.Doctors_Names
            FROM patient p
            JOIN billing b ON p.Patient_id = b.Patient_id
            JOIN doctors d ON b.Doctor_id = d.Doctor_id
            WHERE p.Patient_names LIKE '%$search%'
               OR p.district     LIKE '%$search%'
               OR p.Patient_id   LIKE '%$search%'
               OR p.age          LIKE '%$search%'
               OR p.Telephone    LIKE '%$search%'
               OR b.item_name    LIKE '%$search%'
               OR d.Doctors_Names LIKE '%$search%'
               OR b.quantity     LIKE '%$search%'
            ORDER BY p.Patient_names ASC";
    $result = mysqli_query($con, $sql);
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="Patient_bills_report.csv"');
    $out = fopen('php://output', 'w');
    $title = "Search Report for \"" . ($search ?: 'All Records') . "\"";
$subtitle = "Generated on " . date('Y-m-d H:i:s');
fputcsv($out, [$title]);
fputcsv($out, [$subtitle]);
fputcsv($out, []);  
    fputcsv($out, [
        'Patient Name',
        'Telephone',
        'Date of Birth',
        'Gender',
        'District',
        'Age',
        'Drug',
        'Quantity',
        'Bill Date',
        'Doctor'
    ]);

    // 6. Loop through results and write rows
    while ($row = mysqli_fetch_assoc($result)) {
        $clean = array_map(function($val) {
            if (is_numeric($val)) {
                return (int)$val;
            }
            return strip_tags($val);
        }, $row);
        fputcsv($out, array_values($clean));
    }

    fclose($out);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>
<body>
    <div class="humberg">
        <i class="fa fa-bars"></i>
    </div>
    <aside class="sidebar">
        <h2>HealthSys Admin</h2>
        <nav>
            <ul>
                <li><a href="dashboard.php" class="active"><i class="fa fa-tachometer-alt"></i>Dashboard</a></li>
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
            </ul>
        </nav>
    </aside>
    <main class="main-content">
        <!-- Search and Generate Report -->
        <form action="" class="search-form" method="post">
          <input type="search" name="search_query" class="search" placeholder="Search..." autocomplete="off">
          <input type="submit" value="Search" class="search-btn" name="search">
          <input type="submit" value="Generate Report" class="search-btn" name="download">
        </form>
        
        <h1>Dashboard</h1>
        <div class="stats-container">
            <div class="stat-card">
                <h3>Total Patients</h3>

                <?php  
                include("connect.php");
                $sql="select count(*) as patient_no from patient";
                $result=mysqli_query($con,$sql);
               if($result){
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                <p><?php echo $row['patient_no']; ?></p>

                        <?php
                    }
               }

                
                
                ?>
            </div>
            <div class="stat-card">
                <h3>Total Doctors</h3>
                <?php  
                include("connect.php");
                $sql="select count(*) as doctor_no from doctors";
                $result=mysqli_query($con,$sql);
               if($result){
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                <p><?php echo $row['doctor_no']; ?></p>

                        <?php
                    }
               }

                
                
                ?>
            </div>
            <div class="stat-card">
                <h3>Pending Orders</h3>
                <?php  
                include("connect.php");
                $sql="select count(*) as order_no from orders";
                $result=mysqli_query($con,$sql);
               if($result){
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                <p><?php echo $row['order_no']; ?></p>

                        <?php
                    }
               }

                
                
                ?>
            </div>
            <div class="stat-card">
                <h3>Total Bills</h3>
                <?php  
                include("connect.php");
                $sql="select count(*) as bill_no from billing";
                $result=mysqli_query($con,$sql);
               if($result){
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                <p><?php echo $row['bill_no']; ?></p>

                        <?php
                    }
               }

                
                
                ?>
            </div>
        </div>

        <?php
        if (isset($_POST['search'])) {
            $search = mysqli_real_escape_string($con, $_POST['search_query']);
            $query = "SELECT 
                        p.Patient_names,
                        p.Telephone,
                        p.DOB,
                        p.Gender,
                        p.district,
                        p.age,
                        b.item_name,
                        b.quantity,
                        b.bill_date,
                        d.Doctors_Names
                      FROM patient p
                      INNER JOIN billing b ON p.Patient_id = b.Patient_id
                      INNER JOIN doctors d ON b.Doctor_id = d.Doctor_id
                      WHERE p.Patient_names LIKE '%$search%' 
                         OR p.district LIKE '%$search%' 
                         OR p.Patient_id LIKE '%$search%'
                         OR p.age LIKE '%$search%'
                         OR p.Telephone LIKE '%$search%'
                         OR b.item_name LIKE '%$search%'
                         OR d.Doctors_Names LIKE '%$search%'
                         OR b.quantity LIKE '%$search%'
                      ORDER BY p.Patient_names ASC";
            $result = mysqli_query($con, $query);

            if (mysqli_num_rows($result) > 0) {
                echo '<div class="search-results">';
                echo '<h3 style="margin:30px 0 15px;">Search Results:</h3>';
                echo '<table class="result-table">';
                echo '<thead><tr>
                        <th>Patient Name</th>
                        <th>Telephone</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>District</th>
                        <th>Age</th>
                        <th>Drug</th>
                        <th>Quantity</th>
                        <th>Bill Date</th>
                        <th>Doctor</th>
                      </tr></thead><tbody>';
                
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>'.htmlspecialchars($row['Patient_names']).'</td>';
                    echo '<td>'.htmlspecialchars($row['Telephone']).'</td>';
                    echo '<td>'.htmlspecialchars($row['DOB']).'</td>';
                    echo '<td>'.htmlspecialchars($row['Gender']).'</td>';
                    echo '<td>'.htmlspecialchars($row['district']).'</td>';
                    echo '<td>'.htmlspecialchars($row['age']).'</td>';
                    echo '<td>'.htmlspecialchars($row['item_name']).'</td>';
                    echo '<td>'.htmlspecialchars($row['quantity']).'</td>';
                    echo '<td>'.htmlspecialchars($row['bill_date']).'</td>';
                    echo '<td>'.htmlspecialchars($row['Doctors_Names']).'</td>';
                    echo '</tr>';
                }
                
                echo '</tbody></table></div>';
            } else {
                echo '<p style="background-color:red;color:white;padding:10px;margin:10px 0;">
                        No results found for "'.htmlspecialchars($search).'" 😢
                      </p>';
            }
        }
        ?>

    </main>
    <script src="app.js"></script>
</body>
</html>
