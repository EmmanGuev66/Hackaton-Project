<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: index.html');
    exit();
}

$usuario_db = 'root';
$contrasena_db = '';
$servidor_db = 'localhost';
$basededatos_db = 'Colonia';

$conexion = mysqli_connect($servidor_db, $usuario_db, $contrasena_db, $basededatos_db);

if (!$conexion) {
    die('No se ha podido conectar a la base de datos: ' . mysqli_connect_error());
}

$query = "SELECT * FROM CasaHabitacion";
$result = mysqli_query($conexion, $query);

if (!$result) {
    die('Error en la consulta: ' . mysqli_error($conexion));
}

echo '<!DOCTYPE html>';
echo '<html lang="es">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<title>Datos de Casa</title>';
echo '<link rel="stylesheet" href="styles.css">';
echo '<style>';
echo 'body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }';
echo '.container { width: 90%; margin: auto; overflow: hidden; }';
echo 'table { width: 100%; border-collapse: collapse; margin-top: 20px; }';
echo 'th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }';
echo 'th { background-color: #333; color: white; }';
echo 'tr:nth-child(even) { background-color: #f2f2f2; }';
echo 'tr:hover { background-color: #ddd; }';
echo 'h2 { color: #333; }';
echo 'a { display: inline-block; margin-top: 20px; text-decoration: none; color: #007bff; }';
echo 'a:hover { text-decoration: underline; }';
echo '</style>';
echo '</head>';
echo '<body>';
echo '<div class="container">';
echo '<h2>Datos de las Casas</h2>';
echo '<table>';
echo '<tr>';
echo '<th>Número de Casa</th>';
echo '<th>Calle</th>';
echo '<th>Colonia</th>';
echo '<th>Código Postal</th>';
echo '<th>Propietario</th>';
echo '<th>Fecha de Registro</th>';
echo '<th>Consumo de Agua Mensual</th>';
echo '<th>Última Lectura</th>';
echo '<th>Fecha de Última Lectura</th>';
echo '</tr>';

while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['NumeroCasa']) . '</td>';
    echo '<td>' . htmlspecialchars($row['Calle']) . '</td>';
    echo '<td>' . htmlspecialchars($row['Colonia']) . '</td>';
    echo '<td>' . htmlspecialchars($row['CodigoPostal']) . '</td>';
    echo '<td>' . htmlspecialchars($row['Propietario']) . '</td>';
    echo '<td>' . htmlspecialchars($row['FechaRegistro']) . '</td>';
    echo '<td>' . htmlspecialchars($row['ConsumoAguaMensual']) . '</td>';
    echo '<td>' . htmlspecialchars($row['UltimaLectura']) . '</td>';
    echo '<td>' . htmlspecialchars($row['FechaUltimaLectura']) . '</td>';
    echo '</tr>';
}

echo '</table>';
echo '<a href="index.php?action=logout">Cerrar sesión</a>';
echo '</div>';
echo '</body>';
echo '</html>';

mysqli_close($conexion);
?>

