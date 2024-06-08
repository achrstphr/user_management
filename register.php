<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $created_at = date('Y-m-d H:i:s');

    if ($password == $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $hashed_password, $created_at);

        if ($stmt->execute()) {
            header("Location: login.php?message=Registration Successful&status=success");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        header("Location: register.php?message=Password did not match&status=danger");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <?php if (isset($_GET['message'])): ?>  
        <div id="success-alert" class="alert alert-<?php echo htmlspecialchars($_GET['status']); ?> d-flex align-items-center justify-content-center mt-5" role="alert">
            <p class="text-center mb-0"><?php echo htmlspecialchars($_GET['message']); ?></p>
        </div>
    <?php endif; ?>
    <h2 class="mt-5">Register</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
    <div class="mt-3">
        <?php if (!isset($_SESSION['id'])) { ?>
            <p>Already have an account? <a href="login.php">Login</a></p>
        <?php } else { ?>
            <p>Back to the <a href="dashboard.php">Dashboard</a></p>
        <?php } ?>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $("#success-alert").alert('close');
        }, 3000); // 3000 milliseconds = 3 seconds
    });
</script>
</body>
</html>
