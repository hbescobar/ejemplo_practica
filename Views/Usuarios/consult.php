<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-body">
            <h4 class="fw-bold text-success text-center mb-4">
                <i class='bx bx-package'></i> Listado de Usuarios
            </h4>

            <!-- Filtro, busqueda y exportacion a excel -->
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                <div class="input-group" style="max-width: 220px;">
                    <label class="input-group-text bg-success text-white" for="filtroTipo">
                        <i class='bx bx-filter-alt'></i>
                    </label>
                    <select id="filtroTipo" class="form-select">
                        <option value="codigo">Por N° Documento</option>
                        <option value="nombre">Por Nombre</option>
                        <option value="correo">Por Correo</option>
                        <option value="telefono">Por Teléfono</option>
                        <option value="rol">Por Rol</option>
                    </select>
                </div>

                <div class="input-group" style="max-width: 300px;">
                    <span class="input-group-text bg-success text-white">
                        <i class='bx bx-search'></i>
                    </span>
                    <input type="search" id="buscadorUsuarios" class="form-control" placeholder="Buscar..." aria-label="Buscar">
                </div>

                <!-- Agrupa los botones aquí -->
                <div class="d-flex gap-2">
                    <a href="<?= getUrl('usuarios', 'usuarios', 'getInsert'); ?>" class="btn btn-success">
                        <i class='bx bx-user-plus'></i> Registrar Nuevo Usuario
                    </a>
                    <!-- Botón para exportar a Excel -->
                    <button id="btnExportarExcelUsuarios" class="btn btn-outline-success" type="button">
                        <i class='bx bxs-file-export'></i> Exportar Excel
                    </button>
                </div>
            </div>

            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center" id="tablaUsuarios">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tipo Documento</th>
                            <th>Numero de Documento</th>
                            <th>Nombre Completo</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($usuarios)) : ?>
                            <?php foreach ($usuarios as $usuario) : ?>
                                <tr>
                                    <td><?= $usuario['usu_id']; ?></td>
                                    <td><?= $usuario['tipo_docu_nombre']; ?></td>
                                    <td><?= $usuario['usu_numero_docu']; ?></td>
                                    <td><?= $usuario['usu_nombre'] . ' ' . $usuario['usu_apellido']; ?></td>
                                    <td><?= $usuario['usu_email']; ?></td>
                                    <td><?= $usuario['usu_telefono']; ?></td>
                                    <td><?= $usuario['rol_nombre']; ?></td>
                                    <td class="text-center">
                                        <?php if ($usuario['estado_nombre'] == 'Activo'): ?><!-- Si el estado es Activo, mostrar botón para cambiar a Inactivo -->
                                            <button class="btn btn-success btn-sm" onclick="abrirModalClave(<?= $usuario['usu_id']; ?>, 'Inactivo')">Activo</button><!-- Botón para cambiar a Inactivo -->
                                        <?php else: ?>
                                            <button class="btn btn-secondary btn-sm" onclick="abrirModalClave(<?= $usuario['usu_id']; ?>, 'Activo')">Inactivo</button><!-- Si el estado es Inactivo, mostrar botón para cambiar a Activo -->
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="<?= getUrl('usuarios', 'usuarios', 'getEdit', ['id' => $usuario['usu_id']]); ?>" class="btn btn-sm btn-warning" title="Editar">
                                                <i class='bx bx-edit-alt'></i>
                                            </a>
                                            <a href="<?= getUrl('usuarios', 'usuarios', 'ver', ['id' => $usuario['usu_id']]); ?>" class="btn btn-sm btn-info" title="Ver Detalle">
                                                <i class='bx bx-show'></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="8" class="text-center">No hay usuarios registrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Modal de Validación de Clave -->
            <div class="modal fade" id="modalClaveUsu" tabindex="-1" aria-labelledby="modalClaveUsuLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <form method="POST"
                        action="<?= getUrl('usuarios', 'usuarios', 'cambiarEstadoConClave') ?>"
                        class="modal-content rounded-4 shadow-lg overflow-hidden">

                        <!-- Cabecera con degradado e icono -->
                        <div class="modal-header py-3 text-white"
                            style="background:linear-gradient(135deg,#0d6efd 0%,#0a58ca 100%);">
                            <h5 class="modal-title d-flex align-items-center gap-2 mb-0" id="modalClaveUsuLabel">
                            <i class="bi bi-shield-lock-fill fs-4"></i>
                            Confirmar cambio de estado
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>

                        <!-- Cuerpo -->
                        <div class="modal-body">
                            <p class="mb-3">Ingrese su contraseña para confirmar el cambio de estado del usuario.</p>

                            <div class="form-floating">
                            <input type="password" name="clave" class="form-control" id="claveModal"
                                    placeholder="Contraseña" required>
                            <label for="claveModal"><i class="bi bi-key"></i> Contraseña</label>
                            </div>

                            <!-- Ocultos -->
                            <input type="hidden" name="usuario_id" id="usuarioId">
                            <input type="hidden" name="nuevo_estado" id="nuevoEstado">
                        </div>

                        <!-- Pie -->
                        <div class="modal-footer bg-light border-top-0">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg"></i> Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Confirmar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Paginación -->
            <div class="d-flex justify-content-center mt-4">
                <nav>
                    <ul class="pagination" id="paginacionTabla"></ul>
                </nav>
            </div>
            <!-- Importar librería para exportar a Excel -->
            <!-- Esta libreria permite exportar tablas HTML a archivos Excel -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
        </div>
    </div>
