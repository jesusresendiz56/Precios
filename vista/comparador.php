<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparador Personalizado - ItemWise</title>
    <link rel="stylesheet" href="../scr/styles/principal.css">
    <link rel="stylesheet" href="../scr/styles/componentes.css">
    <link rel="stylesheet" href="../scr/styles/login.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Estilos específicos para el comparador */
        .comparador-container {
            max-width: 800px;
            margin: 100px auto 50px;
            padding: 4em 20px;
        }

        .comparador-card {  
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .comparador-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 30px;
            text-align: center;
        }

        .comparador-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .comparador-header p {
            opacity: 0.9;
            font-size: 16px;
        }

        .comparador-content {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 30px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 10px;
            font-size: 16px;
        }

        .form-group select {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: var(--border-radius);
            font-size: 16px;
            background: white;
            transition: all 0.3s;
        }

        .form-group select:hover {
            border-color: var(--primary);
        }

        .form-group select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(41, 146, 239, 0.1);
        }

        .tiendas-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .tienda-option {
            flex: 1;
            min-width: 200px;
        }

        .tienda-option input[type="radio"] {
            display: none;
        }

        .tienda-option label {
            display: block;
            padding: 20px;
            border: 3px solid #e0e0e0;
            border-radius: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            font-size: 18px;
            background: white;
        }

        .tienda-option input[type="radio"]:checked + label {
            border-color: var(--primary);
            background: var(--primary);
            color: white;
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(41, 146, 239, 0.3);
        }

        .tienda-option label:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-siguiente {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(41, 146, 239, 0.4);
        }

        .btn-siguiente:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(41, 146, 239, 0.6);
        }

        .btn-siguiente:active {
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            .comparador-container {
                margin: 80px auto 30px;
                padding: 0 15px;
            }

            .comparador-content {
                padding: 25px;
            }

            .tiendas-group {
                flex-direction: column;
            }

            .tienda-option {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header" id="main-header">
        <div class="container">
            <div class="logo">
                <img src="../scr/img/logo/logo.png" alt="ItemWise Logo" class="logo-img">
            </div>
            <nav class="nav">
                <ul>
                    <li><a href="index.html" class="nav-link">Inicio</a></li>
                    <li><a href="comparador.html" class="nav-link active">Comparador</a></li>
                    <li><a href="tiendas.html" class="nav-link">Tiendas</a></li>
                    <li><a href="recomendaciones.html" class="nav-link">Recomendaciones</a></li>
                </ul>
            </nav>
            <div class="user-actions">
                <button class="btn btn-primary" id="open-login-modal">Iniciar Sesión</button>
                <a href="../vista/register.html" class="btn btn-outline">Registrarse</a>
            </div>
        </div>
    </header>

    <!-- Contenido Principal del Comparador -->
    <div class="comparador-container">
        <div class="comparador-card">
            <div class="comparador-header">
                <h1>🛒 Comparador Inteligente</h1>
                <p>Compara productos y obtén la mejor recomendación</p>
            </div>
            
            <div class="comparador-content">
                <form method="POST" action="../controlador/ComparadorPersonalizado.php?paso=2">
                    <div class="form-group">
                        <label for="categoria">🏷️ Paso 1: ¿Qué categoría quieres comparar?</label>
                        <select name="categoria" id="categoria" required>
                            <option value="">-- Selecciona una categoría --</option>
                            <option value="arroz">🍚 Arroz</option>
                            <option value="papel">🧻 Papel</option>
                            <option value="refrescos">🥤 Refrescos</option>
                            <option value="galletas">🍪 Galletas</option>
                            <option value="lacteos">🥛 Lácteos</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>🏬 Paso 2: ¿Entre qué tiendas quieres comparar?</label>
                        <div class="tiendas-group">
                            <div class="tienda-option">
                                <input type="radio" name="comparacion" id="walmart_chedraui" value="walmart_chedraui" required>
                                <label for="walmart_chedraui">
                                    Walmart<br>vs<br>Chedraui
                                </label>
                            </div>
                            <div class="tienda-option">
                                <input type="radio" name="comparacion" id="solo_walmart" value="solo_walmart">
                                <label for="solo_walmart">
                                    Solo<br>Walmart
                                </label>
                            </div>
                            <div class="tienda-option">
                                <input type="radio" name="comparacion" id="solo_chedraui" value="solo_chedraui">
                                <label for="solo_chedraui">
                                    Solo<br>Chedraui
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-siguiente">
                        Siguiente: Ingresar Productos 🔍
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>ItemWise</h3>
                    <p>Tu guía inteligente para encontrar los mejores productos al mejor precio.</p>
                </div>
                <div class="footer-section">
                    <h4>Enlaces Rápidos</h4>
                    <ul>
                        <li><a href="index.html">Inicio</a></li>
                        <li><a href="comparador.html">Comparador</a></li>
                        <li><a href="tiendas.html">Tiendas</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contacto</h4>
                    <ul>
                        <li><a href="#">Soporte</a></li>
                        <li><a href="#">Preguntas Frecuentes</a></li>
                        <li><a href="#">Términos y Condiciones</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Síguenos</h4>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 ItemWise. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Modal: Inicio de Sesión -->
    <div id="login-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Iniciar sesión</h2>
            <p>Accede a tu cuenta para guardar tus comparaciones favoritas</p>
            <form id="loginForm" action="../controlador/engine_login.php" method="POST">
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" placeholder="correo@email.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>
                <div class="form-options">
                    <label>
                        <input type="checkbox" name="remember"> Recordar mi sesión
                    </label>
                    <a href="../vista/recuperarpassword.html" class="forgot-password">¿Olvidaste tu contraseña?</a>
                </div>
                <button type="submit" class="btn btn-primary btn-full">Iniciar sesión</button>
                <div class="modal-footer">
                    <p>¿No tienes cuenta? <a href="../vista/register.html">Registrate aquí</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Script para manejar el estado activo del header
        document.addEventListener('DOMContentLoaded', function() {
            // Header fijo sin transparencia inicial
            const header = document.getElementById('main-header');
            header.classList.remove('initial');
            
            // Simular funcionalidad del botón de login
            document.getElementById('open-login-modal')?.addEventListener('click', function() {
                alert('Funcionalidad de login - En una implementación real, se abriría un modal de login');
            });
        });
    </script>
</body>
</html>