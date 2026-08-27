<?php
// Modo edición: se activa cuando el controlador encuentra un cliente por ID
$editando     = !empty($clienteEditar);
$valNombre    = $editando ? $clienteEditar->nombre : '';
$valDocumento = $editando ? $clienteEditar->documento : '';
$valCorreo    = $editando ? $clienteEditar->correo : '';
$valTelefono  = $editando ? $clienteEditar->telefono : '';
$valDireccion = $editando ? $clienteEditar->direccion : '';
?>
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

    <!-- Hoja de estilos -->
    <link rel="stylesheet" href="assets/css/estilos.css">
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

            <!-- Formulario de doble propósito:
                   - CREAR (POST) y EDITAR por PUT -> envío normal del formulario.
                   - EDITAR por PATCH -> el JS intercepta el submit y usa fetch.
                 El modo PUT lo activa el servidor ($editando); el modo PATCH, el JS. -->
            <div class="form-card" id="form-card">
                <h2 id="form-titulo">
                    <i class="fa-solid <?= $editando ? 'fa-user-pen' : 'fa-user-plus' ?>"></i>
                    <?= $editando ? 'Editar Cliente' : 'Registrar Cliente' ?>
                    <?php if ($editando): ?>
                        <span class="badge-editando">PUT #<?= htmlspecialchars($clienteEditar->id) ?></span>
                    <?php endif; ?>
                </h2>

                <form id="form-cliente" method="POST"
                      action="<?= $editando ? 'index.php?accion=actualizar&id=' . htmlspecialchars($clienteEditar->id) : 'index.php?accion=crear' ?>">

                    <?php if ($editando): ?>
                        <!-- Los formularios HTML solo envían GET o POST,
                             este campo le indica al controlador que es un PUT -->
                        <input type="hidden" name="_method" value="PUT">
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="nombre">Nombre Completo *</label>
                        <input type="text" id="nombre" name="nombre" required placeholder="Ej. Juan Pérez" value="<?= htmlspecialchars($valNombre) ?>">
                    </div>

                    <div class="form-group">
                        <label for="documento">Documento (DUI/NIT) *</label>
                        <input type="text" id="documento" name="documento" required placeholder="Ej. 01234567-8" value="<?= htmlspecialchars($valDocumento) ?>">
                    </div>

                    <div class="form-group">
                        <label for="correo">Correo Electrónico *</label>
                        <input type="email" id="correo" name="correo" required placeholder="cliente@correo.com" value="<?= htmlspecialchars($valCorreo) ?>">
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono *</label>
                        <input type="tel" id="telefono" name="telefono" required placeholder="Ej. 7777-8888" value="<?= htmlspecialchars($valTelefono) ?>">
                    </div>

                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" id="direccion" name="direccion" placeholder="Ej. San Salvador, El Salvador" value="<?= htmlspecialchars($valDireccion) ?>">
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit" id="btn-principal">
                            <i class="fa-solid <?= $editando ? 'fa-rotate' : 'fa-floppy-disk' ?>"></i>
                            <span id="btn-texto"><?= $editando ? 'Actualizar Cliente' : 'Guardar Cliente' ?></span>
                        </button>

                        <!-- Cancelar del modo PATCH: el JS lo muestra y lo oculta -->
                        <button type="button" class="btn-cancel" id="btn-cancelar" onclick="cancelarEdicion()" style="display: none;">
                            Cancelar
                        </button>
                    </div>

                    <?php if ($editando): ?>
                        <!-- Cancelar del modo PUT: basta con volver al index sin ?id -->
                        <a href="index.php" class="btn-cancelar">
                            <i class="fa-solid fa-xmark"></i> Cancelar edición
                        </a>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Integrantes del equipo -->
            <div class="team-card">
                <h2><i class="fa-solid fa-people-group"></i> Integrantes del Equipo</h2>
                <ul class="team-list">
                    <li>
                        <span>Cruz Vásquez, Josthyn Stanley</span>
                        <span class="team-carnet">CV-64711-23</span>
                    </li>
                    <li>
                        <span>Flores Molina, Carlos Ernesto</span>
                        <span class="team-carnet">FM-63450-22</span>
                    </li>
                    <li>
                        <span>Interiano Figueroa, Héctor Alonso</span>
                        <span class="team-carnet">IF-64141-23</span>
                    </li>
                    <li>
                        <span>Monterrosa Portillo, Christian Eduardo</span>
                        <span class="team-carnet">MP-64203-23</span>
                    </li>
                </ul>
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
                            <tr class="<?= ($editando && $clienteEditar->id == $c->id) ? 'fila-editando' : '' ?>">
                                <td><strong>#<?= htmlspecialchars($c->id) ?></strong></td>
                                <td><span class="doc-badge"><?= htmlspecialchars($c->documento ?? 'N/A') ?></span></td>
                                <td><strong><?= htmlspecialchars($c->nombre) ?></strong></td>
                                <td><?= htmlspecialchars($c->correo) ?></td>
                                <td><?= htmlspecialchars($c->telefono ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($c->direccion ?? 'N/A') ?></td>
                                <td>
                                    <div class="acciones">
                                        <!-- Editar por PUT: recarga la página con el formulario ya lleno -->
                                        <a href="index.php?id=<?= $c->id ?>" class="btn-edit" title="Editar enviando un PUT (recarga la página)">
                                            <i class="fa-solid fa-pen-to-square"></i> PUT
                                        </a>

                                        <!-- Editar por PATCH: llena el formulario sin recargar -->
                                        <button class="btn-edit btn-edit-patch"
                                            title="Editar enviando un PATCH (solo viajan los campos que cambien)"
                                            data-id="<?= htmlspecialchars($c->id) ?>"
                                            data-nombre="<?= htmlspecialchars($c->nombre) ?>"
                                            data-documento="<?= htmlspecialchars($c->documento ?? '') ?>"
                                            data-correo="<?= htmlspecialchars($c->correo) ?>"
                                            data-telefono="<?= htmlspecialchars($c->telefono ?? '') ?>"
                                            data-direccion="<?= htmlspecialchars($c->direccion ?? '') ?>"
                                            onclick="editarCliente(this)">
                                            <i class="fa-solid fa-pen"></i> PATCH
                                        </button>

                                        <button class="btn-delete" onclick="confirmarEliminacion(<?= $c->id ?>, '<?= htmlspecialchars(addslashes($c->nombre)) ?>')">
                                            <i class="fa-solid fa-trash-can"></i> Eliminar
                                        </button>
                                    </div>
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

        // ¿El servidor abrió el formulario en modo PUT? (llegamos con ?id= en la URL)
        const MODO_PUT = <?= $editando ? 'true' : 'false' ?>;

        // Guarda los valores ORIGINALES del cliente en edición por PATCH (para saber qué cambió).
        // Si es null, el formulario NO está en modo PATCH.
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
            // En modo PUT el formulario lo llenó el servidor: limpiarlo aquí dejaría
            // la acción apuntando a "actualizar". Volvemos al index sin ?id.
            if (MODO_PUT) {
                window.location.href = 'index.php';
                return;
            }

            clienteEnEdicion = null;
            document.getElementById('form-cliente').reset();
            document.getElementById('form-titulo').innerHTML = '<i class="fa-solid fa-user-plus"></i> Registrar Cliente';
            document.getElementById('btn-texto').textContent = 'Guardar Cliente';
            document.getElementById('btn-cancelar').style.display = 'none';
            document.getElementById('form-card').classList.remove('modo-edicion');
        }

        // Interceptamos el envío del formulario.
        document.getElementById('form-cliente').addEventListener('submit', async (e) => {
            // Sin PATCH activo dejamos pasar el envío normal del formulario:
            // sirve tanto para CREAR (POST) como para EDITAR por PUT.
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
            } else if (status === 'updated') {
                Swal.fire({
                    icon: 'success',
                    title: '¡Cliente Actualizado!',
                    text: 'Los datos del cliente se guardaron correctamente.',
                    timer: 2500,
                    showConfirmButton: false
                });
            } else if (status === 'deleted') {
                Swal.fire({
                    icon: 'success',
                    title: '¡Cliente Eliminado!',
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