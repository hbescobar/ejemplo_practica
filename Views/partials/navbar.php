<!-- ==========================================================
     Archivo: Navbar
     Descripcion: Barra de navegación principal del sistema
     Estilo: Bootstrap 5 + Boxicons + Verde elegante
=========================================================== -->

<!-- ===================== NAVBAR INICIO ===================== -->
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm w-100" style="background-color: #2a8c4a;">
  <div class="container-fluid px-4">

    <!-- Logo -->
    <a class="navbar-brand fw-bold fs-5 text-white d-flex align-items-center" href="index.php?modulo=dashboard&controlador=dashboard&funcion=index">
      <i class='bx bx-package me-2 fs-4'></i> Inventix
    </a>

    <!-- Boton para menu responsive -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- ===================== CONTENIDO DEL NAV ===================== -->
    <div class="collapse navbar-collapse" id="navbarMain">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-lg-center">

        <!-- ======== Módulo: Elementos ======== -->
        <li class="nav-item dropdown mx-lg-2">
          <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center" href="#" data-bs-toggle="dropdown">
            <i class='bx bx-cube me-1 fs-5 text-white'></i> Elementos
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?= getUrl('elementos', 'elementos', 'getInsert'); ?>">Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('elementos', 'elementos', 'consult'); ?>">Consultar</a></li>
          </ul>
        </li>

        <!-- ======== Módulo: Préstamos ======== -->
        <li class="nav-item dropdown mx-lg-2">
          <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center" href="#" data-bs-toggle="dropdown">
            <i class='bx bx-transfer me-1 fs-5 text-white'></i> Préstamos
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?= getUrl('prestamos', 'prestamos', 'getInsert'); ?>">Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('prestamos', 'prestamos', 'consult'); ?>">Consultar</a></li>
          </ul>
        </li>

        <!-- ======== Módulo: Reservas ======== -->
        <li class="nav-item dropdown mx-lg-2">
          <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center" href="#" data-bs-toggle="dropdown">
            <i class='bx bx-calendar me-1 fs-5 text-white'></i> Reservas
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?= getUrl('reservas', 'reservas', 'getInsert'); ?>">Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('reservas', 'reservas', 'consult'); ?>">Consultar</a></li>
          </ul>
        </li>

        <!-- ======== Módulo: Usuarios ======== -->
        <li class="nav-item dropdown mx-lg-2">
          <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center" href="#" data-bs-toggle="dropdown">
            <i class='bx bx-user me-1 fs-5 text-white'></i> Usuarios
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?= getUrl('usuarios', 'usuarios', 'getInsert'); ?>">Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('usuarios', 'usuarios', 'consult'); ?>">Consultar</a></li>
          </ul>
        </li>

        <!-- ======== Módulo: Reportes ======== -->
        <li class="nav-item dropdown mx-lg-2">
          <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center" href="#" data-bs-toggle="dropdown">
            <i class='bx bx-bar-chart-alt-2 me-1 fs-5 text-white'></i> Reportes
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?= getUrl('reportes', 'reportes', 'verElementos'); ?>"><i class='bx bx-error-alt me-2 text-danger'></i> Monitoreo de Elementos</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('reportes', 'reportes', 'verElementosMasPrestados'); ?>"><i class='bx bx-transfer-alt text-info me-2'></i> Elementos más prestados</a></li>
          </ul>
        </li>

        <!-- ======== Módulo: Configuración ======== -->
        <li class="nav-item dropdown mx-lg-3">
          <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center" href="#" data-bs-toggle="dropdown">
            <i class='bx bx-cog me-1 fs-5 text-white'></i> Configuración
          </a>
          <ul class="dropdown-menu">

            <!-- Subcategorías organizadas -->
            <li><a class="dropdown-item" href="<?= getUrl('marca', 'marca', 'getInsert'); ?>"><i class='bx bx-award me-2 text-warning'></i> Marca - Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('marca', 'marca', 'consult'); ?>">Consultar Marca</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li><a class="dropdown-item" href="<?= getUrl('areasDestino', 'areasDestino', 'getInsert'); ?>"><i class='bx bx-edit me-2 text-warning'></i> Área de Destino - Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('areasDestino', 'areasDestino', 'consult'); ?>">Consultar Área de Destino</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li><a class="dropdown-item" href="<?= getUrl('categoria', 'categoria', 'getInsert'); ?>"><i class='bx bx-purchase-tag-alt me-2 text-info'></i> Categoría - Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('categoria', 'categoria', 'consult'); ?>">Consultar Categoría</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li><a class="dropdown-item" href="<?= getUrl('rol', 'rol', 'getInsert'); ?>"><i class='bx bx-id-card me-2 text-primary'></i> Rol - Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('rol', 'rol', 'consult'); ?>">Consultar Rol</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li><a class="dropdown-item" href="<?= getUrl('tipoDocumento', 'tipoDocumento', 'getInsert'); ?>"><i class='bx bx-file me-2 text-success'></i> Tipo Documento - Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('tipoDocumento', 'tipoDocumento', 'consult'); ?>">Consultar</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li><a class="dropdown-item" href="<?= getUrl('areas', 'areas', 'getInsert'); ?>"><i class='bx bx-buildings me-2 text-danger'></i> Área - Registrar</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('areas', 'areas', 'consult'); ?>">Consultar Área</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li><a class="dropdown-item" href="<?= getUrl('carga', 'carga', 'createUsuarios'); ?>"><i class='bx bx-upload me-2 text-danger'></i> Cargar Usuarios</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('carga', 'carga', 'createElements'); ?>"><i class='bx bx-upload me-2 text-danger'></i> Cargar Elementos</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('carga', 'carga', 'consult'); ?>"><i class='bx bx-error-circle me-2 text-warning'></i> Control de Errores</a></li>
            <li><a class="dropdown-item" href="<?= getUrl('prestamos', 'prestamos', 'consultarMovimientos'); ?>"><i class='bx bx-transfer-alt me-2 text-success'></i> Movimientos</a></li>
          </ul>
        </li>
      </ul>

      <!-- ===================== LADO DERECHO (Usuario + Notificaciones) ===================== -->
      <div class="d-flex align-items-center ms-auto">
        <!-- Usuario -->
        <div class="d-flex align-items-center text-white">
          <span class="me-2 fw-semibold text-truncate" style="max-width: 180px;" title="<?= htmlspecialchars($_SESSION['usuario']['usu_nombre'] . ' ' . $_SESSION['usuario']['usu_apellido']) ?>">
            <?= htmlspecialchars($_SESSION['usuario']['usu_nombre'] . ' ' . $_SESSION['usuario']['usu_apellido']) ?>
          </span>
          <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" style="font-size: 1.6rem;">
              <i class='bx bx-user-circle'></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="index.php?modulo=login&controlador=login&funcion=logout"><i class='bx bx-log-out-circle me-2'></i> Cerrar sesión</a></li>
            </ul>
          </div>
        </div>
      </div>

    </div> <!-- Fin navbar-collapse -->
  </div> <!-- Fin container-fluid -->


  </div>
