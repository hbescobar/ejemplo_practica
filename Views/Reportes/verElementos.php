<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-body">
            <h4 class="fw-bold text-primary text-center mb-4">
                <i class='bx bx-bar-chart-alt-2'></i> Monitoreo de Stock de Elementos
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
                        <option value="categoria">Por Categoría</option>
                    </select>
                </div>

                <div class="input-group" style="max-width: 300px;">
                    <span class="input-group-text bg-primary text-white">
                        <i class='bx bx-search'></i>
                    </span>
                    <input type="search" id="buscadorElementos" class="form-control" placeholder="Buscar..." aria-label="Buscar">
                </div>

                <button onclick="window.print()" class="btn btn-outline-dark">
                    <i class="bx bx-printer"></i> Imprimir
                </button>
            </div>

            <!-- Tabla -->
            <div class="table-responsive rounded-3 overflow-hidden">
                <table class="table table-bordered table-hover align-middle text-center mb-0" id="tablaElementos">
                    <thead class="table-dark">
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Categoría</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($elementos && mysqli_num_rows($elementos) > 0): ?>
                            <?php while ($elemento = mysqli_fetch_assoc($elementos)): ?>
                                <tr 
                                    class="<?= ($elemento['elem_telem_id'] == 2 && $elemento['elem_cantidad'] < 5) ? 'table-danger fw-bold' : ''; ?>"
                                    title="<?= ($elemento['elem_telem_id'] == 2 && $elemento['elem_cantidad'] < 5) ? '¡Advertencia! Elemento por agotarse' : ''; ?>">
                                    <td><?= $elemento['elem_codigo']; ?></td>
                                    <td><?= $elemento['elem_nombre']; ?></td>
                                    <td><?= $elemento['telem_nombre']; ?></td>
                                    <td><?= $elemento['cate_nombre']; ?></td>
                                    
                                    <td class="<?= ($elemento['elem_telem_id'] == 2 && $elemento['elem_cantidad'] < 5) ? 'text-danger fw-bold' : ''; ?>">
                                        <?= $elemento['elem_cantidad']; ?>
                                        <?php if ($elemento['elem_telem_id'] == 2 && $elemento['elem_cantidad'] < 5): ?>
                                            <i class='bx bxs-error-circle ms-1' style='color: red;' title='¡Baja existencia!'></i>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-danger">No se encontraron elementos.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>  
                </table>
            </div>

            <!-- MENSAJE DE ADVERTENCIA -->
            <div class="alert alert-warning py-2 px-3 small mt-3 text-center mx-auto" style="max-width: 500px;">
                <i class="bx bx-info-circle text-warning"></i>
                Los elementos <strong>No Devolutivos</strong> con <strong>cantidad menor a 5</strong> aparecerán en <span class="text-danger fw-semibold">rojo</span> como advertencia de bajo inventario.
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

<script>
document.addEventListener('DOMContentLoaded', () => {
    const inputBusqueda = document.getElementById('buscadorElementos');
    const filtroTipo = document.getElementById('filtroTipo');
    const tabla = document.getElementById('tablaElementos').getElementsByTagName('tbody')[0];
    const paginacion = document.getElementById('paginacionTabla');
    const filas = Array.from(tabla.rows);
    const filasPorPagina = 6;
    let paginaActual = 1;

    const renderTabla = () => {
        const valor = inputBusqueda.value.toLowerCase().trim();
        const tipo = filtroTipo.value;

        const filtradas = filas.filter(fila => {
            const celdas = fila.cells;
            const [codigo, nombre, tipoElem, categoria] = [
                celdas[0].textContent.toLowerCase(),
                celdas[1].textContent.toLowerCase(),
                celdas[3].textContent.toLowerCase(),
            ];

            switch (tipo) {
                case 'codigo':
                    return codigo.includes(valor);
                case 'nombre':
                    return nombre.includes(valor);
                case 'tipo':
                    return tipoElem.includes(valor);
                case 'categoria':
                    return categoria.includes(valor);
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