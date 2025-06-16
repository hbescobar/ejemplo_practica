<div class="table-wrapper" style="max-width: 900px; margin: 40px auto;">

  <h2 class="text-center mb-4">Asignar Permisos al Rol: <?= htmlspecialchars($rol_nombre) ?></h2>

  <form method="post" action="index.php?modulo=rol&controlador=rol&funcion=guardarPermisos&id=<?= htmlspecialchars($rol_id) ?>">
    <table class="table table-striped table-hover text-center align-middle mx-auto" style="width: 100%; max-width: 900px;">
      <thead class="table-primary">
        <tr>
          <th>#</th>
          <th class="text-start">Módulo</th>
          <?php foreach ($permisos as $permiso): ?>
            <th><?= htmlspecialchars($permiso['nombre_permiso']) ?></th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
        <?php $contador = 1; ?>
        <?php foreach ($modulos as $modulo): ?>
          <tr>
            <td><?= $contador++ ?></td>
            <td class="text-start"><?= htmlspecialchars($modulo['modulo_nombre']) ?></td>
            <?php foreach ($permisos as $permiso):
              $permiso_id = $permiso['id_permisos'];
              $modulo_id = $modulo['modulo_id'];
              $clave = $modulo_id . '_' . $permiso_id;
              $asignado = isset($rolPermisos[$clave]) && $rolPermisos[$clave] == 1;
              $inputId = "perm_{$modulo_id}_{$permiso_id}";
            ?>
              <td>
                <input type="checkbox"
                  class="btn-check"
                  name="permisos[<?= $modulo_id ?>][<?= $permiso_id ?>]"
                  id="<?= $inputId ?>"
                  autocomplete="off"
                  value="1"
                  <?= $asignado ? 'checked' : '' ?>>
                <label class="btn btn-outline-primary btn-sm" for="<?= $inputId ?>">
                  <span class="texto-no-asignado">No asignado</span>
                  <span class="texto-asignado">Asignado</span>
                </label>
              </td>
            <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="text-center mt-4">
      <button type="submit" class="btn btn-primary px-5">Guardar Permisos</button>
      <a href="index.php?modulo=rol&controlador=rol&funcion=consult" class="btn btn-secondary px-5 ms-2">Cancelar</a>
    </div>
  </form>
</div>

<style>
  /* Estilos para los botones toggle dentro de la tabla */
  .btn-check:focus+label.btn {
    box-shadow: none !important;
    outline: none !important;
  }

  label.btn {
    cursor: pointer;
    user-select: none;
  }

  label.btn .texto-asignado {
    display: none;
  }

  label.btn .texto-no-asignado {
    display: inline;
  }

  .btn-check:checked+label.btn {
    background-color: #0d6efd;
    color: white;
    border-color: #0d6efd;
  }

  .btn-check:checked+label.btn .texto-asignado {
    display: inline;
  }

  .btn-check:checked+label.btn .texto-no-asignado {
    display: none;
  }
</style>