</div>

<!-- JS para exportar a Excel -->
<script>
// Función para exportar la tabla a Excel
document.getElementById('btnExportarExcelUsuarios').addEventListener('click', function () {
    const tabla = document.getElementById('tablaUsuarios');// Obtener la tabla
    const filas = Array.from(tabla.querySelectorAll('tbody tr'));// Convertir las filas de la tabla en un array
    const filasExportar = [];// Array para almacenar las filas a exportar

    // Agregar los encabezados de la tabla
    const headers = [];// Array para los encabezados vacío
    tabla.querySelectorAll('thead th').forEach(th => headers.push(th.innerText));// Agregar los encabezados al array
    filasExportar.push(headers);// Agregar los encabezados al array de filas a exportar

    // Obtener el filtro y búsqueda actual
    const inputBusqueda = document.getElementById('buscadorUsuarios');
    const filtroTipo = document.getElementById('filtroTipo');
    const valor = inputBusqueda.value.toLowerCase().trim();
    const tipo = filtroTipo.value;

    // Filtrar todas las filas según el filtro y búsqueda
    const filtradas = filas.filter(fila => {
        const celdas = fila.cells;
        const [codigo, nombre, rol] = [
            celdas[2].textContent.toLowerCase(), // Numero de Documento
            celdas[3].textContent.toLowerCase(), // Nombre Completo
            celdas[6].textContent.toLowerCase(), // Rol
        ];
        switch (tipo) {
            case 'codigo':
                return codigo.includes(valor);
            case 'nombre':
                return nombre.includes(valor);
            case 'rol':
                return rol.includes(valor);
            default:
                return true;
        }
    });

    // Agregar todas las filas filtradas
    filtradas.forEach(fila => {
        const row = [];
        fila.querySelectorAll('td').forEach(td => {
            let texto = td.textContent.replace(/\s+/g, ' ').trim();
            row.push(texto);
        });
        filasExportar.push(row);
    });

    // Crear hoja y libro
    const ws = XLSX.utils.aoa_to_sheet(filasExportar);// Convertir el array de filas a una hoja de Excel
    XLSX.utils.book_append_sheet(wb, ws, "Usuarios");// Agregar la hoja al libro

    // Descargar
    XLSX.writeFile(wb, "usuarios_filtrados.xlsx");// Descargar el archivo Excel
});
</script>

<!-- JS Este script maneja el modal para cambio de estado -->
<script>
    function abrirModalClave(id, estado) {
        document.getElementById('usuarioId').value = id;
        document.getElementById('nuevoEstado').value = estado;
        const modal = new bootstrap.Modal(document.getElementById('modalClaveUsu'));
        modal.show();
    }
</script>

