<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes - POS UPED</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 CSS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-color: #0d47a1;
            --primary-hover: #082c66;
            --secondary-color: #f8f9fa;
            --accent-color: #1976d2;
            --danger-color: #dc3545;
            --danger-hover: #bb2d3b;
            --text-main: #2b2d42;
            --text-muted: #6c757d;
            --border-color: #e9ecef;
            --card-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            --radius: 12px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: #f4f7fe;
            color: var(--text-main);
            padding: 30px 20px;
            min-height: 100vh;
        }

        .header-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .header-title h1 {
            font-size: 1.8rem;
            color: var(--primary-color);
            font-weight: 700;
        }

        .header-title p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        /* Contenedor principal de 2 columnas */
        .main-container {
            display: flex;
            gap: 25px;
            max-width: 1400px;
            margin: 0 auto;
            align-items: flex-start;
        }

        /* Columna Izquierda: Formulario */
        .left-column {
            flex: 1;
            min-width: 360px;
            max-width: 420px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .logo-card {
            background: white;
            padding: 20px;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
            text-align: center;
        }

        .logo-card img {
            max-width: 220px;
            height: auto;
            border-radius: 8px;
        }

        .form-card {
            background: white;
            padding: 25px;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
        }

        .form-card h2 {
            font-size: 1.25rem;
            margin-bottom: 20px;
            color: var(--primary-color);
            border-bottom: 2px solid #eef2f7;
            padding-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 0.88rem;
            font-weight: 600;
            margin-bottom: 6px;
            color: #495057;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            font-size: 0.92rem;
            transition: all 0.2s ease;
            background-color: #fafafa;
        }

        .form-group input:focus, .form-group textarea:focus {
            outline: none;
            border-color: var(--accent-color);
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.15);
        }

        button.btn-submit {
            width: 100%;
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 10px;
        }

        button.btn-submit:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        /* Columna Derecha: Tabla Ampliada */
        .right-column {
            flex: 2.5;
            background: white;
            padding: 25px;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
            overflow-x: auto;
        }

        .right-column-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #eef2f7;
            padding-bottom: 10px;
        }

        .right-column-header h2 {
            font-size: 1.3rem;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .badge-count {
            background: #e3f2fd;
            color: var(--primary-color);
            font-size: 0.85rem;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.92rem;
            text-align: left;
        }

        th, td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.78rem;
            letter-spacing: 0.6px;
        }

        tr:hover {
            background-color: #f8fafc;
        }

        .doc-badge {
            background-color: #f1f5f9;
            color: #334155;
            padding: 4px 8px;
            border-radius: 6px;
            font-family: monospace;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .no-data {
            text-align: center;
            color: var(--text-muted);
            padding: 40px 20px;
            font-size: 1rem;
        }

        .btn-delete {
            background-color: #fff0f1;
            color: var(--danger-color);
            border: 1px solid #fecdd3;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-delete:hover {
            background-color: var(--danger-color);
            color: white;
            border-color: var(--danger-color);
        }

        .btn-edit {
            background-color: #eef4ff;
            color: var(--accent-color);
            border: 1px solid #bcd4fb;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-right: 6px;
        }

        .btn-edit:hover {
            background-color: var(--accent-color);
            color: white;
            border-color: var(--accent-color);
        }

        /* Fila de botones del formulario (Guardar/Actualizar + Cancelar) */
        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .form-actions .btn-submit {
            margin-top: 0;
        }

        /* Botón cancelar (solo visible en modo edición) */
        .btn-cancel {
            background-color: #f1f5f9;
            color: var(--text-muted);
            border: none;
            padding: 12px 18px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-cancel:hover {
            background-color: #e2e8f0;
        }

        /* Resalta la tarjeta del formulario cuando estás editando */
        .form-card.modo-edicion {
            box-shadow: 0 0 0 2px var(--accent-color), var(--card-shadow);
        }

        /* Responsivo */
        @media (max-width: 992px) {
            .main-container {
                flex-direction: column;
            }

            .left-column {
                max-width: 100%;
                width: 100%;
            }

            .right-column {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="header-title">
        <h1>Sistema de Punto de Venta (POS UPED)</h1>
        <p>Módulo de Administración y Registro de Clientes</p>
    </div>

    <div class="main-container">

        <!-- LADO IZQUIERDO: LOGO Y FORMULARIO -->
        <div class="left-column">
            
            <div class="logo-card">
                <img src="https://res.cloudinary.com/bcwlyire/image/upload/v1785118882/NUEVO-LOGO-UPED-A-COLOR-scaled_szoqws.jpg" alt="Logo UPED">
            </div>

            <!-- Formulario doble propósito: CREAR (POST) o EDITAR (PATCH) -->
            <div class="form-card" id="form-card">
                <h2 id="form-titulo"><i class="fa-solid fa-user-plus"></i> Registrar Cliente</h2>

                <form action="index.php?accion=crear" method="POST" id="form-cliente">
                    <div class="form-group">
                        <label for="nombre">Nombre Completo *</label>
                        <input type="text" id="nombre" name="nombre" required placeholder="Ej. Juan Pérez">
                    </div>

                    <div class="form-group">
                        <label for="documento">Documento (DUI/NIT) *</label>
                        <input type="text" id="documento" name="documento" required placeholder="Ej. 01234567-8">
                    </div>

                    <div class="form-group">
                        <label for="correo">Correo Electrónico *</label>
                        <input type="email" id="correo" name="correo" required placeholder="cliente@correo.com">
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono *</label>
                        <input type="text" id="telefono" name="telefono" required placeholder="Ej. 7777-8888">
                    </div>

                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" id="direccion" name="direccion" placeholder="Ej. San Salvador, El Salvador">
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit" id="btn-principal">
                            <i class="fa-solid fa-floppy-disk"></i> <span id="btn-texto">Guardar Cliente</span>
                        </button>
                        <button type="button" class="btn-cancel" id="btn-cancelar" onclick="cancelarEdicion()" style="display: none;">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <!-- LADO DERECHO: TABLA AMPLADA DE CLIENTES -->
        <div class="right-column">
            <div class="right-column-header">
                <h2><i class="fa-solid fa-users"></i> Listado de Clientes</h2>
                <span class="badge-count"><?= count($clientes ?? []) ?> Clientes Registrados</span>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Documento</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($clientes)): ?>
                        <?php foreach ($clientes as $c): ?>
                            <tr>
                                <td><strong>#<?= htmlspecialchars($c->id) ?></strong></td>
                                <td><span class="doc-badge"><?= htmlspecialchars($c->documento ?? 'N/A') ?></span></td>
                                <td><strong><?= htmlspecialchars($c->nombre) ?></strong></td>
                                <td><?= htmlspecialchars($c->correo) ?></td>
                                <td><?= htmlspecialchars($c->telefono ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($c->direccion ?? 'N/A') ?></td>
                                <td>
                                    <button class="btn-edit"
                                        data-id="<?= htmlspecialchars($c->id) ?>"
                                        data-nombre="<?= htmlspecialchars($c->nombre) ?>"
                                        data-documento="<?= htmlspecialchars($c->documento ?? '') ?>"
                                        data-correo="<?= htmlspecialchars($c->correo) ?>"
                                        data-telefono="<?= htmlspecialchars($c->telefono ?? '') ?>"
                                        data-direccion="<?= htmlspecialchars($c->direccion ?? '') ?>"
                                        onclick="editarCliente(this)">
                                        <i class="fa-solid fa-pen"></i> Editar
                                    </button>
                                    <button class="btn-delete" onclick="confirmarEliminacion(<?= $c->id ?>, '<?= htmlspecialchars(addslashes($c->nombre)) ?>')">
                                        <i class="fa-solid fa-trash-can"></i> Eliminar
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="no-data">
                                <i class="fa-solid fa-folder-open" style="font-size: 2rem; margin-bottom: 10px; display:block;"></i>
                                No se encontraron clientes registrados en la base de datos.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- Scripts para SweetAlert2 -->
    <script>
        function confirmarEliminacion(id, nombre) {
            Swal.fire({
                title: '¿Eliminar cliente?',
                text: `¿Estás seguro de eliminar a "${nombre}"? Esta acción no se puede revertir.`,
                icon: 'warning',
                showCancelButton: true,
                confirmColor: '#dc3545',
                cancelColor: '#6c757d',
                confirmButtonText: '<i class="fa-solid fa-trash-can"></i> Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `index.php?accion=eliminar&id=${id}`;
                }
            });
        }

        // Lista de campos que maneja el formulario.
        const CAMPOS = ['nombre', 'documento', 'correo', 'telefono', 'direccion'];

        // Guarda los valores ORIGINALES del cliente en edición (para saber qué cambió).
        // Si es null, el formulario está en modo "crear".
        let clienteEnEdicion = null;

        // Al pulsar "Editar": llena el formulario de la izquierda con los datos del cliente.
        function editarCliente(btn) {
            clienteEnEdicion = {
                id:        btn.dataset.id,
                nombre:    btn.dataset.nombre,
                documento: btn.dataset.documento,
                correo:    btn.dataset.correo,
                telefono:  btn.dataset.telefono,
                direccion: btn.dataset.direccion
            };

            // Cargamos cada dato en su campo del formulario.
            CAMPOS.forEach(campo => {
                document.getElementById(campo).value = clienteEnEdicion[campo];
            });

            // Cambiamos el formulario a "modo edición".
            document.getElementById('form-titulo').innerHTML = '<i class="fa-solid fa-user-pen"></i> Editar Cliente';
            document.getElementById('btn-texto').textContent = 'Actualizar Cliente';
            document.getElementById('btn-cancelar').style.display = 'block';
            document.getElementById('form-card').classList.add('modo-edicion');

            // Llevamos la vista al formulario (útil en móvil o listas largas).
            document.getElementById('form-card').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        // Vuelve el formulario a "modo crear".
        function cancelarEdicion() {
            clienteEnEdicion = null;
            document.getElementById('form-cliente').reset();
            document.getElementById('form-titulo').innerHTML = '<i class="fa-solid fa-user-plus"></i> Registrar Cliente';
            document.getElementById('btn-texto').textContent = 'Guardar Cliente';
            document.getElementById('btn-cancelar').style.display = 'none';
            document.getElementById('form-card').classList.remove('modo-edicion');
        }

        // Interceptamos el envío del formulario.
        document.getElementById('form-cliente').addEventListener('submit', async (e) => {
            // Si NO estamos editando, dejamos que el formulario cree el cliente (POST normal).
            if (!clienteEnEdicion) {
                return;
            }

            // --- MODO EDICIÓN: enviamos un PATCH con SOLO los campos que cambiaron ---
            e.preventDefault();

            const cambios = new URLSearchParams();
            CAMPOS.forEach(campo => {
                const valorActual = document.getElementById(campo).value.trim();
                // Solo incluimos el campo si es distinto al valor original.
                if (valorActual !== clienteEnEdicion[campo]) {
                    cambios.append(campo, valorActual);
                }
            });

            // Si no cambió nada, no enviamos petición.
            if ([...cambios.keys()].length === 0) {
                Swal.fire({
                    icon: 'info',
                    title: 'Sin cambios',
                    text: 'No modificaste ningún dato del cliente.'
                });
                return;
            }

            try {
                const respuesta = await fetch(`index.php?accion=editar&id=${clienteEnEdicion.id}`, {
                    method: 'PATCH', // ← verbo PATCH real (visible en la pestaña Red)
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: cambios.toString()
                });
                const data = await respuesta.json();

                if (data.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: '¡Cliente Actualizado!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    // Recargamos para ver la tabla con los datos actualizados.
                    window.location.href = 'index.php';
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: data.message });
                }
            } catch (error) {
                Swal.fire({ icon: 'error', title: 'Error de conexión', text: 'No se pudo contactar al servidor.' });
            }
        });

        // Manejo de alertas emergentes enviadas desde el controlador
        document.addEventListener('DOMContentLoaded', () => {
            const status = "<?= $status ?? '' ?>";
            const errorMsg = "<?= htmlspecialchars($mensajeError ?? '') ?>";

            if (status === 'created') {
                Swal.fire({
                    icon: 'success',
                    title: '¡Cliente Registrado!',
                    text: 'El cliente ha sido guardado exitosamente.',
                    timer: 2500,
                    showConfirmButton: false
                });
            } else if (status === 'deleted') {
                Swal.fire({
                    icon: 'success',
                    title: '¡Cliente Eliminar!',
                    text: 'El registro del cliente ha sido eliminado.',
                    timer: 2500,
                    showConfirmButton: false
                });
            } else if (status === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de Validación',
                    text: errorMsg || 'Ocurrió un problema con la solicitud.',
                });
            }
        });
    </script>

</body>
</html>