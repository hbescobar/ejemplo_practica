<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-body">
            <h4 class="fw-bold text-primary text-center mb-4">
                <i class="bx bx-transfer-alt"></i> Elementos Más Prestados
            </h4>

            <!-- Filtro y búsqueda -->
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                <!-- selector -->
                <div class="input-group" style="max-width: 260px;">
                    <label class="input-group-text bg-primary text-white" for="filtroPrestados">
                        <i class='bx bx-filter-alt'></i>
                    </label>
                    <select id="filtroPrestados" class="form-select">
                        <option value="codigo">Por Código</option>
                        <option value="nombre">Por Nombre</option>
                        <option value="usuario">Por Usuario</option>
                        <option value="fecha">Por Última fecha</option>
                    </select>
                </div>

                <!-- buscador -->
                <div class="input-group" style="max-width: 320px;">
                    <span class="input-group-text bg-primary text-white">
                        <i class='bx bx-search'></i>
                    </span>
                    <input type="search" id="buscadorPrestados" class="form-control"
                           placeholder="Buscar..." aria-label="Buscar">
                </div>

                <button onclick="window.print()" class="btn btn-outline-dark btn-sm">
                    <i class="bx bx-printer"></i> Imprimir
                </button>
            </div>

            <!-- Tabla -->
            <div class="table-responsive rounded-3 overflow-hidden">
                <table class="table table-bordered table-hover align-middle text-center mb-0" id="tablaPrestados">
                    <thead class="table-dark">
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Veces Prestado</th>
                            <th>Última Fecha</th>
                            <th>Usuario más Frecuente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($elementos && mysqli_num_rows($elementos) > 0): ?>
                            <?php while ($e = mysqli_fetch_assoc($elementos)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($e['elem_codigo']); ?></td>
                                    <td><?= htmlspecialchars($e['elem_nombre']); ?></td>
                                    <td><?= $e['veces_prestado']; ?></td>
                                    <td><?= date('d/m/Y', strtotime($e['ultima_fecha'])); ?></td>
                                    <td><?= htmlspecialchars($e['usuario_mas_frecuente']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5">No hay datos de préstamos.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="d-flex justify-content-center mt-4">
                <nav><ul class="pagination" id="paginacionPrestados"></ul></nav>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const inputBusqueda = document.getElementById('buscadorPrestados');
    const filtroTipo    = document.getElementById('filtroPrestados');
    const tablaBody     = document.querySelector('#tablaPrestados tbody');
    const paginacion    = document.getElementById('paginacionPrestados');

    const filas          = Array.from(tablaBody.rows);
    const filasPorPagina = 8;     // ← cambia si quieres más/menos filas
    let paginaActual     = 1;

    const renderTabla = () => {
        const valor = inputBusqueda.value.toLowerCase().trim();
        const tipo  = filtroTipo.value;

        // índices: 0 código, 1 nombre, 3 fecha, 4 usuario
        const filtradas = filas.filter(fila => {
            const [codigo, nombre, , fecha, usuario] = Array.from(fila.cells).map(c =>
                c.textContent.toLowerCase());

            switch (tipo) {
                case 'codigo':  return codigo.includes(valor);
                case 'nombre':  return nombre.includes(valor);
                case 'usuario': return usuario.includes(valor);
                case 'fecha':   return fecha.includes(valor);
                default:        return true;
            }
        });

        const totalPaginas = Math.ceil(filtradas.length / filasPorPagina);
        const inicio       = (paginaActual - 1) * filasPorPagina;
        const fin          = inicio + filasPorPagina;

        filas.forEach(f => f.style.display = 'none');
        filtradas.slice(inicio, fin).forEach(f => f.style.display = '');

        renderPaginacion(totalPaginas);
    };

    const renderPaginacion = totalPaginas => {
        paginacion.innerHTML = '';
        if (totalPaginas <= 1) return;

        const crearItem = (html, pagina, disabled = false, active = false) => {
            const li = document.createElement('li');
            li.className = `page-item${disabled ? ' disabled' : ''}${active ? ' active' : ''}`;
            li.innerHTML = `<a href="#" class="page-link">${html}</a>`;
            li.onclick = e => {
                e.preventDefault();
                if (!disabled && pagina !== paginaActual) {
                    paginaActual = pagina;
                    renderTabla();
                }
            };
            return li;
        };

        paginacion.appendChild(crearItem('&laquo;', paginaActual - 1, paginaActual === 1));
        for (let i = 1; i <= totalPaginas; i++)
            paginacion.appendChild(crearItem(i, i, false, paginaActual === i));
        paginacion.appendChild(crearItem('&raquo;', paginaActual + 1, paginaActual === totalPaginas));
    };

    inputBusqueda.addEventListener('input',  () => { paginaActual = 1; renderTabla(); });
    filtroTipo  .addEventListener('change', () => { paginaActual = 1; renderTabla(); });

    renderTabla();   // inicial
});
</script>

