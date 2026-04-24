<?php
session_start();
if(!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';
$mensaje = "";

if(isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $sql = "DELETE FROM pacientes WHERE id = $id";
    if($conexion->query($sql)) {
        $mensaje = "<div class='alert alert-success'> Paciente eliminado correctamente</div>";
    } else {
        $mensaje = "<div class='alert alert-error'> Error al eliminar paciente</div>";
    }
}

$paciente_editar = null;
if(isset($_GET['editar'])) {
    $id = intval($_GET['editar']);
    $result = $conexion->query("SELECT * FROM pacientes WHERE id = $id");
    $paciente_editar = $result->fetch_assoc();
}


if($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $edad = intval($_POST['edad']);
    $telefono = $_POST['telefono'];
    $telefono_opcional = !empty($_POST['telefono_opcional']) ? $_POST['telefono_opcional'] : null;
    $direccion = trim($_POST['direccion']);
    $enfermedad = trim($_POST['enfermedad']);
    $alergias = !empty($_POST['alergias']) ? $_POST['alergias'] : null;
    $tipo_sangre = $_POST['tipo_sangre'];
    $doctor_asignado = $_POST['doctor_asignado'];
    
    if(empty($nombre) || empty($apellido) || $edad <= 0 || empty($telefono)) {
        $mensaje = "<div class='alert alert-error'> Por favor completa todos los campos obligatorios</div>";
    } else {
        if(isset($_POST['id']) && $_POST['id'] > 0) {
            // Actualizar
            $id = intval($_POST['id']);
            $sql = "UPDATE pacientes SET 
                    nombre='$nombre', 
                    apellido='$apellido', 
                    edad=$edad, 
                    telefono='$telefono', 
                    telefono_opcional=" . ($telefono_opcional ? "'$telefono_opcional'" : "NULL") . ", 
                    direccion='$direccion', 
                    enfermedad='$enfermedad', 
                    alergias=" . ($alergias ? "'$alergias'" : "NULL") . ", 
                    tipo_sangre='$tipo_sangre', 
                    doctor_asignado='$doctor_asignado' 
                    WHERE id=$id";
            if($conexion->query($sql)) {
                $mensaje = "<div class='alert alert-success'> Paciente actualizado correctamente</div>";
                $paciente_editar = null;
            } else {
                $mensaje = "<div class='alert alert-error'> Error al actualizar paciente</div>";
            }
        } else {
            
            $sql = "INSERT INTO pacientes (nombre, apellido, edad, telefono, telefono_opcional, direccion, enfermedad, alergias, tipo_sangre, doctor_asignado) 
                    VALUES ('$nombre', '$apellido', $edad, '$telefono', " . ($telefono_opcional ? "'$telefono_opcional'" : "NULL") . ", '$direccion', '$enfermedad', " . ($alergias ? "'$alergias'" : "NULL") . ", '$tipo_sangre', '$doctor_asignado')";
            if($conexion->query($sql)) {
                $mensaje = "<div class='alert alert-success'> Paciente registrado correctamente</div>";
            } else {
                $mensaje = "<div class='alert alert-error'> Error al registrar paciente: " . $conexion->error . "</div>";
            }
        }
    }
}


$pacientes = $conexion->query("SELECT * FROM pacientes ORDER BY fecha_consulta DESC");
$total_pacientes = $pacientes->num_rows;


$result_edad = $conexion->query("SELECT AVG(edad) as promedio FROM pacientes");
$edad_promedio = $result_edad ? $result_edad->fetch_assoc()['promedio'] : 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Médico - Farmacias La Buena</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1> Farmacias La Buena</h1>
            <div class="nav">
                <span style="margin-right: 15px;"> Hola, <?= htmlspecialchars($_SESSION['nombre']) ?></span>
                <a href="index.php">Ver público</a>
                <a href="logout.php" class="btn-logout"> Cerrar sesión</a>
            </div>
        </div>
        <div class="content">
            <?= $mensaje ?>
            
            <div class="stats">
                <div class="stat-card">
                    <h3><?= $total_pacientes ?></h3>
                    <p>Total Pacientes</p>
                </div>
                <div class="stat-card">
                    <h3><?= round($edad_promedio) ?></h3>
                    <p>Edad Promedio</p>
                </div>
                <div class="stat-card">
                    <h3></h3>
                    <p>Farmacias La Buena</p>
                </div>
            </div>
            
            <h2><?= $paciente_editar ? ' Editar Paciente' : ' Registrar Nuevo Paciente' ?></h2>
            <form method="POST">
                <?php if($paciente_editar): ?>
                    <input type="hidden" name="id" value="<?= $paciente_editar['id'] ?>">
                <?php endif; ?>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Nombre:</label>
                        <input type="text" name="nombre" value="<?= $paciente_editar ? htmlspecialchars($paciente_editar['nombre']) : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Apellido:</label>
                        <input type="text" name="apellido" value="<?= $paciente_editar ? htmlspecialchars($paciente_editar['apellido']) : '' ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label> Edad:</label>
                        <input type="number" name="edad" value="<?= $paciente_editar ? $paciente_editar['edad'] : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label> Teléfono:</label>
                        <input type="tel" name="telefono" value="<?= $paciente_editar ? $paciente_editar['telefono'] : '' ?>" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Teléfono Opcional:</label>
                    <input type="tel" name="telefono_opcional" value="<?= $paciente_editar ? htmlspecialchars($paciente_editar['telefono_opcional']) : '' ?>">
                    <small style="color: #666;">Este campo puede quedar vacío (acepta valores nulos)</small>
                </div>
                
                <div class="form-group">
                    <label> Dirección:</label>
                    <input type="text" name="direccion" value="<?= $paciente_editar ? htmlspecialchars($paciente_editar['direccion']) : '' ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Enfermedad:</label>
                    <input type="text" name="enfermedad" value="<?= $paciente_editar ? htmlspecialchars($paciente_editar['enfermedad']) : '' ?>" required>
                </div>
                
                <div class="form-group">
                    <label> Alergias (opcional):</label>
                    <textarea name="alergias" rows="2" placeholder="Ej: Penicilina, Ibuprofeno, etc."><?= $paciente_editar ? htmlspecialchars($paciente_editar['alergias']) : '' ?></textarea>
                    <small style="color: #666;">Este campo puede quedar vacío (acepta valores nulos)</small>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label> Tipo de Sangre (SELECT):</label>
                        <select name="tipo_sangre" required>
                            <option value="">Seleccione tipo de sangre</option>
                            <option value="A+" <?= $paciente_editar && $paciente_editar['tipo_sangre'] == 'A+' ? 'selected' : '' ?>>A+</option>
                            <option value="A-" <?= $paciente_editar && $paciente_editar['tipo_sangre'] == 'A-' ? 'selected' : '' ?>>A-</option>
                            <option value="B+" <?= $paciente_editar && $paciente_editar['tipo_sangre'] == 'B+' ? 'selected' : '' ?>>B+</option>
                            <option value="B-" <?= $paciente_editar && $paciente_editar['tipo_sangre'] == 'B-' ? 'selected' : '' ?>>B-</option>
                            <option value="O+" <?= $paciente_editar && $paciente_editar['tipo_sangre'] == 'O+' ? 'selected' : '' ?>>O+</option>
                            <option value="O-" <?= $paciente_editar && $paciente_editar['tipo_sangre'] == 'O-' ? 'selected' : '' ?>>O-</option>
                            <option value="AB+" <?= $paciente_editar && $paciente_editar['tipo_sangre'] == 'AB+' ? 'selected' : '' ?>>AB+</option>
                            <option value="AB-" <?= $paciente_editar && $paciente_editar['tipo_sangre'] == 'AB-' ? 'selected' : '' ?>>AB-</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label> Prioridad:</label>
                        <div class="radio-group">
                            <label><input type="radio" name="prioridad" value="normal" checked> Normal</label>
                            <label><input type="radio" name="prioridad" value="urgente"> Urgente</label>
                            <label><input type="radio" name="prioridad" value="critico"> Crítico</label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Doctor Asignado:</label>
                    <select name="doctor_asignado" required>
                        <option value="Dr. Carlos Pérez" <?= $paciente_editar && $paciente_editar['doctor_asignado'] == 'Dr. Carlos Pérez' ? 'selected' : '' ?>>Dr. Carlos Pérez</option>
                        <option value="Dra. Laura Martínez" <?= $paciente_editar && $paciente_editar['doctor_asignado'] == 'Dra. Laura Martínez' ? 'selected' : '' ?>>Dra. Laura Martínez</option>
                        <option value="Dr. Miguel Ángel Rivas" <?= $paciente_editar && $paciente_editar['doctor_asignado'] == 'Dr. Miguel Ángel Rivas' ? 'selected' : '' ?>>Dr. Miguel Ángel Rivas</option>
                    </select>
                </div>
                
                <button type="submit" class="btn"><?= $paciente_editar ? ' Actualizar Paciente' : ' Registrar Paciente' ?></button>
                <?php if($paciente_editar): ?>
                    <a href="dashboard.php" class="btn" style="background: #6c757d;"> Cancelar</a>
                <?php endif; ?>
            </form>

            <h2 style="margin-top: 40px;"> Lista de Pacientes Registrados</h2>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Paciente</th>
                            <th>Edad</th>
                            <th>Teléfono</th>
                            <th>Enfermedad</th>
                            <th>Alergias</th>
                            <th>Tipo Sangre</th>
                            <th>Doctor</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        
                        $pacientes_lista = $conexion->query("SELECT * FROM pacientes ORDER BY fecha_consulta DESC");
                        if($pacientes_lista && $pacientes_lista->num_rows > 0):
                        while($p = $pacientes_lista->fetch_assoc()): 
                        ?>
                        <tr>
                            <td data-label="ID"><?= $p['id'] ?></td>
                            <td data-label="Paciente"><?= htmlspecialchars($p['nombre'] . ' ' . $p['apellido']) ?></td>
                            <td data-label="Edad"><?= $p['edad'] ?> años</td>
                            <td data-label="Teléfono"><?= htmlspecialchars($p['telefono']) ?></td>
                            <td data-label="Enfermedad"><?= htmlspecialchars($p['enfermedad']) ?></td>
                            <td data-label="Alergias"><?= $p['alergias'] ? htmlspecialchars($p['alergias']) : '—' ?></td>
                            <td data-label="Tipo Sangre"><?= $p['tipo_sangre'] ?></td>
                            <td data-label="Doctor"><?= htmlspecialchars($p['doctor_asignado']) ?></td>
                            <td data-label="Acciones" class="acciones">
                                <a href="dashboard.php?editar=<?= $p['id'] ?>" class="btn-editar"> Editar</a>
                                <a href="dashboard.php?eliminar=<?= $p['id'] ?>" class="btn-eliminar" onclick="return confirm('¿Estás seguro de eliminar este paciente?')"> Eliminar</a>
                            </td>
                        </tr>
                        <?php 
                        endwhile;
                        else:
                        ?>
                        <tr>
                            <td colspan="9" style="text-align: center;">No hay pacientes registrados</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>