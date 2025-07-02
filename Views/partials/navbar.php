<!-- NAVBAR INICIO -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm w-100">
  <div class="container-fluid px-4">

    <!-- Logo reducido -->
    <a class="navbar-brand fw-bold fs-5 text-white d-flex align-items-center" href="index.php?modulo=dashboard&controlador=dashboard&funcion=index">
      <i class='bx bx-package me-2 fs-4'></i> InvenSys
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
            <i class='bx bx-cube me-1 fs-5 text-white'></i> Elementos
          </a>
          <ul class="dropdown-menu" aria-labelledby="elementosDropdown">
            <li><a class="dropdown-item" href="<?= getUrl('elementos', 'elementos', 'getInsert'); ?>">Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('elementos', 'elementos', 'consult'); ?>">Consultar</a></li>
          </ul>
        </li>

        <!-- Préstamos -->
        <li class="nav-item dropdown mx-lg-2">
          <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center" href="#" id="prestamosDropdown" role="button" data-bs-toggle="dropdown">
            <i class='bx bx-transfer me-1 fs-5 text-white'></i> Préstamos
          </a>
          <ul class="dropdown-menu" aria-labelledby="prestamosDropdown">
            <li><a class="dropdown-item" href="<?= getUrl('prestamos', 'prestamos', 'getInsert'); ?>">Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('prestamos', 'prestamos', 'consult'); ?>">Consultar</a></li>
          </ul>
        </li>

        <!-- Reservas -->
        <li class="nav-item dropdown mx-lg-2">
          <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center" href="#" id="reservasDropdown" role="button" data-bs-toggle="dropdown">
            <i class='bx bx-calendar me-1 fs-5 text-white'></i> Reservas
          </a>
          <ul class="dropdown-menu" aria-labelledby="reservasDropdown">
            <li><a class="dropdown-item" href="<?= getUrl('reservas', 'reservas', 'getInsert'); ?>">Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('reservas', 'reservas', 'consult'); ?>">Consultar</a></li>
          </ul>
        </li>

        <!-- Usuarios -->
        <li class="nav-item dropdown mx-lg-2">
          <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center" href="#" id="usuariosDropdown" role="button" data-bs-toggle="dropdown">
            <i class='bx bx-user me-1 fs-5 text-white'></i> Usuarios
          </a>
          <ul class="dropdown-menu" aria-labelledby="usuariosDropdown">
            <li><a class="dropdown-item" href="<?= getUrl('usuarios', 'usuarios', 'getInsert'); ?>">Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('usuarios', 'usuarios', 'consult'); ?>">Consultar</a></li>
          </ul>
        </li>

        <!-- Reportes -->
        <li class="nav-item dropdown mx-lg-2">
          <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center" href="#" id="reportesDropdown" role="button" data-bs-toggle="dropdown">
            <i class='bx bx-bar-chart-alt me-1 fs-5 text-white'></i> Reportes
          </a>
          <ul class="dropdown-menu" aria-labelledby="reportesDropdown">
            <li><a class="dropdown-item" href="<?= getUrl('reportes', 'reportes', 'generar'); ?>">Generar Reporte</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('reportes', 'reportes', 'consultar'); ?>">Consultar Reportes</a></li>
          </ul>
        </li>

        <!-- Configuración -->
        <li class="nav-item dropdown mx-lg-3">
          <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center" href="#" id="configDropdown" role="button" data-bs-toggle="dropdown">
            <i class='bx bx-cog me-1 fs-5 text-white'></i> Configuración
          </a>
          <ul class="dropdown-menu" aria-labelledby="configDropdown">
            <li><a class="dropdown-item" href="<?= getUrl('marca', 'marca', 'getInsert'); ?>"><i class='bx bx-award me-2 text-warning'></i>Marca - Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('marca', 'marca', 'consult'); ?>">Consultar Marca</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li><a class="dropdown-item" href="<?= getUrl('areasDestino', 'areasDestino', 'getInsert'); ?>"><i class='bx bx-edit me-2 text-warning'></i>Área de Destino - Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('areasDestino', 'areasDestino', 'consult'); ?>">Consultar Área de Destino</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li><a class="dropdown-item" href="<?= getUrl('categoria', 'categoria', 'getInsert'); ?>"><i class='bx bx-purchase-tag-alt me-2 text-info'></i>Categoría - Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('categoria', 'categoria', 'consult'); ?>">Consultar Categoría</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li><a class="dropdown-item" href="<?= getUrl('rol', 'rol', 'getInsert'); ?>"><i class='bx bx-id-card me-2 text-primary'></i>Rol - Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('rol', 'rol', 'consult'); ?>">Consultar Rol</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li><a class="dropdown-item" href="<?= getUrl('tipoDocumento', 'tipoDocumento', 'getInsert'); ?>"><i class='bx bx-file me-2 text-success'></i>Tipo Documento - Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('tipoDocumento', 'tipoDocumento', 'consult'); ?>">Consultar</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li><a class="dropdown-item" href="<?= getUrl('areas', 'areas', 'getInsert'); ?>"><i class='bx bx-buildings me-2 text-danger'></i>Área - Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('areas', 'areas', 'consult'); ?>">Consultar Área</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li><a class="dropdown-item" href="<?= getUrl('carga', 'carga', 'createUsuarios'); ?>"><i class='bx bx-upload me-2 text-danger'></i>Cargar Usuarios</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('carga', 'carga', 'createElements'); ?>"><i class='bx bx-upload me-2 text-danger'></i>Cargar Elementos</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('carga', 'carga', 'consult'); ?>"><i class='bx bx-error-circle me-2 text-warning'></i>Control de Errores</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('prestamos', 'prestamos', 'consultarMovimientos'); ?>"><i class='bx bx-transfer-alt me-2 text-success'></i>Movimientos</a></li>
          </ul>
        </li>
      </ul>

      <!-- 🔔 Notificaciones + Usuario -->
      <div class="d-flex align-items-center ms-auto">

        <!-- Botón de notificaciones -->
        <div class="me-4">
          <button class="btn p-0 border-0 bg-transparent" data-bs-toggle="modal" data-bs-target="#modalNotificaciones" title="Notificaciones">
            <div style="position: relative; width: 30px; height: 30px;">
              <i class='bx bx-bell fs-4 text-white'></i>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem; transform: translate(-60%, 20%);">3</span>
            </div>
          </button>
        </div>

        <!-- Usuario -->
        <div class="d-flex align-items-center text-white">
          <span class="me-2 fw-semibold text-truncate" style="max-width: 180px;" title="<?= htmlspecialchars($_SESSION['usuario']['usu_nombre'] . ' ' . $_SESSION['usuario']['usu_apellido']) ?>">
            <?= htmlspecialchars($_SESSION['usuario']['usu_nombre'] . ' ' . $_SESSION['usuario']['usu_apellido']) ?>
          </span>
          <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" style="font-size: 1.6rem;">
              <i class='bx bx-user-circle'></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="index.php?modulo=login&controlador=login&funcion=logout"><i class='bx bx-log-out-circle me-2'></i> Cerrar sesión</a></li>
            </ul>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- MODAL NOTIFICACIONES LATERAL DERECHO -->
  <div class="modal fade" id="modalNotificaciones" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-scrollable" style="margin: 0; max-width: 400px; height: 100vh; position: fixed; top: 0; right: 0;">
      <div class="modal-content h-100 rounded-start shadow-lg border-0 bg-white">

        <!-- Header -->
        <div class="modal-header border-bottom">
          <h5 class="modal-title fw-bold text-primary">Notificaciones</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <!-- Body -->
        <div class="modal-body px-3 py-2 overflow-auto">
          <!-- Notificación 1 -->
          <div class="d-flex align-items-start gap-2 border-bottom py-3">
            <i class='bx bx-cube fs-4 text-warning'></i>
            <div>
              <div><strong>Marcador Azul</strong> está por agotarse.</div>
              <small class="text-muted">Hace 5 minutos</small>
            </div>
          </div>

          <!-- Notificación 2 -->
          <div class="d-flex align-items-start gap-2 border-bottom py-3">
            <i class='bx bx-cube fs-4 text-danger'></i>
            <div>
              <div><strong>Carpetas oficio</strong> quedan pocas unidades.</div>
              <small class="text-muted">Hace 12 minutos</small>
            </div>
          </div>

          <!-- Notificación 3 -->
          <div class="d-flex align-items-start gap-2 py-3">
            <i class='bx bx-cube fs-4 text-info'></i>
            <div>
              <div><strong>Papel reciclado</strong> sin existencias.</div>
              <small class="text-muted">Hace 25 minutos</small>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>


