<!-- =====================================
     ARCHIVO: Footer
     DESCRIPCIÓN: Pie de página moderno con ola SVG y verde institucional
     ESTILO: Bootstrap 5 + Boxicons + Verde elegante
====================================== -->

<!-- ============ CONTENIDO PRINCIPAL ============ -->
<div class="contenido">
    <!-- Aquí va todo tu contenido superior (tarjetas, formularios, tablas, etc.) -->
</div>

<!-- ============ SECCIÓN FOOTER ============ -->
<div class="footer-section">

    <!-- === Ola SVG superior decorativa === -->
    <div class="wave-container">
        <svg viewBox="0 0 1440 150" preserveAspectRatio="none" style="transform: scaleX(-1);">
            <path d="M0,90 C360,0 1080,180 1440,90 L1440,150 L0,150 Z" fill="#2a8c4a"></path>
        </svg>
    </div>

    <!-- === Contenido del footer === -->
    <footer class="footer-content text-white text-center">
        <div class="container py-4">
            <p class="mb-0 fw-semibold">2025 © InvenSys - Todos los derechos reservados</p>
        </div>
    </footer>

</div>

<!-- ============ ESTILOS PERSONALIZADOS FOOTER ============ -->
<style>
    /* === Estructura general para mantener el footer al fondo === */
    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow-x: hidden;
    }

    .contenido {
        flex: 1;
        padding: 20px;
    }

    .footer-section {
        width: 100%;
    }

    /* === Ola SVG decorativa === */
    .wave-container {
        overflow: hidden;
        line-height: 0;
        margin-bottom: -5px;
    }

    .wave-container svg {
        display: block;
        width: 100%;
        height: 120px;
    }

    /* === Footer visual === */
    .footer-content {
        background-color: #2a8c4a;
    }

    /* === Responsive === */
    @media (max-width: 768px) {
        .wave-container svg {
            height: 80px;
        }

        .footer-content .container {
            padding: 2rem 1rem;
        }
    }
</style>

<!-- ============ SCRIPTS GLOBALES ============ -->
<script src="/Inventario/Web/Js/jquery.js"></script>
<script src="/Inventario/Web/Js/bootstrap.bundle.min.js"></script>
<script src="/Inventario/Web/Js/Alertas/AlertasGlobales.js"></script>

</body>
</html>
