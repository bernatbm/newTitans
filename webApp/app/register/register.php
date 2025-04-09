<!-- register.php -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar usuario</title>
</head>
<body>
  <h1>Registrar usuario</h1>
  <form method="POST" action="register_process.php">
  <input type="text" name="nombre" required>
  <input type="text" name="apellido1" required>
  <input type="text" name="apellido2" required>
  <input type="text" name="direccion" required>
  <input type="text" name="codigoPostal" required>
  <input type="text" name="ciudad" required>
  <input type="text" name="pais" required>
  <input type="email" name="email" required>
  <input type="password" name="password" required>
  <button type="submit">Registrarse</button>
</form>

</body>
</html>