</nav>

<style>
  /* ====== MODAL DE NOTIFICACIONES ESTILIZADO ====== */
  #modalNotificaciones .modal-dialog {
    margin: 0 !important;
    right: 0;
    top: 0;
    height: 100vh;
    position: fixed;
    max-width: 400px;

    /* Animación suave al aparecer */
    animation: slideInRight 0.4s ease forwards;

    /* Bordes definidos */
    border-left: 1px solid rgba(0, 0, 0, 0.1);
    border-top: 1px solid rgba(0, 0, 0, 0.05);
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    border-right: none;
  }

  #modalNotificaciones .modal-content {
    border-radius: 1rem 0 0 1rem;
    height: 100%;
    overflow: hidden;

    /* Color translúcido tipo "glassmorphism" */
    background-color: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(8px);

    /* Sombra elegante */
    box-shadow: -4px 0 20px rgba(0, 0, 0, 0.2);

    /* Borde suave con el color principal */
    border: 1px solid rgba(13, 110, 253, 0.15);

    transition: all 0.3s ease-in-out;
  }

  /* ====== CUERPO DEL MODAL (SCROLLBAR) ====== */
  #modalNotificaciones .modal-body {
    padding: 1rem;
    overflow-y: auto;
  }

  #modalNotificaciones .modal-body::-webkit-scrollbar {
    width: 6px;
  }

  #modalNotificaciones .modal-body::-webkit-scrollbar-thumb {
    background-color: #0d6efd;
    border-radius: 4px;
  }

  /* ====== NOTIFICACIONES INDIVIDUALES ====== */
  #modalNotificaciones .modal-body>div {
    transition: all 0.2s ease-in-out;
    border-radius: 0.5rem;
    padding: 1rem;
  }

  #modalNotificaciones .modal-body>div:hover {
    background-color: rgba(13, 110, 253, 0.07);
    transform: translateX(4px);
  }

  /* ====== CABECERA DEL MODAL ====== */
  #modalNotificaciones .modal-header {
    background-color: transparent;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    padding: 1rem 1.25rem;
  }

  /* ====== ANIMACIÓN DE ENTRADA ====== */
  @keyframes slideInRight {
    from {
      transform: translateX(100%);
      opacity: 0;
    }

    to {
      transform: translateX(0%);
      opacity: 1;
    }
  }
</style>