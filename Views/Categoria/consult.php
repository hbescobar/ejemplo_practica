<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-body">
            <h4 class="fw-bold text-primary text-center mb-4">
                <i class='bx bx-grid'></i> Listado de Categorías
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
                        <option value="descripcion">Por Descripción</option>
                    </select>
                </div>

                <div class="input-group" style="max-width: 300px;">
                    <span class="input-group-text bg-primary text-white">
                        <i class='bx bx-search'></i>
                    </span>
                    <input type="search" id="buscadorCategorias" class="form-control" placeholder="Buscar..." aria-label="Buscar">
                </div>

                <a href="<?= getUrl('Categoria', 'Categoria', 'getInsert'); ?>" class="btn btn-success">
                    <i class='bx bx-plus-circle'></i> Registrar Nueva Categoría
                </a>
            </div>

            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center" id="tablaCategorias">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($categorias)) : ?>
                            <?php foreach ($categorias as $cate) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($cate['cate_id']) ?></td>
                                    <td><?= htmlspecialchars($cate['cate_nombre']) ?></td>
                                    <td><?= htmlspecialchars($cate['cate_descripcion']) ?></td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="<?= getUrl('Categoria', 'Categoria', 'getEdit', ['id' => $cate['cate_id']]); ?>" class="btn btn-sm btn-warning" title="Editar">
                                                <i class='bx bx-edit-alt'></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-danger btn-eliminar-categoria"
                                                data-url="<?= getUrl('Categoria', 'Categoria', 'delete', ['id' => $cate['cate_id']]); ?>"
                                                title="Eliminar"><i class='bx bx-trash'></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="4" class="text-center">No hay categorías registradas.</td>
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

<!-- SweetAlert para eliminar categoría -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-eliminar-categoria').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('data-url');

                Swal.fire({
                    title: '¿Está seguro de eliminar esta categoría?',
                    text: "Esta acción no se puede deshacer.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    });
</script>
<!-- JS búsqueda + paginación -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const inputBusqueda = document.getElementById('buscadorCategorias');
        const filtroTipo = document.getElementById('filtroTipo');
        const tabla = document.getElementById('tablaCategorias').getElementsByTagName('tbody')[0];
        const paginacion = document.getElementById('paginacionTabla');
        const filas = Array.from(tabla.rows);
        const filasPorPagina = 6;
        let paginaActual = 1;

        const renderTabla = () => {
            const valor = inputBusqueda.value.toLowerCase().trim();
            const tipo = filtroTipo.value;

            const filtradas = filas.filter(fila => {
                const celdas = fila.cells;
                const [id, nombre, descripcion] = [
                    celdas[0].textContent.toLowerCase(),
                    celdas[1].textContent.toLowerCase(),
                    celdas[2].textContent.toLowerCase()
                ];

                switch (tipo) {
                    case 'id':
                        return id.includes(valor);
                    case 'nombre':
                        return nombre.includes(valor);
                    case 'descripcion':
                        return descripcion.includes(valor);
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