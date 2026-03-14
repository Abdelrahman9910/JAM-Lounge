<?php
session_start();
require "config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    $stmt = $conn->prepare("SELECT id, password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {

        if (password_verify($password, $row["password"])) {
            $_SESSION["admin_id"] = $row["id"];
            header("Location: admin.php");
            exit;
        }
    }

    $error = "Invalid username or password";
}
?>

<!DOCTYPE html>
<html>
<head><title>Admin Login</title></head>
<body>
<h2>Admin Login</h2>

<?php if ($error): ?>
<p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

<form method="POST">
  <label>Username:</label><br>
  <input type="text" name="username" required><br>
  <label>Password:</label><br>
  <input type="password" name="password" required><br><br>
  <button type="submit">Login</button>
</form>
</body>
</html>
