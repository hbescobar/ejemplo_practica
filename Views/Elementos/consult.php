<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-body">
            <h4 class="fw-bold text-primary text-center mb-4">
                <i class='bx bx-package'></i> Listado de Elementos
            </h4>

            <!-- Filtro y búsqueda -->
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                <div class="input-group" style="max-width: 220px;">
                    <label class="input-group-text bg-primary text-white" for="filtroTipo">
                        <i class='bx bx-filter-alt'></i>
                    </label>
                    <select id="filtroTipo" class="form-select">
                        <option value="codigo">Por Código</option>
                        <option value="nombre">Por Nombre</option>
                        <option value="estado">Por Estado</option>
                        <option value="tipo">Por Tipo</option>
                    </select>
                </div>

                <div class="input-group" style="max-width: 300px;">
                    <span class="input-group-text bg-primary text-white">
                        <i class='bx bx-search'></i>
                    </span>
                    <input type="search" id="buscadorElementos" class="form-control" placeholder="Buscar..." aria-label="Buscar">
                </div>

                <a href="<?= getUrl('elementos', 'elementos', 'getInsert') ?>" class="btn btn-success">
                    <i class='bx bx-plus-circle'></i> Nuevo Elemento
                </a>
            </div>

            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center" id="tablaElementos">
                    <thead class="table-dark">
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($elementos)) : ?>
                            <?php foreach ($elementos as $el) :
                                $estado = strtolower($el['estado']);
                                $tipo = strtolower($el['tipo_elemento']);
                                $badge = match ($estado) {
                                    'disponible' => 'success',
                                    'mantenimiento' => 'warning text-dark',
                                    'inhabilitado' => 'dark',
                                    default => 'secondary',
                                };
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($el['elem_codigo']) ?></td>
                                    <td><?= htmlspecialchars($el['elem_nombre']) ?></td>
                                    <td><?= htmlspecialchars($el['tipo_elemento']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $badge ?>">
                                            <?= htmlspecialchars($el['estado']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="<?= getUrl('elementos', 'elementos', 'ver', ['id' => $el['elem_id']]) ?>" class="btn btn-sm btn-info" title="Ver Detalle">
                                                <i class='bx bx-show'></i>
                                            </a>

                                            <a href="<?= getUrl('elementos', 'elementos', 'getEdit', ['id' => $el['elem_id']]) ?>" class="btn btn-sm btn-warning" title="Editar">
                                                <i class='bx bx-edit-alt'></i>
                                            </a>

                                            <?php if ($tipo === 'devolutivo') : ?>
                                                <?php if ($estado === 'disponible') : ?>
                                                    <a href="<?= getUrl('elementos', 'elementos', 'cambiarEstado', ['id' => $el['elem_id'], 'estado' => 'Inhabilitado']) ?>" class="btn btn-sm btn-danger" title="Inhabilitar">
                                                        <i class='bx bx-block'></i>
                                                    </a>
                                                    <a href="<?= getUrl('elementos', 'elementos', 'cambiarEstado', ['id' => $el['elem_id'], 'estado' => 'Mantenimiento']) ?>" class="btn btn-sm btn-secondary" title="Enviar a Mantenimiento">
                                                        <i class='bx bx-wrench'></i>
                                                    </a>
                                                <?php elseif ($estado === 'inhabilitado') : ?>
                                                    <a href="<?= getUrl('elementos', 'elementos', 'cambiarEstado', ['id' => $el['elem_id'], 'estado' => 'Disponible']) ?>" class="btn btn-sm btn-success" title="Habilitar">
                                                        <i class='bx bx-check-circle'></i>
                                                    </a>
                                                <?php elseif ($estado === 'mantenimiento') : ?>
                                                    <a href="<?= getUrl('elementos', 'elementos', 'cambiarEstado', ['id' => $el['elem_id'], 'estado' => 'Disponible']) ?>" class="btn btn-sm btn-primary" title="Finalizar Mantenimiento">
                                                        <i class='bx bx-check-circle'></i>
                                                    </a>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <!-- Botón para agregar cantidad -->
                                                <button class="btn btn-sm btn-success btn-add"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalEntrada"
                                                        data-id="<?= $el['elem_id'] ?>"
                                                        data-nombre="<?= htmlspecialchars($el['elem_nombre']) ?>"
                                                        title="Agregar Cantidad">
                                                    <i class='bx bx-plus'></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="text-center">No hay elementos registrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Modal de Entrada de Cantidad -->
                <div class="modal fade" id="modalEntrada" tabindex="-1" aria-labelledby="modalEntradaLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="<?= getUrl('elementos', 'elementos', 'registrarEntrada') ?>"><!-- Formulario para registrar entrada -->
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="modalEntradaLabel">Registrar Entrada</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                            <input type="hidden" name="elem_id" id="inputElemId">

                            <div class="mb-3">
                                <label for="inputNombreElemento" class="form-label">Elemento</label>
                                <input type="text" class="form-control" id="inputNombreElemento" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="inputCantidad" class="form-label">Cantidad</label>
                                <input type="number" class="form-control" name="cantidad" id="inputCantidad" min="1" required>
                            </div>

                            <div class="mb-3">
                                <label for="inputFecha" class="form-label">Fecha de entrada</label>
                                <input type="date" class="form-control" name="fecha" id="inputFecha" required>
                            </div>
                            </div>
                            <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Registrar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Paginación -->
            <div class="d-flex justify-content-center mt-4">
                <nav>
                    <ul class="pagination" id="paginacionTabla"></ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Modal para registrar entrada de cantidad -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('modalEntrada');
        modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const nombre = button.getAttribute('data-nombre');

        document.getElementById('inputElemId').value = id;
        document.getElementById('inputNombreElemento').value = nombre;

        const hoy = new Date().toISOString().split('T')[0];
        document.getElementById('inputFecha').value = hoy;
        });
    });
</script>

<!-- JS búsqueda + paginación -->
<script>
    document.addEventListener('DOMContentLoaded', () => {

        // Elementos del DOM
        const inputBusqueda = document.getElementById('buscadorElementos'); // Input para escribir la búsqueda
        const filtroTipo = document.getElementById('filtroTipo'); // Select para elegir el tipo de filtro
        const tabla = document.getElementById('tablaElementos').getElementsByTagName('tbody')[0]; // Cuerpo de la tabla
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
                const [codigo, nombre, tipoEl, estado] = [
                    celdas[0].textContent.toLowerCase(),
                    celdas[1].textContent.toLowerCase(),
                    celdas[2].textContent.toLowerCase(),
                    celdas[3].textContent.toLowerCase()
                ];

                // Aplica el filtro según el tipo elegido
                switch (tipo) {
                    case 'codigo':
                        return codigo.includes(valor);
                    case 'nombre':
                        return nombre.includes(valor);
                    case 'tipo':
                        return tipoEl.includes(valor);
                    case 'estado':
                        return estado.includes(valor);
                    default:
                        return true; // Si no se selecciona nada, no filtra
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