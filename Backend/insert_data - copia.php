<?php

$usuario_db = 'root';
$contrasena_db = '';
$servidor_db = 'localhost';
$basededatos_db = 'Colonia';

$conexion = mysqli_connect($servidor_db, $usuario_db, $contrasena_db, $basededatos_db);

if (!$conexion) {
    die('No se ha podido conectar a la base de datos: ' . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $NumeroCasa = mysqli_real_escape_string($conexion, $_POST['NumeroCasa']);
    $Calle = mysqli_real_escape_string($conexion, $_POST['Calle']);
    $Colonia = mysqli_real_escape_string($conexion, $_POST['Colonia']);
    $CodigoPostal = mysqli_real_escape_string($conexion, $_POST['CodigoPostal']);
    $Propietario = mysqli_real_escape_string($conexion, $_POST['Propietario']);
    $FechaRegistro = mysqli_real_escape_string($conexion, $_POST['FechaRegistro']);
    $ConsumoAguaMensual = mysqli_real_escape_string($conexion, $_POST['ConsumoAguaMensual']);
    $UltimaLectura = mysqli_real_escape_string($conexion, $_POST['UltimaLectura']);
    $FechaUltimaLectura = mysqli_real_escape_string($conexion, $_POST['FechaUltimaLectura']);

    $query = "INSERT INTO CasaHabitacion (NumeroCasa, Calle, Colonia, CodigoPostal, Propietario, FechaRegistro, ConsumoAguaMensual, UltimaLectura, FechaUltimaLectura)
              VALUES ('$NumeroCasa', '$Calle', '$Colonia', '$CodigoPostal', '$Propietario', '$FechaRegistro', '$ConsumoAguaMensual', '$UltimaLectura', '$FechaUltimaLectura')";

    if (mysqli_query($conexion, $query)) {
        echo "Datos insertados correctamente.";
    } else {
        echo "Error al insertar los datos: " . mysqli_error($conexion);
    }
} else {
    echo "No se recibieron datos POST.";
}

mysqli_close($conexion);
?>
