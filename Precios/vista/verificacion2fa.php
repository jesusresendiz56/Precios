<?php
// Iniciar sesión para acceder a $_SESSION
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

$usuario = $_SESSION['usuario'] ?? 'Usuario';
$secret = $_SESSION['2fa_secret'] ?? 'JBSWY3DPEHPK3PXP'; // Ideal: guardar en DB y usar aquí

$otpauthUrl = "otpauth://totp/{$usuario}?secret={$secret}&issuer=ItemWise";

$qrCode = new QrCode($otpauthUrl);
$writer = new PngWriter();
$result = $writer->write($qrCode);
$qrCodeBase64 = base64_encode($result->getString());
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurar Autenticación en Dos Pasos - ItemWise</title>
    <link rel="stylesheet" href="../scr/styles/principal.css">
    <link rel="stylesheet" href="../scr/styles/components.css">
    <link rel="stylesheet" href="../scr/styles/registro.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="logo">
                <img src="../scr/img/logo/logo.png" alt="ItemWise Logo" class="logo-img">
            </div>
            <nav class="nav">
                <ul>
                    <li><a href="index.html" class="nav-link">Inicio</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="register-section">
        <div class="container">
            <div class="register-box">
                <h2><i class="fas fa-qrcode"></i> Configurar 2FA</h2>
                <p class="subtitle">
                    Escanea el código QR con una app como <strong>Google Authenticator</strong>, 
                    <strong>Authy</strong> o <strong>Microsoft Authenticator</strong>.
                </p>

                <div class="qr-container">
                    <img 
                        src="data:image/png;base64,<?= htmlspecialchars($qrCodeBase64) ?>" 
                        alt="Código QR para 2FA" 
                        class="qr-code"
                    >
                    <p class="qr-help">
                        <i class="fas fa-info-circle"></i>
                        Si no puedes escanearlo, pidele ayuda a alguien más.
                    </p>
                </div>

                <form id="verify2faForm" method="POST" action="perfil.php">
                    <div class="form-group">
                        <label for="codigo">Código de verificación</label>
                        <input 
                            type="text" 
                            id="codigo" 
                            name="codigo" 
                            placeholder="Ejemplo --> 123456" 
                            inputmode="numeric"
                            maxlength="6"
                            required
                        >
                        <small class="form-hint">
                            Ingresa el código de 6 dígitos que muestra la app.
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary btn-full">
                        <i class="fas fa-check-circle"></i> Verificar y activar 2FA
                    </button>
                </form>

                <div class="modal-footer">
                    <p>
                        ¿Problemas? <a href="soporte.html">Contacta a soporte</a>
                    </p>
                </div>
            </div>
        </div>
    </main>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'codigo'): ?>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const alerta = document.createElement('div');
                alerta.innerHTML = `
                    <div style="
                        position:fixed; top:20px; right:20px; 
                        background:#e74c3c; color:white; padding:15px 20px; 
                        border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.15);
                        z-index:1100; animation:fadeIn 0.3s;
                    ">
                        <i class="fas fa-times-circle"></i> Código incorrecto. Inténtalo de nuevo.
                    </div>
                `;
                document.body.appendChild(alerta);
                setTimeout(() => alerta.remove(), 4000);
            });
        </script>
    <?php endif; ?>

    <style>
        .subtitle {
            text-align: center;
            margin-bottom: 25px;
            color: #666;
            font-weight: 400;
        }
        .qr-container {
            text-align: center;
            margin: 25px 0;
        }
        .qr-code {
            width: 200px;
            height: 200px;
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 10px;
            background: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .qr-help {
            margin-top: 15px;
            font-size: 0.9rem;
            color: #555;
        }
        .secret-key {
            background: #f0f0f0;
            padding: 4px 8px;
            border-radius: 4px;
            font-family: monospace;
            letter-spacing: 2px;
        }
        .form-hint {
            font-size: 0.85rem;
            color: #777;
            display: block;
            margin-top: 5px;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</body>
</html>