</nav>

<style>
  /* ================ ESTILOS PERSONALIZADOS: MODAL DE NOTIFICACIONES ================ */

  /* ===== CONTENEDOR DEL MODAL ===== */
  #modalNotificaciones .modal-dialog {
    position: fixed;
    top: 0;
    right: 0;
    height: 100vh;
    max-width: 400px;
    margin: 0 !important;
    animation: slideInRight 0.4s ease forwards;
    border-left: 1px solid rgba(0, 0, 0, 0.1);
  }

  /* ===== CONTENIDO DEL MODAL ===== */
  #modalNotificaciones .modal-content {
    height: 100%;
    border-radius: 1rem 0 0 1rem;
    overflow: hidden;

    background-color: rgba(255, 255, 255, 0.85);
    /* efecto glass */
    backdrop-filter: blur(8px);

    box-shadow: -4px 0 20px rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(13, 110, 253, 0.15);
    transition: all 0.3s ease-in-out;
  }

  /* ===== CABECERA ===== */
  #modalNotificaciones .modal-header {
    padding: 1rem 1.25rem;
    background-color: transparent;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
  }

  /* ===== CUERPO DEL MODAL (LISTA DE NOTIFICACIONES) ===== */
  #modalNotificaciones .modal-body {
    padding: 1rem;
    overflow-y: auto;
  }

  /* ===== SCROLL PERSONALIZADO ===== */
  #modalNotificaciones .modal-body::-webkit-scrollbar {
    width: 6px;
  }

  #modalNotificaciones .modal-body::-webkit-scrollbar-thumb {
    background-color: #2a8c4a;
    border-radius: 4px;
  }

  /* ===== NOTIFICACIONES INDIVIDUALES ===== */
  #modalNotificaciones .modal-body>div {
    padding: 1rem;
    border-radius: 0.5rem;
    transition: all 0.2s ease-in-out;
  }

  #modalNotificaciones .modal-body>div:hover {
    background-color: rgba(13, 110, 253, 0.07);
    transform: translateX(4px);
  }

  /* ===== ANIMACIÓN DE ENTRADA ===== */
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