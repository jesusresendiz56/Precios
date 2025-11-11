<?php
session_start();
require_once '../modelo/conexion.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

try {
    $manager = getMongoManager();
    $dbname = getMongoDB();
    
    // Obtener datos del usuario
    $filter = ['_id' => new MongoDB\BSON\ObjectId($_SESSION['id_usuario'])];
    $options = [];
    $query = new MongoDB\Driver\Query($filter, $options);
    $cursor = $manager->executeQuery("$dbname.usuarios", $query);
    $usuarios = iterator_to_array($cursor);
    
    if (count($usuarios) === 1) {
        $usuario = current($usuarios);
    } else {
        // Si no se encuentra el usuario, cerrar sesión
        session_destroy();
        header("Location: login.php");
        exit();
    }
} catch (Exception $e) {
    $error = "Error al cargar los datos del usuario: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Comparador de Productos</title>
    <link rel="stylesheet" href="../scr/styles/principal.css">
    <link rel="stylesheet" href="../scr/styles/perfil.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Estilos adicionales para la sección de comparador */
        .comparador-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            margin-top: 30px;
            border: 2px solid #e9ecef;
        }
        
        .comparador-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
        }
        
        .comparador-header i {
            font-size: 1.8em;
            color: #667eea;
            margin-right: 15px;
        }
        
        .comparador-header h3 {
            color: #333;
            font-size: 1.4em;
            margin: 0;
        }
        
        .search-container {
            margin-bottom: 25px;
        }
        
        .search-box-profile {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .search-box-profile input {
            flex: 1;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .search-box-profile input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .btn-buscar-profile {
            padding: 12px 25px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background 0.3s;
        }
        
        .btn-buscar-profile:hover {
            background: #5568d3;
        }
        
        .tiendas-grid-profile {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .tienda-card-profile {
            background: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            border: 2px solid transparent;
        }
        
        .tienda-card-profile:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        
        .tienda-card-profile.walmart-card {
            border-color: #0071ce;
        }
        
        .tienda-card-profile.chedraui-card {
            border-color: #ed1c24;
        }
        
        .tienda-card-profile.soriana-card {
            border-color: #00a94f;
        }
        
        .tienda-card-profile.comparar-card {
            border-color: #ff6b00;
            background: linear-gradient(135deg, #fff, #fff8f0);
        }
        
        .tienda-icon-profile {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        .tienda-card-profile h4 {
            color: #333;
            margin-bottom: 8px;
            font-size: 1.1em;
        }
        
        .tienda-card-profile p {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 12px;
        }
        
        .btn-tienda-profile {
            padding: 8px 15px;
            background: #333;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            font-size: 0.9em;
            transition: background 0.3s;
        }
        
        .walmart-card .btn-tienda-profile {
            background: #0071ce;
        }
        
        .chedraui-card .btn-tienda-profile {
            background: #ed1c24;
        }
        
        .soriana-card .btn-tienda-profile {
            background: #00a94f;
        }
        
        .comparar-card .btn-tienda-profile {
            background: #ff6b00;
        }
        
        .btn-tienda-profile:hover {
            opacity: 0.9;
        }
        
        .historial-section {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px solid #e9ecef;
        }
        
        .historial-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .historial-header i {
            color: #667eea;
            margin-right: 10px;
        }
        
        .historial-header h4 {
            color: #333;
            margin: 0;
        }
        
        .historial-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .historial-item {
            background: white;
            padding: 8px 15px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 0.9em;
            color: #666;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .historial-item:hover {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }
        
        @media (max-width: 768px) {
            .tiendas-grid-profile {
                grid-template-columns: 1fr;
            }
            
            .search-box-profile {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header visible">
        <div class="container">
            <div class="logo">
                <h1><i class="fas fa-balance-scale"></i> Comparador</h1>
            </div>
            <nav class="nav">
                <ul>
                    <li><a href="index.html" class="nav-link">Inicio</a></li>
                    <li><a href="categorias.php" class="nav-link">Categorías</a></li>
                    <li><a href="comparador.php" class="nav-link">Comparar</a></li>
                    <li><a href="perfil.php" class="nav-link active">Mi Perfil</a></li>
                </ul>
            </nav>
            <div class="user-actions">
                <a href="../controlador/logout.php" class="btn btn-secondary btn-sm">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                </a>
            </div>
        </div>
    </header>

    <!-- Sección de Perfil -->
    <section class="profile-section">
        <div class="container">
            <div class="profile-header">
                <h2>Mi Perfil</h2>
                <p>Gestiona tu información personal y preferencias</p>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <div class="profile-content">
                <!-- Información del Usuario -->
                <div class="profile-card">
                    <div class="profile-header-card">
                        <div class="profile-avatar">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="profile-info">
                            <h3><?php echo htmlspecialchars($usuario->nombre_completo ?? 'Usuario'); ?></h3>
                            <p><?php echo htmlspecialchars($usuario->correo ?? ''); ?></p>
                            <span class="member-since">
                                Miembro desde: <?php 
                                if (isset($usuario->fecha_registro)) {
                                    echo date('d/m/Y', $usuario->fecha_registro->toDateTime()->getTimestamp());
                                } else {
                                    echo 'Fecha no disponible';
                                }
                                ?>
                            </span>
                        </div>
                    </div>

                    <div class="profile-details">
                        <div class="detail-group">
                            <h4>Información Personal</h4>
                            <div class="detail-item">
                                <span class="detail-label">Nombre completo:</span>
                                <span class="detail-value"><?php echo htmlspecialchars($usuario->nombre_completo ?? 'No especificado'); ?></span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Correo electrónico:</span>
                                <span class="detail-value"><?php echo htmlspecialchars($usuario->correo ?? 'No especificado'); ?></span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Teléfono:</span>
                                <span class="detail-value"><?php echo htmlspecialchars($usuario->telefono ?? 'No especificado'); ?></span>
                            </div>
                        </div>

                        <div class="detail-group">
                            <h4>Preferencias</h4>
                            <div class="detail-item">
                                <span class="detail-label">Categorías favoritas:</span>
                                <span class="detail-value">
                                    <?php 
                                    if (isset($usuario->categorias_favoritas) && is_array($usuario->categorias_favoritas)) {
                                        echo implode(', ', $usuario->categorias_favoritas);
                                    } else {
                                        echo 'No especificadas';
                                    }
                                    ?>
                                </span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Notificaciones:</span>
                                <span class="detail-value">
                                    <?php 
                                    if (isset($usuario->notificaciones) && $usuario->notificaciones) {
                                        echo 'Activadas';
                                    } else {
                                        echo 'Desactivadas';
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="profile-actions">
                        <button class="btn btn-primary" id="editProfileBtn">
                            <i class="fas fa-edit"></i> Editar Perfil
                        </button>
                        <button class="btn btn-secondary" id="changePasswordBtn">
                            <i class="fas fa-key"></i> Cambiar Contraseña
                        </button>
                    </div>
                </div>

                <!-- Estadísticas del Usuario -->
                <div class="stats-card">
                    <h4>Mi Actividad</h4>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-balance-scale"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-number"><?php echo $usuario->comparaciones_realizadas ?? 0; ?></span>
                                <span class="stat-label">Comparaciones</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-number"><?php echo $usuario->productos_favoritos ?? 0; ?></span>
                                <span class="stat-label">Favoritos</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-eye"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-number"><?php echo $usuario->productos_vistos ?? 0; ?></span>
                                <span class="stat-label">Vistos</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- NUEVA SECCIÓN: Comparador de Productos -->
            <div class="comparador-section">
                <div class="comparador-header">
                    <i class="fas fa-search-dollar"></i>
                    <h3>Comparador de Precios</h3>
                </div>
                
                <div class="search-container">
                    <div class="search-box-profile">
                        <input 
                            type="text" 
                            id="terminoProfile" 
                            placeholder="¿Qué producto estás buscando? Ejemplo: leche, pan, papel higiénico..."
                            value="papel higienico"
                        >
                        <button class="btn-buscar-profile" onclick="buscarDesdeProfile()">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                    
                    <div class="tiendas-grid-profile">
                        <!-- Walmart -->
                        <div class="tienda-card-profile walmart-card" onclick="irATiendaDesdeProfile('walmart')">
                            <div class="tienda-icon-profile">🏪</div>
                            <h4>Walmart</h4>
                            <p>Ver productos</p>
                            <button class="btn-tienda-profile" onclick="event.stopPropagation(); irATiendaDesdeProfile('walmart')">
                                Explorar
                            </button>
                        </div>
                        
                        <!-- Chedraui -->
                        <div class="tienda-card-profile chedraui-card" onclick="irATiendaDesdeProfile('chedraui')">
                            <div class="tienda-icon-profile">🛒</div>
                            <h4>Chedraui</h4>
                            <p>Ver productos</p>
                            <button class="btn-tienda-profile" onclick="event.stopPropagation(); irATiendaDesdeProfile('chedraui')">
                                Explorar
                            </button>
                        </div>
                        
                        <!-- Soriana -->
                        <div class="tienda-card-profile soriana-card" onclick="irATiendaDesdeProfile('soriana')">
                            <div class="tienda-icon-profile">�</div>
                            <h4>Soriana</h4>
                            <p>Ver productos</p>
                            <button class="btn-tienda-profile" onclick="event.stopPropagation(); irATiendaDesdeProfile('soriana')">
                                Explorar
                            </button>
                        </div>
                        
                        <!-- Comparar Todos -->
                        <div class="tienda-card-profile comparar-card" onclick="compararTodosDesdeProfile()">
                            <div class="tienda-icon-profile">⚖️</div>
                            <h4>Comparar</h4>
                            <p>Todas las tiendas</p>
                            <button class="btn-tienda-profile" onclick="event.stopPropagation(); compararTodosDesdeProfile()">
                                Comparar
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Historial de búsquedas -->
                <div class="historial-section">
                    <div class="historial-header">
                        <i class="fas fa-history"></i>
                        <h4>Búsquedas Recientes</h4>
                    </div>
                    <div class="historial-list" id="historialBusquedas">
                        <!-- Se llenará con JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Editar Perfil -->
    <div id="editProfileModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Editar Perfil</h3>
            <form id="editProfileForm" action="../controlador/actualizar_perfil.php" method="POST">
                <div class="form-group">
                    <label for="nombre_completo">Nombre completo</label>
                    <input type="text" id="nombre_completo" name="nombre_completo" 
                           value="<?php echo htmlspecialchars($usuario->nombre_completo ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="tel" id="telefono" name="telefono" 
                           value="<?php echo htmlspecialchars($usuario->telefono ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="categorias_favoritas">Categorías favoritas (separadas por comas)</label>
                    <input type="text" id="categorias_favoritas" name="categorias_favoritas" 
                           value="<?php 
                           if (isset($usuario->categorias_favoritas) && is_array($usuario->categorias_favoritas)) {
                               echo htmlspecialchars(implode(', ', $usuario->categorias_favoritas));
                           }
                           ?>">
                </div>
                <div class="form-options">
                    <label>
                        <input type="checkbox" name="notificaciones" 
                               <?php echo (isset($usuario->notificaciones) && $usuario->notificaciones) ? 'checked' : ''; ?>>
                        Recibir notificaciones por correo
                    </label>
                </div>
                <button type="submit" class="btn btn-primary btn-full">Guardar Cambios</button>
            </form>
        </div>
    </div>

    <!-- Modal Cambiar Contraseña -->
    <div id="changePasswordModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Cambiar Contraseña</h3>
            <form id="changePasswordForm" action="../controlador/cambiar_password.php" method="POST">
                <div class="form-group">
                    <label for="current_password">Contraseña actual</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">Nueva contraseña</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirmar nueva contraseña</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-full">Cambiar Contraseña</button>
            </form>
        </div>
    </div>

    <script>
    // ========================================
    // FUNCIONALIDAD DEL COMPARADOR EN PERFIL
    // ========================================
    
    // Funciones para el comparador integrado en el perfil
    function buscarDesdeProfile() {
        const termino = document.getElementById('terminoProfile').value.trim();
        
        if (!termino) {
            alert('Por favor ingresa un producto para buscar');
            return;
        }
        
        // Guardar término en localStorage
        localStorage.setItem('terminoBusqueda', termino);
        
        // Guardar en historial
        guardarEnHistorial(termino);
        
        // Ir a comparar todos
        compararTodosDesdeProfile();
    }
    
    function irATiendaDesdeProfile(tienda) {
        const termino = document.getElementById('terminoProfile').value.trim();
        
        if (!termino) {
            alert('Por favor ingresa un producto para buscar');
            return;
        }
        
        localStorage.setItem('terminoBusqueda', termino);
        guardarEnHistorial(termino);
        
        // ✅ RUTAS CORREGIDAS - Desde /vista/ hacia /scr/tiendas/pages/
        window.location.href = `../scr/tiendas/pages/tienda-${tienda}.php`;
    }
    
    function compararTodosDesdeProfile() {
        const termino = document.getElementById('terminoProfile').value.trim();
        
        if (!termino) {
            alert('Por favor ingresa un producto para buscar');
            return;
        }
        
        localStorage.setItem('terminoBusqueda', termino);
        guardarEnHistorial(termino);
        
        // ✅ RUTA CORREGIDA - Desde /vista/ hacia /scr/tiendas/pages/
        window.location.href = '../scr/tiendas/pages/comparar-todos.php';
    }
    
    // ========================================
    // GESTIÓN DE HISTORIAL DE BÚSQUEDAS
    // ========================================
    
    function guardarEnHistorial(termino) {
        let historial = JSON.parse(localStorage.getItem('historialBusquedas') || '[]');
        
        // Evitar duplicados
        historial = historial.filter(item => item !== termino);
        
        // Agregar al inicio
        historial.unshift(termino);
        
        // Mantener solo los últimos 5
        if (historial.length > 5) {
            historial = historial.slice(0, 5);
        }
        
        localStorage.setItem('historialBusquedas', JSON.stringify(historial));
        mostrarHistorial();
    }
    
    function mostrarHistorial() {
        const historial = JSON.parse(localStorage.getItem('historialBusquedas') || '[]');
        const historialDiv = document.getElementById('historialBusquedas');
        
        if (!historialDiv) return; // Seguridad
        
        if (historial.length === 0) {
            historialDiv.innerHTML = '<p style="color: #999; font-size: 0.9em; text-align: center; padding: 10px;">No hay búsquedas recientes</p>';
            return;
        }
        
        let html = '';
        historial.forEach(termino => {
            html += `
                <div class="historial-item" onclick="buscarHistorial('${termino.replace(/'/g, "\\'")}')">
                    <i class="fas fa-clock" style="margin-right: 5px;"></i>
                    ${termino}
                </div>
            `;
        });
        
        historialDiv.innerHTML = html;
    }
    
    function buscarHistorial(termino) {
        document.getElementById('terminoProfile').value = termino;
        buscarDesdeProfile();
    }
    
    // ========================================
    // INICIALIZACIÓN AL CARGAR LA PÁGINA
    // ========================================
    
    window.addEventListener('load', function() {
        // Mostrar historial
        mostrarHistorial();
        
        // Cargar término guardado si existe
        const terminoGuardado = localStorage.getItem('terminoBusqueda');
        if (terminoGuardado) {
            const input = document.getElementById('terminoProfile');
            if (input) {
                input.value = terminoGuardado;
            }
        }
    });
    
    // ========================================
    // EVENTOS
    // ========================================
    
    // Permitir buscar con Enter
    const terminoInput = document.getElementById('terminoProfile');
    if (terminoInput) {
        terminoInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                buscarDesdeProfile();
            }
        });
    }
    
    // Limpiar historial (función opcional)
    function limpiarHistorial() {
        if (confirm('¿Seguro que deseas borrar el historial de búsquedas?')) {
            localStorage.removeItem('historialBusquedas');
            mostrarHistorial();
        }
    }
</script>

    <script src="../scr/js/perfil.js"></script>
</body>
</html>