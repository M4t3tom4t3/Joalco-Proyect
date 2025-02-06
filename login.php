<?php
session_start();


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jp";

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $stmt = $mysqli->prepare("SELECT hash_cont FROM credenciales WHERE usuario = ?");
    $stmt->bind_param("s", $usuario); 

    $stmt->execute();
    $stmt->store_result();

    
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($hash_cont);
        $stmt->fetch();

        if (password_verify($password, $hash_cont)) {
            
            $_SESSION['usuario'] = $usuario; 
            header("Location: index.php");
            exit();
        } else {
            
            echo "<div class='alert alert-danger'>Contraseña incorrecta.</div>";
        }
    } else {
        
        echo "<div class='alert alert-danger'>El nombre de usuario no existe.</div>";
    }

   
    $stmt->close();
    $mysqli->close();
}
?>
