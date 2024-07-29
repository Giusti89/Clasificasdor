<!-- resources/views/errorPage.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error de Conexión</title>
</head>
<body>
    <h1>Error de Conexión a la Base de Datos</h1>
    <p>{{ session('error') }}</p>
    <p>Por favor, inténtelo más tarde.</p>
</body>
</html>