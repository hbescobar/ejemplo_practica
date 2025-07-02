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

</div>

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
</style>