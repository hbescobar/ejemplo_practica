
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Errores de Carga</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ef 100%);
            min-height: 100vh;
        }
        .error-box {
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 6px 32px rgba(0,0,0,0.08);
            padding: 3rem 2rem;
            max-width: 700px;
            margin: 4rem auto;
            text-align: center;
        }
        .error-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: #d32f2f;
            margin-bottom: 1.5rem;
        }
        .error-content {
            font-size: 1.3rem;
            color: #333;
            background: #fff3cd;
            border: 1px solid #ffeeba;
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            word-break: break-word;
        }
        .bx-error {
            font-size: 3rem;
            color: #d32f2f;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-box">
            <i class='bx bx-error'></i>
            <div class="error-title">Errores en la Carga Masiva</div>
            <div class="error-content">
                <?= !empty($carga['carga_errores']) ? nl2br(htmlspecialchars($carga['carga_errores'])) : 'No hay errores registrados.' ?>            </div>
            <a href="<?= getUrl('carga', 'carga', 'consult'); ?>" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class='bx bx-arrow-back'></i> Volver
            </a>
        </div>
    </div>
</body>
</html>