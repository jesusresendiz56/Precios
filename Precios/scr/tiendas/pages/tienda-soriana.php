<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>🛒 Soriana - Comparador de Precios</title>
<link rel="icon" href="https://www.soriana.com/favicon.ico">
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #ff4b2b 0%, #ff416c 100%);
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
    border-bottom: 3px solid #c2002f;
}

h1 {
    color: #c2002f;
}

.btn-volver {
    padding: 12px 24px;
    background: #666;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    font-weight: bold;
    transition: all 0.3s;
}

.btn-volver:hover {
    background: #555;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.info-box {
    background: #fff5f5;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    border-left: 4px solid #c2002f;
}

.productos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 15px;
}

.producto-card {
    border: 2px solid #c2002f;
    border-radius: 10px;
    padding: 15px;
    display: flex;
    flex-direction: column;
    background: #fff;
    transition: 0.3s;
}

.producto-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 12px rgba(194,0,47,0.3);
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
    color: #c2002f;
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

.producto-link {
    background: #c2002f;
    color: white;
    padding: 10px;
    text-align: center;
    border-radius: 5px;
    text-decoration: none;
    margin-top: auto;
    transition: 0.3s;
}

.producto-link:hover {
    background: #a00028;
}

.loading {
    text-align: center;
    padding: 40px;
    font-size: 18px;
    color: #666;
}

.error {
    background: #fee;
    color: #c33;
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
    border-left: 4px solid #c33;
}

@media (max-width: 768px) {
    .header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .productos-grid {
        grid-template-columns: 1fr;
    }
}
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🛒 Productos Soriana</h1>
        <a href="../index.php" class="btn-volver">← Volver al Inicio</a>
    </div>
    
    <div class="info-box">
        <strong>📦 Info:</strong> <span id="info">Cargando productos...</span>
    </div>
    
    <div id="resultados">
        <div class="loading">⏳ Cargando productos de Soriana...</div>
    </div>
</div>

<script>
async function cargarProductos() {
    try {
        const formData = new FormData();
        formData.append('buscar', '1');
        formData.append('termino', 'papel');
        
        const resp = await fetch('../scraper.php', { 
            method: 'POST', 
            body: formData 
        });
        
        const contentType = resp.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const textoError = await resp.text();
            console.error('Respuesta del servidor:', textoError);
            throw new Error('El servidor no devolvió JSON válido');
        }
        
        const data = await resp.json();
        console.log('Datos recibidos:', data);

        if (data.error) {
            document.getElementById('resultados').innerHTML = 
                `<div class="error">❌ Error: ${data.error}</div>`;
            return;
        }

        if (!data.soriana || data.soriana.length === 0) {
            document.getElementById('resultados').innerHTML = 
                '<div class="error">⚠️ No se encontraron productos de Soriana.</div>';
            document.getElementById('info').textContent = 
                `Sin productos`;
            return;
        }

        const info = data.soriana_info || {};
        document.getElementById('info').textContent = 
            `${data.soriana.length} productos encontrados | Total en JSON: ${info.total_en_json || 0} | Sin precio: ${info.sin_precio || 0}`;

        let html = '<div class="productos-grid">';
        data.soriana.forEach(p => {
            const precioAntes = p.precio_antes && p.precio_antes > p.precio 
                ? `<div class="producto-precio-antes">Antes: $${p.precio_antes.toFixed(2)}</div>` 
                : '';
            
            html += `
                <div class="producto-card">
                    <img src="${p.imagen || 'https://via.placeholder.com/200?text=Sin+Imagen'}" 
                         class="producto-imagen" 
                         alt="${p.nombre}"
                         onerror="this.src='https://via.placeholder.com/200?text=Sin+Imagen'">
                    <div class="producto-nombre">${p.nombre}</div>
                    ${precioAntes}
                    <div class="producto-precio">$${p.precio.toFixed(2)}</div>
                    <a href="${p.url}" class="producto-link" target="_blank">Ver en Soriana →</a>
                </div>`;
        });
        html += '</div>';
        document.getElementById('resultados').innerHTML = html;
        
    } catch (e) {
        console.error('Error completo:', e);
        document.getElementById('resultados').innerHTML = 
            `<div class="error">❌ Error al cargar: ${e.message}</div>`;
    }
}

window.onload = cargarProductos;
</script>
</body>
</html>