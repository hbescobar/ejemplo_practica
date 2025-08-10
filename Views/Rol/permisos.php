<div class="container my-4">
  <h2 class="text-center text-success mb-4">Asignar Permisos al Rol: <?= htmlspecialchars($rol_nombre) ?></h2>

  <form method="post" action="index.php?modulo=rol&controlador=rol&funcion=guardarPermisos&id=<?= htmlspecialchars($rol_id) ?>">
    <div class="table-responsive">
      <table class="table table-borderless table-hover align-middle text-center">
        <thead class="table-success">
          <tr>
            <th>#</th>
            <th>Módulo</th>
            <?php foreach ($permisos as $permiso): ?>
              <th><?= htmlspecialchars($permiso['nombre_permiso']) ?></th>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody id="tabla-body">
          <?php $contador = 1; ?>
          <?php foreach ($modulos as $modulo): ?>
            <tr>
              <td><?= $contador++ ?></td>
              <td><?= htmlspecialchars($modulo['modulo_nombre']) ?></td>
              <?php foreach ($permisos as $permiso):
                $permiso_id = $permiso['id_permisos'];
                $modulo_id = $modulo['modulo_id'];
                $clave = $modulo_id . '_' . $permiso_id;
                $asignado = isset($rolPermisos[$clave]) && $rolPermisos[$clave] == 1;
                $inputId = "perm_{$modulo_id}_{$permiso_id}";
              ?>
                <td>
                  <div class="form-check form-switch d-flex justify-content-center">
                    <input class="form-check-input" type="checkbox"
                      name="permisos[<?= $modulo_id ?>][<?= $permiso_id ?>]"
                      id="<?= $inputId ?>"
                      autocomplete="off"
                      value="1"
                      <?= $asignado ? 'checked' : '' ?>>
                    <label class="form-check-label ms-2" for="<?= $inputId ?>"></label>
                  </div>
                </td>
              <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-center gap-3 mt-4">
      <button type="submit" class="btn btn-success px-4">Guardar Permisos</button>
      <a href="index.php?modulo=rol&controlador=rol&funcion=consult" class="btn btn-outline-success px-4">Cancelar</a>
    </div>
  </form>

  <!-- Contenedor para paginación -->
  <nav aria-label="Paginacion permisos" class="mt-3">
    <ul class="pagination justify-content-center" id="paginacion"></ul>
  </nav>
</div>


<style>
  /* Usamos tu verde principal para encabezados y botones */
  .table-success,
  .table-success>th,
  .table-success>td {
    background-color: #2a8c4a !important;
    color: white !important;
  }

  /* Hover con verde clarito */
  .table-hover tbody tr:hover {
    background-color: #d0fdd7 !important;
  }

  /* Botones */
  .btn-success {
    background-color: #2a8c4a;
    border-color: #2a8c4a;
  }

  .btn-success:hover,
  .btn-success:focus {
    background-color: #64c27b;
    border-color: #64c27b;
    color: #fff;
  }

  .btn-outline-success {
    color: #2a8c4a;
    border-color: #9bfab0;
  }

  .btn-outline-success:hover {
    background-color: #d0fdd7;
    color: #2a8c4a;
  }

  /* Form switch - checkboxes personalizados */
  .form-check-input:checked {
    background-color: #2a8c4a;
    border-color: #2a8c4a;
  }

  /* Fondo scroll tabla con sombra suave */
  .table-responsive {
    box-shadow: 0 0 10px rgba(42, 140, 74, 0.2);
    border-radius: 10px;
  }

  /* Mantener el max height para que no explote */
  .table-responsive {
    max-height: 500px;
  }

  /* Paginacion */
  .pagination .page-link {
    color: #2a8c4a;
    border: 1px solid #2a8c4a;
    transition: background-color 0.3s, color 0.3s;
  }

  .pagination .page-link:hover {
    background-color: #2a8c4a;
    color: #fff;
  }

  .pagination .page-item.active .page-link {
    background-color: #2a8c4a;
    border-color: #2a8c4a;
    color: #fff;
  }

  @media (max-width: 768px) {
    .table-responsive {
      max-height: 300px;
    }
  }
</style>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    const filasPorPagina = 8; // Ajusta según quieras
    const tablaBody = document.getElementById('tabla-body');
    const filas = Array.from(tablaBody.querySelectorAll('tr'));
    const paginacion = document.getElementById('paginacion');
    const totalPaginas = Math.ceil(filas.length / filasPorPagina);

    function mostrarPagina(numPagina) {
      const inicio = (numPagina - 1) * filasPorPagina;
      const fin = inicio + filasPorPagina;
      filas.forEach((fila, i) => {
        fila.style.display = i >= inicio && i < fin ? '' : 'none';
      });
      actualizarPaginacion(numPagina);
    }

    function actualizarPaginacion(paginaActiva) {
      paginacion.innerHTML = '';

      for (let i = 1; i <= totalPaginas; i++) {
        const li = document.createElement('li');
        li.classList.add('page-item');
        if (i === paginaActiva) li.classList.add('active');

        const a = document.createElement('a');
        a.classList.add('page-link');
        a.href = "#";
        a.textContent = i;
        a.addEventListener('click', function(e) {
          e.preventDefault();
          mostrarPagina(i);
        });

        li.appendChild(a);
        paginacion.appendChild(li);
      }
    }

    if (totalPaginas > 1) {
      mostrarPagina(1);
    }
  });
</script>