<?php
include 'conexion.php';

$busqueda = isset($_GET['buscar']) ? $_GET['buscar'] : '';
$sql = "SELECT * FROM pacientes ORDER BY fecha_consulta DESC";
if($busqueda) {
    $sql = "SELECT * FROM pacientes WHERE nombre LIKE '%$busqueda%' OR apellido LIKE '%$busqueda%' ORDER BY fecha_consulta DESC";
}
$result = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmacias La Buena - Sistema de Asistencia Médica</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Farmacias La Buena</h1>
            <div class="nav">
                <a href="index.php">Inicio</a>
                <a href="login.php">Admin/Doctor</a>
            </div>
        </div>
        <div class="content">
            <h2>Lista de Pacientes</h2>
            <p style="margin-bottom: 20px; color: #666;">Consulta médica - Registro de pacientes atendidos</p>
            
            <div class="search-box">
                <form method="GET">
                    <input type="text" name="buscar" placeholder=" Buscar paciente por nombre o apellido..." value="<?= htmlspecialchars($busqueda) ?>">
                </form>
            </div>
            
            <?php if($result->num_rows == 0): ?>
                <div class="alert alert-info">No hay pacientes registrados actualmente.</div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Paciente</th>
                            <th>Edad</th>
                            <th>Enfermedad</th>
                            <th>Tipo Sangre</th>
                            <th>Doctor</th>
                            <th>Fecha Consulta</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td data-label="ID"><?= $row['id'] ?></td>
                            <td data-label="Paciente"><?= htmlspecialchars($row['nombre'] . ' ' . $row['apellido']) ?></td>
                            <td data-label="Edad"><?= $row['edad'] ?> años</td>
                            <td data-label="Enfermedad"><?= htmlspecialchars($row['enfermedad']) ?></td>
                            <td data-label="Tipo Sangre"><?= $row['tipo_sangre'] ?></td>
                            <td data-label="Doctor"><?= htmlspecialchars($row['doctor_asignado']) ?></td>
                            <td data-label="Fecha Consulta"><?= date('d/m/Y H:i', strtotime($row['fecha_consulta'])) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>