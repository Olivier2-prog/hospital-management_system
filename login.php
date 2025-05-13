<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="login.css">
    <title>Login</title>
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
            <p class="error-message">
            </p>

            <form method="POST" >
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required >
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required autocomplete="off">
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</div>
</body>

</html>