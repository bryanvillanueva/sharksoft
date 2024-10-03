<?php
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

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $birth_date = $_POST['birth_date'];
    $position = $_POST['position'];
    $user_role = $_POST['user_role'];
    $profile_picture = $_FILES['profile_picture'];

    // Verificar si el nombre de usuario o el email ya existen
    $checkQuery = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $checkQuery->bind_param("ss", $username, $email);
    $checkQuery->execute();
    $result = $checkQuery->get_result();

    if ($result->num_rows > 0) {
        echo "Username or Email already in use.";
    } else {
        // Manejo de la subida de la imagen de perfil
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($profile_picture["name"]);

        // Verificar si la carpeta 'uploads' existe y crearla si es necesario
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);  // Crear la carpeta con permisos
        }

        // Mover el archivo subido a la carpeta
        if (move_uploaded_file($profile_picture["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($profile_picture["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }

        // Insertar los datos del usuario en la base de datos
        $stmt = $conn->prepare("INSERT INTO users (full_name, username, email, password, birth_date, position, user_role, profile_picture) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $full_name, $username, $email, $password, $birth_date, $position, $user_role, $target_file);

        if ($stmt->execute()) {
            echo "New user added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}

// Cerrar la conexión
$conn->close();
?>
