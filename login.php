<?php
// login.php
session_start();
include("connect.php");

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1) Grab & escape user inputs
    $username = mysqli_real_escape_string($con, trim($_POST['username']));
    $password = mysqli_real_escape_string($con, trim($_POST['password']));

    // 2) Query admin table
    $sql = "SELECT admin_id, email 
            FROM admin 
            WHERE email = '$username' 
              AND password = '$password'
            LIMIT 1";
    $result = mysqli_query($con, $sql);

    // 3) Check result
    if ($result && mysqli_num_rows($result) === 1) {
        $admin = mysqli_fetch_assoc($result);
        // 4) Set session & redirect
        $_SESSION['admin_id']    = $admin['admin_id'];
        $_SESSION['admin_email'] = $admin['email'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="login.css">
</head>

<body>
<div class="container">
    <!-- Left Side - Image -->
    <div class="image-section">
        <div class="image-content">
            <h1>HealthSys</h1>
            <p>Quality Care, Advanced Technology</p>
        </div>
    </div>

    <!-- Right Side - Login Form -->
    <div class="form-section">
        <div class="login-container">
            <h2>Admin Login</h2>
            <?php if ($error): ?>
                <p class="error-message"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Email</label>
                    <input
                      type="text"
                      id="username"
                      name="username"
                      
                      value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                      type="password"
                      id="password"
                      name="password"
                      autocomplete="off"
                    >
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</div>
</body>

</html>
