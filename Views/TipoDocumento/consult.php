<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-body">
            <h4 class="fw-bold text-primary text-center mb-4">
                <i class='bx bx-id-card'></i> Listado de Tipos de Documento
            </h4>

            <!-- Filtro y búsqueda -->
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                <div class="input-group" style="max-width: 220px;">
                    <label class="input-group-text bg-primary text-white" for="filtroTipo">
                        <i class='bx bx-filter-alt'></i>
                    </label>
                    <select id="filtroTipo" class="form-select">
                        <option value="id">Por ID</option>
                        <option value="nombre">Por Nombre</option>
                    </select>
                </div>

                <div class="input-group" style="max-width: 300px;">
                    <span class="input-group-text bg-primary text-white">
                        <i class='bx bx-search'></i>
                    </span>
                    <input type="search" id="buscadorTipoDoc" class="form-control" placeholder="Buscar..." aria-label="Buscar">
                </div>

                <a href="<?= getUrl('tipoDocumento', 'tipoDocumento', 'getInsert'); ?>" class="btn btn-success">
                    <i class='bx bx-plus-circle'></i> Registrar Nuevo Tipo de Documento
                </a>
            </div>

            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center" id="tablaTipoDoc">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre del Tipo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tipo)) : ?>
                            <?php foreach ($tipo as $tip) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($tip['tipo_docu_id']) ?></td>
                                    <td><?= htmlspecialchars($tip['tipo_docu_nombre']) ?></td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="<?= getUrl('tipoDocumento', 'tipoDocumento', 'getEdit', ['id' => $tip['tipo_docu_id']]); ?>" class="btn btn-sm btn-warning" title="Editar">
                                                <i class='bx bx-edit-alt'></i>
                                            </a>
                                            <a href="<?= getUrl('tipoDocumento', 'tipoDocumento', 'delete', ['id' => $tip['tipo_docu_id']]); ?>" class="btn btn-sm btn-danger" title="Eliminar"
                                                onclick="return confirm('¿Seguro que quieres eliminar este tipo de documento?');">
                                                <i class='bx bx-trash'></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="3" class="text-center">No hay tipos de documento registrados.</td>
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
        const inputBusqueda = document.getElementById('buscadorTipoDoc');
        const filtroTipo = document.getElementById('filtroTipo');
        const tabla = document.getElementById('tablaTipoDoc').getElementsByTagName('tbody')[0];
        const paginacion = document.getElementById('paginacionTabla');
        const filas = Array.from(tabla.rows);
        const filasPorPagina = 6;
        let paginaActual = 1;

        const renderTabla = () => {
            const valor = inputBusqueda.value.toLowerCase().trim();
            const tipo = filtroTipo.value;

            const filtradas = filas.filter(fila => {
                const celdas = fila.cells;
                const [id, nombre] = [
                    celdas[0].textContent.toLowerCase(),
                    celdas[1].textContent.toLowerCase()
                ];

                switch (tipo) {
                    case 'id':
                        return id.includes(valor);
                    case 'nombre':
                        return nombre.includes(valor);
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