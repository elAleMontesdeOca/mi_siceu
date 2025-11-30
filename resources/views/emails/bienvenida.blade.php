<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido a SICEU</title>
</head>
<body>
    <h1>¡Bienvenido, {{ $usuario->name }}!</h1>

    <p>Tu cuenta ha sido creada correctamente en el sistema <strong>SICEU</strong>.</p>

    <p>
        Ya puedes iniciar sesión con tu correo:
        <strong>{{ $usuario->email }}</strong>
    </p>

    <p>
        Si tú no realizaste este registro, ignora este correo.
    </p>

    <p>Saludos,<br>Equipo SICEU</p>
</body>
</html>
