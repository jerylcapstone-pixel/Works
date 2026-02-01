<?php
session_start();
require_once 'php/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $errors = [];

    if (empty($username)) $errors[] = "Username is required";
    if (empty($email)) $errors[] = "Email is required";
    if (empty($password)) $errors[] = "Password is required";
    if ($password !== $confirm_password) $errors[] = "Passwords do not match";
    if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters";

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashed_password]);
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } catch(PDOException $e) {
            if ($e->getCode() == 23000) {
                $errors[] = "Username or email already exists";
            } else {
                $errors[] = "Registration failed";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Homeless Dogs Map</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Register</h3>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php foreach ($errors as $error): ?>
                                        <li><?php echo htmlspecialchars($error); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <form method="post">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" id="username" name="username" required>
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
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </form>
                        <p class="text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>