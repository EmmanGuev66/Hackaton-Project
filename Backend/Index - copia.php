<?php
session_start();

$usuario_db = 'root';
$contrasena_db = '';
$servidor_db = 'localhost';
$basededatos_db = 'Colonia';

$conexion = mysqli_connect($servidor_db, $usuario_db, $contrasena_db, $basededatos_db);

if (!$conexion) {
    die('No se ha podido conectar a la base de datos: ' . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'login') {
    $username = mysqli_real_escape_string($conexion, $_POST['username']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password' AND role = 'admin'";
    $result = mysqli_query($conexion, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'admin';
        header('Location: data.php');
        exit();
    } else {
        echo "Usuario o contraseña incorrectos!";
    }
    exit();
}


if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset();
    session_destroy();
    header('Location: index.html');
    exit();
}

if (isset($_SESSION['username']) && $_SESSION['role'] == 'admin') {
    header('Location: data.php');
    exit();
}

if (!isset($_SESSION['username'])) {
    include 'index.html';
}

mysqli_close($conexion);
?>



