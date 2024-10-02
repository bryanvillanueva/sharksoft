<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli('localhost', 'root', '', 'login_system');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que existan los campos en el formulario
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Consulta SQL preparada para evitar inyección SQL
        $sql = "SELECT * FROM users WHERE username = ? AND password = MD5(?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar si se encontró un usuario
        if ($result->num_rows > 0) {
            echo "Bienvenido, Inicio de sesion exitoso!";
        } else {
            echo "Nombre de usuario o contrasena Invalidos.";
        }
    } else {
        echo "Por favor complete ambos campos.";
    }
}
?>
