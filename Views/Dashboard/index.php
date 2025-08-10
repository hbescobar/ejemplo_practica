<!-- =====================================
     Archivo: Dashboard
     Descripcion: Vista principal del sistema con resumen visual
     Estilo: Bootstrap 5 + Boxicons + Verde elegante
====================================== -->

<div class="container my-5">

    <!-- ========== TITULO PRINCIPAL ========== -->
    <!-- <h1 class="text-center mb-4">Panel Principal</h1> -->

    <!-- ========== SECCION DE TARJETAS INFORMATIVAS ========== -->
    <div class="row justify-content-center g-4">

        <!-- Tarjeta: Actividad General -->
        <div class="col-md-6 col-lg-5">
            <div class="card text-center shadow rounded-4">
                <div class="card-body">
                    <i class='bx bx-bar-chart-alt-2 fs-1 text-success mb-3'></i>
                    <h5 class="card-title">Actividad General</h5>
                    <p class="card-text text-muted">Resumen grafico del sistema</p>
                    <div style="height:100px; background:#f8f9fa; border-radius:8px;">(Grafico aqui)</div>
                </div>
            </div>
        </div>

        <!-- Tarjeta: Notificaciones -->
        <div class="col-md-6 col-lg-5">
            <div class="card text-center shadow rounded-4">
                <div class="card-body">
                    <i class='bx bx-bell fs-1 text-warning mb-3'></i>
                    <h5 class="card-title">Notificaciones</h5>
                    <p class="card-text text-muted">Alertas recientes del sistema</p>
                    <div style="height:100px; background:#f8f9fa; border-radius:8px;">(Notis aqui)</div>
                </div>
            </div>
        </div>

        <!-- Tarjeta: Últimos Préstamos -->
        <div class="col-md-6 col-lg-5">
            <div class="card shadow rounded-4 h-100">
                <div class="card-body d-flex flex-column justify-content-start">
                    <div class="d-flex align-items-center mb-3">
                        <i class='bx bx-transfer-alt fs-1 text-info me-2'></i>
                        <div>
                            <h5 class="card-title mb-0">Últimos Préstamos</h5>
                            <small class="text-muted">Historial reciente de préstamos</small>
                        </div>
                    </div>
                    <div id="ultimos-prestamos" class="prestamos-scroll flex-grow-1">Cargando...</div>
                </div>
            </div>
        </div>

        <!-- Tarjeta: últimas Reservas  -->
                <div class="col-md-6 col-lg-5">
                    <div class="card shadow rounded-4 h-100">
                        <div class="card-body d-flex flex-column justify-content-start">
                            <div class="d-flex align-items-center mb-3">
                                <i class='bx bx-transfer-alt fs-1 text-info me-2'></i>
                                <div>
                                    <h5 class="card-title mb-0">Últimas Reservas</h5>
                                    <small class="text-muted">Historial reciente de reservas</small>
                                </div>
                            </div>
                            <div id="ultimos-reservas" class="prestamos-scroll flex-grow-1">Cargando...</div>
                        </div>
                    </div>
                </div>


    </div>

    <!-- ========== BOTON FLOTANTE DE AYUDA ========== -->
    <button id="boton-ayuda" class="btn rounded-circle shadow-lg text-white"
        style="background-color: #2a8c4a; border: none;">
        <i class='bx bx-bot fs-3'></i>
    </button>

    <!-- ========== CHAT FLOTANTE DE AYUDA ========== -->
    <div id="chat-ayuda" class="card shadow-lg">
        <div class="card-header text-white d-flex justify-content-between align-items-center"
            style="background-color: #2a8c4a;">
            <span><i class='bx bx-help-circle me-2'></i>Centro de Ayuda</span>
            <button class="btn-close btn-close-white" aria-label="Cerrar" onclick="toggleChat()"></button>
        </div>
        <div class="card-body p-3 overflow-auto">
            <p class="text-muted small">¿En que te puedo ayudar hoy? Aqui tienes recursos utiles:</p>

            <h6 class="fw-bold mt-3">Manual:</h6>
            <ul class="list-unstyled">
                <li>
                    <a href="manuales/manual_usuario.pdf" download
                        class="btn btn-outline-secondary btn-sm w-100 mb-2 d-flex align-items-center justify-content-start">
                        <i class='bx bx-download me-2'></i> Manual de Usuario
                    </a>
                </li>
            </ul>

            <h6 class="fw-bold mt-3">Tutorial:</h6>
            <ul class="list-unstyled">
                <li>
                    <a href="https://www.youtube.com/watch?v=VIDEO1" target="_blank"
                        class="btn btn-outline-danger btn-sm w-100 mb-2 d-flex align-items-center justify-content-start">
                        <i class='bx bx-play-circle me-2'></i> Como registrar un prestamo
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- ========== ESTILOS PERSONALIZADOS ========== -->
<style>
    #boton-ayuda {
        position: fixed;
        bottom: 20px;
        left: 20px;
        width: 60px;
        height: 60px;
        z-index: 1000;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: transform 0.2s ease;
    }

    #boton-ayuda:hover {
        transform: scale(1.1);
    }

    #chat-ayuda {
        position: fixed;
        bottom: 90px;
        left: 20px;
        width: 320px;
        max-height: 420px;
        z-index: 999;
        display: none;
        border-radius: 1rem;
        overflow: hidden;
        background-color: #fff;
    }

    #chat-ayuda .card-body {
        max-height: 330px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #c1c1c1 #f1f1f1;
    }

    /* Scroll bonito */
    #chat-ayuda .card-body::-webkit-scrollbar {
        width: 6px;
    }

    #chat-ayuda .card-body::-webkit-scrollbar-thumb {
        background-color: #c1c1c1;
        border-radius: 10px;
    }

    #chat-ayuda .card-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    #ultimos-prestamos {
    max-height: 140px;
    overflow-y: auto;
    overflow-x: hidden;
    padding-right: 6px;
    margin-top: 0.5rem;
    font-size: 0.95em;
    scrollbar-width: thin;
    scrollbar-color: #c1c1c1 #f1f1f1;
}