<!-- JS búsqueda + paginación -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Elementos del DOM
        const inputBusqueda = document.getElementById('buscadorUsuarios'); // Input para escribir la búsqueda
        const filtroTipo = document.getElementById('filtroTipo'); // Select para elegir el tipo de filtro
        const tabla = document.getElementById('tablaUsuarios').getElementsByTagName('tbody')[0]; // Cuerpo de la tabla
        const paginacion = document.getElementById('paginacionTabla'); // Contenedor para los botones de paginación
        const filas = Array.from(tabla.rows); // Convierte las filas de la tabla en un array
        const filasPorPagina = 6; // Cuántas filas mostrar por página
        let paginaActual = 1; // Página actual

        // Función para mostrar la tabla según búsqueda y paginación
        const renderTabla = () => {
            const valor = inputBusqueda.value.toLowerCase().trim(); // Texto de búsqueda en minúsculas
            const tipo = filtroTipo.value; // Tipo de filtro seleccionado

            // Filtrar las filas según lo que se escribió y el tipo seleccionado
            const filtradas = filas.filter(fila => {
                const celdas = fila.cells;
                const [codigo, nombre, correo, telefono, rol] = [
                    celdas[2].textContent.toLowerCase(), // Numero de Documento
                    celdas[3].textContent.toLowerCase(), // Nombre Completo
                    celdas[4].textContent.toLowerCase(), // Correo
                    celdas[5].textContent.toLowerCase(), // Teléfono
                    celdas[6].textContent.toLowerCase(), // Rol
                ];

                // Aplica el filtro según el tipo elegido
                switch (tipo) {
                    case 'codigo':
                        return codigo.includes(valor);
                    case 'nombre':
                        return nombre.includes(valor);
                    case 'correo':
                        return correo.includes(valor);
                    case 'telefono':
                        return telefono.includes(valor);
                    case 'rol':
                        return rol.includes(valor);
                    default:
                        return true;
                }
            });
            
            // Calcular paginación
            const totalPaginas = Math.ceil(filtradas.length / filasPorPagina);
            const inicio = (paginaActual - 1) * filasPorPagina;
            const fin = inicio + filasPorPagina;

            // Ocultar todas las filas
            filas.forEach(fila => fila.style.display = 'none');

            // Mostrar solo las filas filtradas que pertenecen a la página actual
            filtradas.slice(inicio, fin).forEach(fila => fila.style.display = '');

            // Mostar mensaje si no hay resultados
            const mensajeNoResultadosId = 'mensaje-no-resultados';
            let mensajeNoResultados = document.getElementById(mensajeNoResultadosId);

            if (filtradas.length === 0) {
                if (!mensajeNoResultados) {
                    mensajeNoResultados = document.createElement('tr');
                    mensajeNoResultados.id = mensajeNoResultadosId;
                    mensajeNoResultados.innerHTML = `
                        <td colspan="9" class="text-center text-danger fw-bold py-3">
                            No se encontraron resultados.
                        </td>
                    `;
                    tabla.appendChild(mensajeNoResultados);
                }
            } else {
                const existente = document.getElementById(mensajeNoResultadosId);
                if (existente) {
                    existente.remove();
                }
            }
            // Crear botones de paginación
            renderPaginacion(totalPaginas);
        };

        // Función para crear y mostrar los botones de paginación
        const renderPaginacion = (totalPaginas) => {
            paginacion.innerHTML = ''; // Limpiar paginación anterior

            // No mostrar nada si solo hay una página
            if (totalPaginas <= 1) return;

            // Función interna para crear cada botón
            const crearItem = (label, pagina, disabled = false, active = false) => {
                const li = document.createElement('li');
                li.className = `page-item${disabled ? ' disabled' : ''}${active ? ' active' : ''}`;

                const a = document.createElement('a');
                a.className = 'page-link';
                a.href = '#';
                a.innerHTML = label;

                //Cambio de color Números y flechas en verde
                if (!isNaN(label) || label === '&laquo;' || label === '&raquo;') {
                    a.classList.add('text-success');
                }
                // Activo: fondo y borde verde, texto blanco
                if (active) {
                    a.classList.add('bg-success', 'text-white', 'border-success');
                }

                a.onclick = e => {
                    e.preventDefault();
                    if (!disabled && pagina !== paginaActual) {
                        paginaActual = pagina;
                        renderTabla(); // Recargar la tabla
                    }
                };

                li.appendChild(a);
                return li;
            };

            // Botón de "anterior"
            paginacion.appendChild(crearItem('&laquo;', paginaActual - 1, paginaActual === 1));

            // Botones numéricos
            for (let i = 1; i <= totalPaginas; i++) {
                paginacion.appendChild(crearItem(i, i, false, paginaActual === i));
            }

            // Botón de "siguiente"
            paginacion.appendChild(crearItem('&raquo;', paginaActual + 1, paginaActual === totalPaginas));
        };

        // Eventos para actualizar tabla cuando se escribe o cambia el filtro
        inputBusqueda.addEventListener('input', () => {
            paginaActual = 1;
            renderTabla();
        });

        filtroTipo.addEventListener('change', () => {
            paginaActual = 1;
            renderTabla();
        });

        // Mostrar la tabla al cargar la página
        renderTabla();
    });
</script>