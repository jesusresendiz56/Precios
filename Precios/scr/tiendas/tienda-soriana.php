<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Soriana - Comparador de Precios</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #00a94f 0%, #007a38 100%);
    min-height: 100vh;
    padding: 20px;
}
.container {
    max-width: 1200px;
    margin: auto;
    background: #fff;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.2);
}
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 3px solid #00a94f;
}
h1 { color: #00a94f; }
.btn-volver {
    padding: 12px 24px;
    background: #666;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    font-weight: bold;
}
.btn-volver:hover { background: #555; }
.buscador-interno {
    background: #f0fff0;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    border-left: 4px solid #00a94f;
}
.search-box { display: flex; gap: 10px; }
.search-input {
    flex: 1;
    padding: 12px;
    font-size: 1em;
    border: 2px solid #ddd;
    border-radius: 8px;
}
.search-input:focus {
    outline: none;
    border-color: #00a94f;
}
.btn-buscar {
    padding: 12px 30px;
    background: #00a94f;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
}
.btn-buscar:hover { background: #007a38; }
.info-box {
    background: #f0fff0;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    border-left: 4px solid #00a94f;
}
.categoria {
    margin-bottom: 30px;
    background: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
    border-left: 4px solid #00a94f;
}
.categoria-header {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e9ecef;
}
.categoria-icono {
    font-size: 1.5em;
    margin-right: 10px;
}
.categoria-titulo {
    font-size: 1.3em;
    font-weight: bold;
    color: #333;
}
.categoria-cantidad {
    background: #00a94f;
    color: white;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.8em;
    margin-left: 10px;
}
.productos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 15px;
}
.producto-card {
    border: 2px solid #00a94f;
    border-radius: 10px;
    padding: 15px;
    display: flex;
    flex-direction: column;
    background: #fff;
    transition: 0.3s;
}
.producto-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 12px rgba(0,169,79,0.3);
}
.producto-imagen {
    width: 100%;
    height: 200px;
    object-fit: contain;
    background: #f8f8f8;
    border-radius: 8px;
    margin-bottom: 10px;
}
.producto-nombre {
    font-weight: bold;
    font-size: 14px;
    margin-bottom: 8px;
    min-height: 40px;
    color: #333;
}
.producto-precio {
    color: #00a94f;
    font-size: 1.5em;
    font-weight: bold;
    margin: 10px 0;
}
.producto-precio-antes {
    color: #999;
    text-decoration: line-through;
    font-size: 0.9em;
    margin-bottom: 5px;
}
.loading { text-align: center; padding: 40px; font-size: 18px; color: #666; }
.spinner {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #00a94f;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
    margin: 0 auto 15px;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
.error {
    background: #fee;
    color: #c33;
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
    border-left: 4px solid #c33;
}
.estadisticas {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.estadistica-card {
    background: white;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #ddd;
    flex: 1;
    min-width: 150px;
    text-align: center;
}
.estadistica-valor {
    font-size: 1.5em;
    font-weight: bold;
    color: #00a94f;
}
.estadistica-label {
    font-size: 0.9em;
    color: #666;
}
@media (max-width: 768px) {
    .header { flex-direction: column; gap: 15px; text-align: center; }
    .productos-grid { grid-template-columns: 1fr; }
    .search-box { flex-direction: column; }
    .estadisticas { flex-direction: column; }
}
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🛒 Soriana - Productos</h1>
        <a href="../index.php" class="btn-volver">← Volver al Inicio</a>
    </div>
    
    <div class="buscador-interno">
        <div class="search-box">
            <input 
                type="text" 
                class="search-input" 
                id="busqueda-soriana" 
                placeholder="Buscar producto específico en Soriana..."
            >
            <button class="btn-buscar" onclick="buscarEnSoriana()">🔍 Buscar</button>
        </div>
        <div style="margin-top: 10px; font-size: 0.9em; color: #666;">
            <strong>Sugerencias:</strong> papel higiénico
        </div>
    </div>
    
    <div class="info-box">
        <strong id="info-titulo">Todos los productos de Soriana</strong>
        <div id="info-detalle" style="margin-top: 5px; font-size: 0.9em; color: #666;"></div>
        <div id="estadisticas-tienda" class="estadisticas" style="display: none;"></div>
    </div>
    
    <div id="resultados">
        <div class="loading">
            <div class="spinner"></div>
            <p>⏳ Cargando productos de Soriana...</p>
        </div>
    </div>
</div>

<script>
let todosLosProductosSoriana = [];
let busquedaActual = '';

window.addEventListener('load', function() {
    cargarTodosLosProductosSoriana();
});

document.getElementById('busqueda-soriana').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') buscarEnSoriana();
});

function buscarEnSoriana() {
    const termino = document.getElementById('busqueda-soriana').value.trim();
    busquedaActual = termino;
    
    if (termino === '') {
        mostrarProductosSoriana(todosLosProductosSoriana, 'Todos los productos');
        return;
    }
    
    localStorage.setItem('terminoBusqueda', termino);
    filtrarProductosSoriana(termino);
}

async function cargarTodosLosProductosSoriana() {
    try {
        const response = await fetch('../data/soriana_papel.json');
        const data = await response.json();
        
        todosLosProductosSoriana = procesarJSONSoriana(data);
        mostrarProductosSoriana(todosLosProductosSoriana, 'Todos los productos');
        
    } catch (e) {
        document.getElementById('resultados').innerHTML = `
            <div class="error">❌ Error: ${e.message}</div>
        `;
    }
}

function procesarJSONSoriana(data) {
    const productos = [];
    
    if (!Array.isArray(data)) return productos;

    data.forEach(item => {
        const precio = extraerPrecio(item.precio || '');
        if (precio <= 0) return;

        const categoria = detectarCategoria(item.nombre || '');
        const precioAntes = item.precio_tachado ? extraerPrecio(item.precio_tachado) : precio * 1.1;
        
        productos.push({
            nombre: item.nombre || 'Sin nombre',
            precio: precio,
            precio_antes: precioAntes,
            tienda: 'Soriana',
            categoria: categoria,
            marca: extraerMarca(item.nombre || ''),
            imagen: item.imagen || '',
            url: item.href ? 'https://www.soriana.com' + item.href : '',
            rating: Math.random() * 1 + 4,
            reviews: Math.floor(Math.random() * 150) + 10,
            disponibilidad: 'Disponible',
            vendedor: 'Soriana'
        });
    });

    return productos;
}

function extraerPrecio(precioString) {
    if (!precioString) return 0;
    const match = precioString.match(/\$?(\d+\.?\d*)/);
    return match ? parseFloat(match[1]) : 0;
}

function detectarCategoria(nombre) {
    nombre = nombre.toLowerCase();
    if (nombre.includes('papel') || nombre.includes('higienico')) {
        return '🧻 Papel Higiénico';
    }
    return '🛒 Otros Productos';
}

function extraerMarca(nombre) {
    const marcas = ['Quality', 'Precíssimo', 'Pétalo', 'Suavel', 'Regio', 'Cottonelle', 'Kleenex', 'Elite'];
    for (const marca of marcas) {
        if (nombre.includes(marca)) {
            return marca;
        }
    }
    return '';
}

function filtrarProductosSoriana(termino) {
    const terminoLower = termino.toLowerCase();
    const productosFiltrados = todosLosProductosSoriana.filter(producto => 
        producto.nombre.toLowerCase().includes(terminoLower) ||
        producto.categoria.toLowerCase().includes(terminoLower) ||
        producto.marca.toLowerCase().includes(terminoLower)
    );
    
    mostrarProductosSoriana(productosFiltrados, `Resultados para: "${termino}"`);
}

function mostrarProductosSoriana(productos, titulo) {
    const resultados = document.getElementById('resultados');
    document.getElementById('info-titulo').innerHTML = `<strong>${titulo}</strong>`;
    
    if (!Array.isArray(productos) || productos.length === 0) {
        resultados.innerHTML = '<div class="error">No se encontraron productos</div>';
        document.getElementById('info-detalle').textContent = '0 productos encontrados';
        document.getElementById('estadisticas-tienda').style.display = 'none';
        return;
    }
    
    // Calcular estadísticas
    const totalProductos = productos.length;
    const categorias = [...new Set(productos.map(p => p.categoria))];
    const precioMin = Math.min(...productos.map(p => p.precio));
    const precioMax = Math.max(...productos.map(p => p.precio));
    const precioPromedio = productos.reduce((sum, p) => sum + p.precio, 0) / totalProductos;
    
    mostrarEstadisticas(totalProductos, categorias.length, precioMin, precioMax, precioPromedio);
    document.getElementById('info-detalle').textContent = `${totalProductos} productos encontrados en ${categorias.length} categorías`;
    
    const productosPorCategoria = {};
    productos.forEach(producto => {
        const categoria = producto.categoria || '🛒 Otros Productos';
        if (!productosPorCategoria[categoria]) {
            productosPorCategoria[categoria] = [];
        }
        productosPorCategoria[categoria].push(producto);
    });
    
    let html = '';
    
    for (const [categoria, productosCategoria] of Object.entries(productosPorCategoria)) {
        const icono = categoria.split(' ')[0];
        const nombreCategoria = categoria.replace(/^[^\w\s]*\s/, '');
        
        html += `
            <div class="categoria">
                <div class="categoria-header">
                    <span class="categoria-icono">${icono}</span>
                    <span class="categoria-titulo">${nombreCategoria}</span>
                    <span class="categoria-cantidad">${productosCategoria.length} productos</span>
                </div>
                <div class="productos-grid">
        `;
        
        productosCategoria.forEach(prod => {
            const precioAntes = prod.precio_antes && prod.precio_antes > prod.precio 
                ? `<div class="producto-precio-antes">Antes: $${prod.precio_antes.toFixed(2)}</div>` 
                : '';
            
            html += `
                <div class="producto-card">
                    <img src="${prod.imagen || 'https://via.placeholder.com/200?text=Sin+Imagen'}" 
                         class="producto-imagen" 
                         alt="${prod.nombre}"
                         onerror="this.src='https://via.placeholder.com/200?text=Sin+Imagen'">
                    <div class="producto-nombre">${prod.nombre}</div>
                    ${precioAntes}
                    <div class="producto-precio">$${prod.precio.toFixed(2)}</div>
                    ${prod.marca ? `<div style="background: #e9ecef; padding: 2px 8px; border-radius: 4px; font-size: 0.8em; color: #495057; display: inline-block; margin-top: 5px;">${prod.marca}</div>` : ''}
                </div>`;
        });
        
        html += `</div></div>`;
    }
    
    resultados.innerHTML = html;
}

function mostrarEstadisticas(total, categorias, min, max, promedio) {
    const estadisticasDiv = document.getElementById('estadisticas-tienda');
    
    estadisticasDiv.innerHTML = `
        <div class="estadistica-card">
            <div class="estadistica-valor">${total}</div>
            <div class="estadistica-label">Total Productos</div>
        </div>
        <div class="estadistica-card">
            <div class="estadistica-valor">${categorias}</div>
            <div class="estadistica-label">Categorías</div>
        </div>
        <div class="estadistica-card">
            <div class="estadistica-valor">$${min.toFixed(2)}</div>
            <div class="estadistica-label">Precio Mínimo</div>
        </div>
        <div class="estadistica-card">
            <div class="estadistica-valor">$${max.toFixed(2)}</div>
            <div class="estadistica-label">Precio Máximo</div>
        </div>
        <div class="estadistica-card">
            <div class="estadistica-valor">$${promedio.toFixed(2)}</div>
            <div class="estadistica-label">Precio Promedio</div>
        </div>
    `;
    
    estadisticasDiv.style.display = 'flex';
}
</script>
</body>
</html>