/* Scroll bonito */
#ultimos-prestamos::-webkit-scrollbar {
    width: 6px;
}
#ultimos-prestamos::-webkit-scrollbar-thumb {
    background-color: #c1c1c1;
    border-radius: 10px;
}
#ultimos-prestamos::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.prestamos-lista {
    margin-bottom: 0;
    padding-left: 0.5rem;
}

.prestamos-lista .list-group-item {
    border: none;
    border-bottom: 1px solid #e9ecef;
    padding-top: 0.6rem;
    padding-bottom: 0.6rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    transition: background-color 0.2s ease;
}

.prestamos-lista .list-group-item:hover {
    background-color: #f1fdf4;
}

.prestamos-lista .list-group-item:last-child {
    border-bottom: none;
}



#ultimos-prestamos nav {
    display: none !important;
}
.prestamos-scroll {
    background-color: #ffffffff; /* Verde muy suave */
    border-left: 4px solid #2a8c4a;
    border-radius: 0.5rem;
    padding: 0.5rem;
}

.card-body {
    background: linear-gradient(135deg, #dcebe0ff, #fdfdfdff);
    border-radius: 1rem;
    padding: 1rem 1.25rem;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    transition: background 0.3s ease;
}





</style>

<!-- ========== SCRIPT DE FUNCIONALIDAD DEL CHAT ========== -->
<script>
    const chat = document.getElementById("chat-ayuda");
    const btn = document.getElementById("boton-ayuda");

    btn.addEventListener("click", () => {
        chat.style.display = chat.style.display === "none" || chat.style.display === "" ? "block" : "none";
    });

    function toggleChat() {
        chat.style.display = "none";
    }
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    fetch('index.php?modulo=prestamos&controlador=prestamos&funcion=ultimosPrestamosAjax')
        .then(response => response.text())
        .then(html => {
            document.getElementById('ultimos-prestamos').innerHTML = html;
        })
        .catch(() => {
            document.getElementById('ultimos-prestamos').innerHTML = "No se pudo cargar.";
        });
});
</script>