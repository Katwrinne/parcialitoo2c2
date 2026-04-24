<?php
session_start();
if(isset($_SESSION['usuario'])) {
    header("Location: dashboard.php");
    exit();
}

include 'conexion.php';
$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    
    $sql = "SELECT * FROM usuarios WHERE email='$email' AND password='$password'";
    $result = $conexion->query($sql);
    
    if($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['usuario'] = $email;
        $_SESSION['nombre'] = $user['nombre_completo'];
        $_SESSION['rol'] = $user['rol'];
        header("Location: dashboard.php");
    } else {
        $error = " Credenciales incorrectas. Verifica tu email y contraseña.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Farmacias La Buena</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-box">
        <h2>Acceso al Sistema</h2>
        <?php if($error): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Correo Electrónico:</label>
                <input type="email" name="email" required placeholder="correo@ejemplo.com">
            </div>
            <div class="form-group">
                <label>Contraseña:</label>
                <input type="password" name="password" required placeholder="Ingresa tu contraseña">
            </div>
            <button type="submit" class="btn">Ingresar al Sistema</button>
        </form>
        <p style="text-align: center; margin-top: 20px; font-size: 14px; color: #666;">
            Demo: admin@farmacia.com / admin123
        </p>
    </div>
</body>
</html>