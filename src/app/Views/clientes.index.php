<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes - UPED</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f4f6f9;
            color: #333;
            padding: 30px;
        }

        /* Contenedor principal de 2 columnas */
        .main-container {
            display: flex;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            align-items: flex-start;
        }

        /* Columna Izquierda: Logo + Formulario */
        .left-column {
            flex: 1;
            max-width: 380px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .logo-card {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            text-align: center;
        }

        .logo-card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .form-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .form-card h2 {
            font-size: 1.2rem;
            margin-bottom: 18px;
            color: #0d47a1;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 8px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 0.88rem;
            font-weight: 600;
            margin-bottom: 6px;
            color: #444;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 0.95rem;
            transition: border-color 0.2s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #0d47a1;
        }

        button.btn-submit {
            width: 100%;
            background-color: #0d47a1;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 6px;
            font-size: 0.95rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }

        button.btn-submit:hover {
            background-color: #082c66;
        }

        /* Columna Derecha: Tabla */
        .right-column {
            flex: 2;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .right-column h2 {
            font-size: 1.3rem;
            margin-bottom: 18px;
            color: #333;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.92rem;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }

        th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        tr:hover {
            background-color: #f1f3f5;
        }

        .no-data {
            text-align: center;
            color: #888;
            padding: 20px;
        }

        /* Responsivo en pantallas pequeñas */
        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
            }

            .left-column {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="main-container">

        <!-- LADO IZQUIERDO: LOGO Y FORMULARIO -->
        <div class="left-column">
            
            <!-- Imagen arriba del formulario -->
            <div class="logo-card">
                <img src="https://res.cloudinary.com/bcwlyire/image/upload/v1785118882/NUEVO-LOGO-UPED-A-COLOR-scaled_szoqws.jpg" alt="Logo UPED">
            </div>

            <!-- Formulario con GET -->
            <div class="form-card">
                <h2>Registrar Cliente</h2>

                <form action="index.php" method="GET">
                    <div class="form-group">
                        <label for="nombre">Nombre Completo:</label>
                        <input type="text" id="nombre" name="nombre" required placeholder="Ej. Juan Pérez">
                    </div>

                    <div class="form-group">
                        <label for="correo">Correo Electrónico:</label>
                        <input type="email" id="correo" name="correo" required placeholder="usuario@correo.com">
                    </div>

                    <div class="form-group">
                        <label for="contraseña">Contraseña:</label>
                        <input type="password" id="contraseña" name="contraseña" required placeholder="••••••••">
                    </div>

                    <button type="submit" class="btn-submit">Guardar Registro</button>
                </form>
            </div>

        </div>

        <!-- LADO DERECHO: TABLA DE CLIENTES -->
        <div class="right-column">
            <h2>Listado de Clientes</h2>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Contraseña</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($clientes)): ?>

                        <?php foreach ($clientes as $c): ?>
                            <tr>
                                <td><?= htmlspecialchars($c->id) ?></td>
                                <td><?= htmlspecialchars($c->nombre) ?></td>
                                <td><?= htmlspecialchars($c->correo) ?></td>
                                <td><?= htmlspecialchars($c->contraseña) ?></td>

                                <!-- PARTE DE STANLEY: ELIMINAR CLIENTE -->
                                <td>
                                    <a href="index.php?accion=eliminar&id=<?= $c->id ?>"
                                       onclick="return confirm('¿Está seguro de eliminar este cliente?');">
                                        Eliminar
                                    </a>
                                </td>

                            </tr>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="no-data">
                                No se encontraron clientes en la base de datos.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>

    </div>

</body>
</html>