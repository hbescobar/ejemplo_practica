<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-body">
            <h4 class="fw-bold text-primary text-center mb-4">
                <i class='bx bx-user'></i> Listado de reservas
            </h4>

            <!-- Filtro y búsqueda -->
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                <div class="input-group" style="max-width: 220px;">
                    <label class="input-group-text bg-primary text-white" for="filtroTipo">
                        <i class='bx bx-filter-alt'></i>
                    </label>
                    <select id="filtroTipo" class="form-select">
                        <option value="id">Por ID</option>
                        <option value="nombre">Por Nombre solicitante </option>
                        <option value="fecha">Fecha de solicitud</option>
                        <option value="estado">Por Estado</option>
                    </select>
                </div>

                <div class="input-group" style="max-width: 300px;">
                    <span class="input-group-text bg-primary text-white">
                        <i class='bx bx-search'></i>
                    </span>
                    <input type="search" id="buscadorPrestamos" class="form-control" placeholder="Buscar..." aria-label="Buscar">
                </div>

            </div>

            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center" id="tablaPrestamos">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre solicitante</th>
                            <th>Fecha de solicitud</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($prestamos)) : ?>
                            <?php foreach ($prestamos as $prestamos) : ?>
                                <tr>
                                    <td><?= $prestamos['reserva_id']; ?></td>
                                    <td><?= $prestamos['usu_nombre'] . ' ' . $prestamos['usu_apellido']; ?></td>
                                    <td><?= $prestamos['reserva_fecha_solicitud']; ?></td>
                                    
                                    <td>
                                        <?php if ($prestamos['reserva_estado_id'] == 1) : ?>
                                            <span class="btn btn-sm btn-success disabled" style="pointer-events: none;">
                                                Activo
                                            </span>
                                        <?php elseif ($prestamos['reserva_estado_id'] == 2) : ?>
                                            <span class="btn btn-sm btn-warning disabled" style="pointer-events: none;">
                                                Prestamo creado
                                            </span>
                                        <?php elseif ($prestamos['reserva_estado_id'] == 3) : ?>
                                            <span class="btn btn-sm btn-danger disabled" style="pointer-events: none;">
                                                Cancelada
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <?php if ($prestamos['reserva_estado_id'] == 1): // 1 = Activo ?>
                                            <a href="<?= getUrl('reservas', 'reservas', 'modificar', ['id' => $prestamos['reserva_id']]); ?>" class="btn btn-sm btn-warning" title="Editar">
                                                <i class='bx bx-edit-alt'></i>
                                            </a>
                                            <a href="<?= getUrl('reservas', 'reservas', 'devolver', ['id' => $prestamos['reserva_id']]); ?>" class="btn btn-sm btn-danger" title="Cancelar" onclick="return confirm('¿Está seguro de finalizar este préstamo?');">
                                                <i class='bx bx-check-circle'></i> 
                                            </a>
                                            <a href="<?= getUrl('reservas', 'reservas', 'crearPrestamo', ['id' => $prestamos['reserva_id']]); ?>" class="btn btn-sm btn-sucess" title="Crear prestamo" onclick="return confirm('¿Está seguro de finalizar este préstamo?');">
                                                <i class='bx bx-check-circle'></i> 
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?= getUrl('reservas', 'reservas', 'detalle', ['id' => $prestamos['reserva_id']]); ?>" class="btn btn-sm btn-info" title="Ver Detalle">
                                            <i class='bx bx-show'></i>
                                        </a>
                                    </div>
                                </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="8" class="text-center">No hay prestamoss registrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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

<!-- JS búsqueda + paginación -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const inputBusqueda = document.getElementById('buscadorPrestamos');
        const filtroTipo = document.getElementById('filtroTipo');
        const tabla = document.getElementById('tablaPrestamos').getElementsByTagName('tbody')[0];
        const paginacion = document.getElementById('paginacionTabla');
        const filas = Array.from(tabla.rows);
        const filasPorPagina = 6;
        let paginaActual = 1;

        const renderTabla = () => {
            const valor = inputBusqueda.value.toLowerCase().trim();
            const tipo = filtroTipo.value;

            const filtradas = filas.filter(fila => {
                const celdas = fila.cells;
                const [id, nombre,fecha, estado] = [
                    celdas[0].textContent.toLowerCase(),
                    celdas[1].textContent.toLowerCase(),
                    celdas[2].textContent.toLowerCase(),
                    celdas[3].textContent.toLowerCase()
                   
                ];

                switch (tipo) {
                    case 'id':
                        return id.includes(valor);
                    case 'nombre':
                        return nombre.includes(valor);
                    case 'fecha':
                        return fecha.includes(valor);
                    case 'estado':
                        return estado.includes(valor);
                    default:
                        return true;
                }
            });

            const totalPaginas = Math.ceil(filtradas.length / filasPorPagina);
            const inicio = (paginaActual - 1) * filasPorPagina;
            const fin = inicio + filasPorPagina;

            filas.forEach(fila => fila.style.display = 'none');
            filtradas.slice(inicio, fin).forEach(fila => fila.style.display = '');

            renderPaginacion(totalPaginas);
        };

        const renderPaginacion = (totalPaginas) => {
            paginacion.innerHTML = '';
            if (totalPaginas <= 1) return;

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
                        renderTabla();
                    }
                };

                li.appendChild(a);
                return li;
            };

            paginacion.appendChild(crearItem('&laquo;', paginaActual - 1, paginaActual === 1));

            for (let i = 1; i <= totalPaginas; i++) {
                paginacion.appendChild(crearItem(i, i, false, paginaActual === i));
            }

            paginacion.appendChild(crearItem('&raquo;', paginaActual + 1, paginaActual === totalPaginas));
        };

        inputBusqueda.addEventListener('input', () => {
            paginaActual = 1;
            renderTabla();
        });

        filtroTipo.addEventListener('change', () => {
            paginaActual = 1;
            renderTabla();
        });

        renderTabla();
    });
</script>