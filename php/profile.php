
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirigir al login si no hay sesión activa
    header('Location: ../index.html');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_system";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener la información del perfil desde la base de datos
$user_id = $_SESSION['user_id'];
$sql = "SELECT full_name, email, position, profile_picture, birth_date FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($full_name, $email, $position, $profile_picture, $birth_date);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="../css/prof-styles.css">
</head>
<body>
    <div class="profile-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="user-info">
                <img src="https://sharkagency.co/wp-content/uploads/2024/08/logo-white-png-1.png" alt="Shark Logo" class="profile-picture">
            </div>
            <ul class="menu">
                <li>Profile</li>
                <li>Settings</li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <!-- Profile content section -->
        <div class="profile-content">
            <h1>Profile Information</h1>
            <div class="profile-section">
                <h2>Personal Information</h2>
                <div class="profile-info">
                    <img src="<?php echo $profile_picture; ?>" alt="">
                    <p><strong>Full Name: </strong><?php echo $full_name; ?></p>
                    <p><strong>Email: </strong><?php echo $email; ?></p>
                    <p><strong>Fecha de Nacimiento: </strong><?php echo $birth_date; ?></p>
                    
                    <p><strong>Position: </strong><?php echo $position; ?></p>
                </div>
            </div>

            <div class="profile-section">
                <h2>Address Information</h2>
                <div class="profile-info">
                    <p><strong>Country: </strong>Australia</p>
                    <p><strong>City/State: </strong>Sydney, New South Wales</p>
                    <p><strong>Postal Code: </strong>2000</p>
                    <p><strong>TAX ID: </strong>ABC1234567</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
