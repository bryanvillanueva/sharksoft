<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_system";

// Crear la conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Si el formulario de login fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta para obtener el usuario
    $sql = "SELECT id, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $hashed_password);
    $stmt->fetch();

    // Verificar si el usuario existe y si la contraseña es correcta
    if ($user_id && password_verify($password, $hashed_password)) {
        // Iniciar la sesión y guardar el ID del usuario en la sesión
        $_SESSION['user_id'] = $user_id;
        
        // Redirigir al perfil del usuario
        header("Location: profile.php");
        exit();
    } else {
        
        echo'<script type="text/javascript">
    alert("Usuario o contrasena incorrectos");
    window.location.href="../index.html";
    </script>';
    }

    $stmt->close();
}

$conn->close();
?>
