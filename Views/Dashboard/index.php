<div class="container my-5">
    <h1 class="text-center mb-4">Panel Principal</h1>

    <div class="row justify-content-center g-4">
        <!-- Fila 1 -->
        <div class="col-md-6 col-lg-5">
            <div class="card text-center shadow rounded-4">
                <div class="card-body">
                    <h5 class="card-title">Actividad General</h5>
                    <p class="card-text text-muted">Resumen gráfico del sistema.</p>
                    <div style="height:100px; background:#f8f9fa; border-radius:8px;">(Gráfico aquí)</div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-5">
            <div class="card text-center shadow rounded-4">
                <div class="card-body">
                    <h5 class="card-title">Notificaciones</h5>
                    <p class="card-text text-muted">Alertas recientes del sistema.</p>
                    <div style="height:100px; background:#f8f9fa; border-radius:8px;">(Notis aquí)</div>
                </div>
            </div>
        </div>

        <!-- Fila 2 -->
        <div class="col-md-6 col-lg-5">
            <div class="card text-center shadow rounded-4">
                <div class="card-body">
                    <h5 class="card-title">Últimos Préstamos</h5>
                    <p class="card-text text-muted">Historial reciente de préstamos.</p>
                    <div style="height:100px; background:#f8f9fa; border-radius:8px;">(Préstamos)</div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-5">
            <div class="card text-center shadow rounded-4">
                <div class="card-body">
                    <h5 class="card-title">Inventario Disponible</h5>
                    <p class="card-text text-muted">Elementos listos para uso.</p>
                    <div style="height:100px; background:#f8f9fa; border-radius:8px;">(Inventario)</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón flotante de ayuda -->
    <button id="boton-ayuda" class="btn btn-primary rounded-circle shadow-lg">
        <i class='bx bx-bot fs-3'></i>
    </button>

    <!-- Chat flotante de ayuda -->
    <div id="chat-ayuda" class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span><i class='bx bx-help-circle me-2'></i>Centro de Ayuda</span>
            <button class="btn-close btn-close-white" aria-label="Cerrar" onclick="toggleChat()"></button>

        </div>
        <div class="card-body p-3 overflow-auto">
            <p class="text-muted small">¿En qué te puedo ayudar hoy? Aquí tienes recursos útiles:</p>

            <h6 class="fw-bold mt-3">📘 Manuales:</h6>
            <ul class="list-unstyled">
                <li>
                    <a href="manuales/manual_usuario.pdf" download class="btn btn-outline-secondary btn-sm w-100 mb-2 d-flex align-items-center justify-content-start">
                        <i class='bx bx-download me-2'></i> Manual de Usuario
                    </a>
                </li>
                <li>
                    <a href="manuales/manual_admin.pdf" download class="btn btn-outline-secondary btn-sm w-100 mb-2 d-flex align-items-center justify-content-start">
                        <i class='bx bx-download me-2'></i> Manual Administrador
                    </a>
                </li>
            </ul>

            <h6 class="fw-bold mt-3">🎥 Tutoriales:</h6>
            <ul class="list-unstyled">
                <li>
                    <a href="https://www.youtube.com/watch?v=VIDEO1" target="_blank" class="btn btn-outline-danger btn-sm w-100 mb-2 d-flex align-items-center justify-content-start">
                        <i class='bx bx-play-circle me-2'></i> Cómo registrar un préstamo
                    </a>
                </li>
                <li>
                    <a href="https://www.youtube.com/watch?v=VIDEO2" target="_blank" class="btn btn-outline-danger btn-sm w-100 d-flex align-items-center justify-content-start">
                        <i class='bx bx-play-circle me-2'></i> Cómo registrar un usuario
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- ESTILOS -->
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
</style>

<!-- SCRIPT -->
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