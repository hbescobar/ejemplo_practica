<!-- CONTENIDO -->
<div class="contenido">
    <!-- Tu formulario, tus tarjetas, todo -->
</div>

<!-- FOOTER -->
<div class="footer-section">
    <div class="wave-container">
        <svg viewBox="0 0 1440 150" preserveAspectRatio="none" style="transform: scaleX(-1);">
            <path d="M0,90 C360,0 1080,180 1440,90 L1440,150 L0,150 Z" fill="#0d6efd"></path>
        </svg>
    </div>

    <footer class="footer-content text-white text-center">
        <div class="container py-4">
            <p class="mb-0 fw-semibold">2025 © InvenSys - Todos los derechos reservados</p>
        </div>
    </footer>
</div>

<style>
    /* Flexbox vertical para que el footer siempre se acomode al contenido */
    html,
    body {
        margin: 0;
        padding: 0;
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow-x: hidden;
    }

    /* El contenido empuja el footer hacia abajo */
    .contenido {
        padding: 20px;
        flex: 1;
    }

    .footer-section {
        width: 100%;
    }

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

    .footer-content {
        background-color: #0d6efd;
    }

    @media (max-width: 768px) {
        .wave-container svg {
            height: 80px;
        }

        .footer-content .container {
            padding: 2rem 1rem;
        }
    }
</style>

<!-- JS scripts -->
<script src="/Inventario/Web/Js/jquery.js"></script>
<script src="/Inventario/Web/Js/bootstrap.bundle.min.js"></script>
<script src="/Inventario/Web/Js/Alertas/AlertasGlobales.js"></script>
</body>

</html>