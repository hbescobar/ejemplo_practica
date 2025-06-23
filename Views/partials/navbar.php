<!-- NAVBAR INICIO -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm w-100">
  <div class="container-fluid px-4">

    <!-- Logo -->
    <a class="navbar-brand fw-bold fs-3 text-primary d-flex align-items-center" href="/Inventario/">
      <i class='bx bx-package me-2 fs-2'></i> InvenSys
    </a>

    <!-- Botón mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Contenido -->
    <div class="collapse navbar-collapse" id="navbarMain">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-lg-center">

        <!-- Elementos -->
        <li class="nav-item dropdown mx-lg-2">
          <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center" href="#" id="elementosDropdown" role="button" data-bs-toggle="dropdown">
            <i class='bx bx-cube me-1 fs-5 text-primary'></i> Elementos
          </a>
          <ul class="dropdown-menu" aria-labelledby="elementosDropdown">
            <li><a class="dropdown-item" href="<?= getUrl('elementos', 'elementos', 'getInsert'); ?>">Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('elementos', 'elementos', 'consult'); ?>">Consultar</a></li>
          </ul>
        </li>

        <!-- Préstamos -->
        <li class="nav-item dropdown mx-lg-2">
          <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center" href="#" id="prestamosDropdown" role="button" data-bs-toggle="dropdown">
            <i class='bx bx-transfer me-1 fs-5 text-primary'></i> Préstamos
          </a>
          <ul class="dropdown-menu" aria-labelledby="prestamosDropdown">
            <li><a class="dropdown-item" href="<?= getUrl('prestamos', 'prestamos', 'getInsert'); ?>">Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('prestamos', 'prestamos', 'consult'); ?>">Consultar</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown mx-lg-2">
          <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center" href="#" id="reservasDropdown" role="button" data-bs-toggle="dropdown">
            <i class='bx bx-calendar me-1 fs-5 text-success'></i> Reservas
          </a>
          <ul class="dropdown-menu" aria-labelledby="reservasDropdown">
            <li><a class="dropdown-item" href="<?= getUrl('reservas', 'reservas', 'getInsert'); ?>">Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('reservas', 'reservas', 'consult'); ?>">Consultar</a></li>
          </ul>
        </li>

        <!-- Usuarios -->
        <li class="nav-item dropdown mx-lg-2">
          <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center" href="#" id="usuariosDropdown" role="button" data-bs-toggle="dropdown">
            <i class='bx bx-user me-1 fs-5 text-primary'></i> Usuarios
          </a>
          <ul class="dropdown-menu" aria-labelledby="usuariosDropdown">
            <li><a class="dropdown-item" href="<?= getUrl('usuarios', 'usuarios', 'getInsert'); ?>">Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('usuarios', 'usuarios', 'consult'); ?>">Consultar</a></li>
          </ul>
          <!-- Reportes -->
          <li class="nav-item dropdown mx-lg-2">
            <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center" href="#" id="reportesDropdown" role="button" data-bs-toggle="dropdown">
              <i class='bx bx-bar-chart-alt me-1 fs-5 text-primary'></i> Reportes
            </a>
            <ul class="dropdown-menu" aria-labelledby="reportesDropdown">
              <li><a class="dropdown-item" href="<?= getUrl('reportes', 'reportes', 'generar'); ?>">Generar Reporte</a></li>
              <li><a class="dropdown-item" href="<?= getUrl('reportes', 'reportes', 'consultar'); ?>">Consultar Reportes</a></li>
            </ul>
          </li>
        </li>

        <!-- Configuración -->
        <li class="nav-item dropdown mx-lg-3">
          <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center" href="#" id="configDropdown" role="button" data-bs-toggle="dropdown">
            <i class='bx bx-cog me-1 fs-5'></i> Configuración
          </a>
          <ul class="dropdown-menu" aria-labelledby="configDropdown">

            <li><a class="dropdown-item" href="<?= getUrl('marca', 'marca', 'getInsert'); ?>"><i class='bx bx-award me-2 text-warning'></i>Marca - Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('marca', 'marca', 'consult'); ?>">Consultar Marca</a></li>
            <li><hr class="dropdown-divider"></li>

            <li><a class="dropdown-item" href="<?= getUrl('areasDestino', 'areasDestino', 'getInsert'); ?>"><i class='bx bx-edit me-2 text-warning'></i>Área de Destino - Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('areasDestino', 'areasDestino', 'consult'); ?>">Consultar Área de Destino</a></li>
            <li><hr class="dropdown-divider"></li>

            <li><a class="dropdown-item" href="<?= getUrl('categoria', 'categoria', 'getInsert'); ?>"><i class='bx bx-purchase-tag-alt me-2 text-info'></i>Categoría - Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('categoria', 'categoria', 'consult'); ?>">Consultar Categoría</a></li>
            <li><hr class="dropdown-divider"></li>

            <li><a class="dropdown-item" href="<?= getUrl('rol', 'rol', 'getInsert'); ?>"><i class='bx bx-id-card me-2 text-primary'></i>Rol - Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('rol', 'rol', 'consult'); ?>">Consultar Rol</a></li>
            <li><hr class="dropdown-divider"></li>

            <li><a class="dropdown-item" href="<?= getUrl('tipoDocumento', 'tipoDocumento', 'getInsert'); ?>"><i class='bx bx-file me-2 text-success'></i>Tipo Documento - Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('tipoDocumento', 'tipoDocumento', 'consult'); ?>">Consultar</a></li>
            <li><hr class="dropdown-divider"></li>

            <li><a class="dropdown-item" href="<?= getUrl('areas', 'areas', 'getInsert'); ?>"><i class='bx bx-buildings me-2 text-danger'></i>Área - Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('areas', 'areas', 'consult'); ?>">Consultar Área</a></li>
            <li><hr class="dropdown-divider"></li>

            <li><a class="dropdown-item" href="<?= getUrl('carga', 'carga', 'createUsuarios'); ?>"><i class='bx bx-upload me-2 text-danger'></i>Cargar Usuarios</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('carga', 'carga', 'createElements'); ?>"><i class='bx bx-upload me-2 text-danger'></i>Cargar Elementos</a></li>

            <li>
            <a class="dropdown-item" href="<?= getUrl('carga', 'carga', 'consult'); ?>">
              <i class='bx bx-error-circle me-2 text-warning'></i>Control de Errores
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="<?= getUrl('prestamos', 'prestamos', 'consultarMovimientos'); ?>">
              <i class='bx bx-transfer-alt me-2 text-success'></i>Movimientos
            </a>
          </li>
          </ul>
        </li>
      </ul>

      <!-- Perfil usuario -->
      <div class="d-flex align-items-center text-dark">
        <span class="me-3 fw-semibold text-truncate" style="max-width: 180px;" title="<?= htmlspecialchars($_SESSION['usuario']['usu_nombre'] . ' ' . $_SESSION['usuario']['usu_apellido']) ?>">
          <?= htmlspecialchars($_SESSION['usuario']['usu_nombre'] . ' ' . $_SESSION['usuario']['usu_apellido']) ?>
        </span>

        <div class="dropdown">
          <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" style="font-size: 1.8rem;">
            <i class='bx bx-user-circle'></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
            <li>
              <a class="dropdown-item" href="index.php?modulo=login&controlador=login&funcion=logout">
                <i class='bx bx-log-out-circle me-2'></i> Cerrar sesión
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</nav>
<!-- NAVBAR FIN -->

<!-- ESTILOS ADICIONALES -->
<style>
  .nav-link:hover,
  .dropdown-item:hover {
    background-color: #f0f8ff !important;
    color: #0d6efd !important;
  }

  .text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  @media (max-width: 992px) {
    .dropdown-menu {
      width: 100% !important;
      min-width: unset !important;
    }
  }
</style>
