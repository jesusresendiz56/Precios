// === DATOS DE EJEMPLO ===
const sampleProducts = [
    {
        id: 1,
        name: "Smartphone XYZ Pro",
        category: "electronics",
        price: 699,
        rating: 4.5,
        image: "https://images.jdmagicbox.com/quickquotes/images_main/-ououu1xe.jpg",
        description: "El último smartphone con cámara de alta resolución y batería de larga duración.",
        features: [
            "Pantalla 6.5\" AMOLED",
            "128GB Almacenamiento",
            "Cámara triple 48MP",
            "Batería 4000mAh"
        ]
    },
    {
        id: 2,
        name: "Laptop UltraSlim",
        category: "electronics",
        price: 999,
        rating: 4.7,
        image: "https://www.itaf.eu/wp-content/uploads/2021/01/Best-laptops-in-2021-7-things-to-consider-when-buying-a-laptop.jpg",
        description: "Laptop ultradelgada con procesador de última generación y pantalla táctil.",
        features: [
            "Procesador i7 10ma gen",
            "16GB RAM",
            "SSD 512GB",
            "Pantalla 14\" FHD"
        ]
    },
    {
        id: 3,
        name: "Auriculares Inalámbricos",
        category: "electronics",
        price: 149,
        rating: 4.3,
        image: "https://www.apple.com/v/airpods-pro/q/images/overview/welcome/hero__b0eal3mn03ua_large.jpg",
        description: "Auriculares con cancelación de ruido y hasta 30 horas de batería.",
        features: [
            "Cancelación de ruido activa",
            "Batería 30 horas",
            "Conexión Bluetooth 5.0",
            "Resistencia al agua IPX4"
        ]
    },
    {
        id: 4,
        name: "Tablet Multiusos",
        category: "electronics",
        price: 399,
        rating: 4.2,
        image: "https://i.blogs.es/35a5d8/lenovo-tab-m11/650_1200.jpg",
        description: "Tablet perfecta para trabajo y entretenimiento con lápiz digital incluido.",
        features: [
            "Pantalla 10.5\" IPS",
            "64GB Almacenamiento",
            "Lápiz digital incluido",
            "Batería 12 horas"
        ]
    },
    {
        id: 5,
        name: "Smart TV 4K",
        category: "electronics",
        price: 549,
        rating: 4.6,
        image: "https://m.media-amazon.com/images/I/91Hk42lTFaL.jpg",
        description: "Televisor inteligente con resolución 4K y sistema de sonido integrado.",
        features: [
            "Pantalla 55\" 4K UHD",
            "Smart TV con Android",
            "Sonido Dolby Atmos",
            "3 puertos HDMI"
        ]
    },
    {
        id: 6,
        name: "Zapatillas Deportivas",
        category: "sports",
        price: 89,
        rating: 4.4,
        image: "https://site.innovasport.com/is/adidas/2024/is-desk-lp-adidas-division-calzado.webp",
        description: "Zapatillas cómodas para running con tecnología de amortiguación avanzada.",
        features: [
            "Amortiguación reactiva",
            "Material transpirable",
            "Suela antideslizante",
            "Peso ligero"
        ]
    }
];

// === ESTADO DE LA APLICACIÓN ===
let state = {
    products: sampleProducts,
    filteredProducts: sampleProducts,
    comparisonProducts: [],
    currentCategory: '',
    currentPriceRange: ''
};

// === ELEMENTOS DEL DOM ===
const elements = {
    searchInput: document.getElementById('search-input'),
    searchBtn: document.getElementById('search-btn'),
    categoryFilter: document.getElementById('category-filter'),
    priceFilter: document.getElementById('price-filter'),
    recommendationsContainer: document.getElementById('recommendations-container'),
    comparisonContainer: document.getElementById('comparison-container'),
    clearComparisonBtn: document.getElementById('clear-comparison'),
    productModal: document.getElementById('product-modal'),
    modalBody: document.getElementById('modal-body'),
    loginModal: document.getElementById('login-modal'),
    registerModal: document.getElementById('register-modal'),
    openLoginModalBtn: document.getElementById('open-login-modal'),
    openRegisterModalBtn: document.getElementById('open-register-modal'),
    closeLoginModalBtn: document.querySelector('#login-modal .close'),
    closeRegisterModalBtn: document.querySelector('#register-modal .close'),
    closeProductModalBtn: document.querySelector('#product-modal .close'),
    switchToRegisterLink: document.getElementById('switch-to-register'),
    switchToLoginLink: document.getElementById('switch-to-login')
};

// === INICIALIZACIÓN ===
document.addEventListener('DOMContentLoaded', function() {
    initApp();
    setupSplashAndHeader();
});

function initApp() {
    renderRecommendedProducts();
    setupEventListeners();
}

// === SPLASH SCREEN Y HEADER (solo con scroll) ===
function setupSplashAndHeader() {
    const splashScreen = document.getElementById('splash-screen');
    const mainHeader = document.getElementById('main-header');

    if (!splashScreen || !mainHeader) return;

    let splashActive = true;

    const hideSplash = () => {
        if (!splashActive) return;
        splashActive = false;
        splashScreen.classList.add('splash-hidden');
        mainHeader.classList.remove('initial');
        mainHeader.classList.add('scrolled');
    };

    window.addEventListener('scroll', () => {
        if (splashActive && window.scrollY > 30) {
            hideSplash();
        }
    });
}

// === EVENTOS ===
function setupEventListeners() {
    // Búsqueda
    elements.searchBtn?.addEventListener('click', handleSearch);
    elements.searchInput?.addEventListener('keyup', (e) => {
        if (e.key === 'Enter') handleSearch();
    });

    // Filtros
    elements.categoryFilter?.addEventListener('change', handleFilterChange);
    elements.priceFilter?.addEventListener('change', handleFilterChange);

    // Comparación
    elements.clearComparisonBtn?.addEventListener('click', clearComparison);

    // Modales
    setupModalListeners();
}

function setupModalListeners() {
    // Login
    elements.openLoginModalBtn?.addEventListener('click', openLoginModal);
    elements.closeLoginModalBtn?.addEventListener('click', closeLoginModal);
    elements.loginModal?.addEventListener('click', (e) => {
        if (e.target === elements.loginModal) closeLoginModal();
    });

    // Registro
    elements.openRegisterModalBtn?.addEventListener('click', openRegisterModal);
    elements.closeRegisterModalBtn?.addEventListener('click', closeRegisterModal);
    elements.registerModal?.addEventListener('click', (e) => {
        if (e.target === elements.registerModal) closeRegisterModal();
    });

    // Cambio entre modales
    elements.switchToRegisterLink?.addEventListener('click', (e) => {
        e.preventDefault();
        closeLoginModal();
        openRegisterModal();
    });
    elements.switchToLoginLink?.addEventListener('click', (e) => {
        e.preventDefault();
        closeRegisterModal();
        openLoginModal();
    });

    // Tecla Esc
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            if (elements.loginModal.style.display === 'block') closeLoginModal();
            if (elements.registerModal.style.display === 'block') closeRegisterModal();
            if (elements.productModal.style.display === 'block') closeProductModal();
        }
    });

    // Producto
    elements.closeProductModalBtn?.addEventListener('click', closeProductModal);
    elements.productModal?.addEventListener('click', (e) => {
        if (e.target === elements.productModal) closeProductModal();
    });

    // Validación de registro
    document.getElementById('registerForm')?.addEventListener('submit', validateRegisterForm);
}

// === FUNCIONES DE MODAL ===
function openLoginModal() {
    elements.loginModal.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeLoginModal() {
    elements.loginModal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

function openRegisterModal() {
    elements.registerModal.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeRegisterModal() {
    elements.registerModal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

function closeProductModal() {
    elements.productModal.style.display = 'none';
}

// === FUNCIONALIDAD PRINCIPAL ===
function handleSearch() {
    const searchTerm = elements.searchInput?.value.trim().toLowerCase() || '';
    state.filteredProducts = searchTerm
        ? state.products.filter(p => 
            p.name.toLowerCase().includes(searchTerm) ||
            p.description.toLowerCase().includes(searchTerm)
        )
        : state.products;
    renderRecommendedProducts();
}

function handleFilterChange() {
    state.currentCategory = elements.categoryFilter?.value || '';
    state.currentPriceRange = elements.priceFilter?.value || '';
    applyFilters();
}

function applyFilters() {
    let filtered = state.products;

    if (state.currentCategory) {
        filtered = filtered.filter(p => p.category === state.currentCategory);
    }

    if (state.currentPriceRange) {
        filtered = filtered.filter(p => {
            const price = p.price;
            switch(state.currentPriceRange) {
                case '0-50': return price < 50;
                case '50-100': return price >= 50 && price < 100;
                case '100-200': return price >= 100 && price < 200;
                case '200+': return price >= 200;
                default: return true;
            }
        });
    }

    state.filteredProducts = filtered;
    renderRecommendedProducts();
}

function renderRecommendedProducts() {
    const container = elements.recommendationsContainer;
    if (!container) return;

    if (state.filteredProducts.length === 0) {
        container.innerHTML = `
            <div class="empty-recommendations">
                <i class="fas fa-search"></i>
                <h3>No se encontraron productos</h3>
                <p>Intenta con otros términos de búsqueda o ajusta los filtros.</p>
            </div>
        `;
        return;
    }

    container.innerHTML = state.filteredProducts.map(product => `
        <div class="product-card" data-id="${product.id}">
            <div class="product-image">
                <img src="${product.image}" alt="${product.name}" onerror="this.src='https://via.placeholder.com/150?text=Sin+imagen'">
            </div>
            <div class="product-info">
                <h3 class="product-title">${product.name}</h3>
                <div class="product-price">$${product.price.toFixed(2)}</div>
                <div class="product-rating">
                    <div class="stars">${renderStars(product.rating)}</div>
                    <span class="rating-value">${product.rating}/5</span>
                </div>
                <div class="product-features">
                    ${product.features.slice(0, 2).map(f => `
                        <div class="product-feature">
                            <i class="fas fa-check"></i>
                            <span>${f}</span>
                        </div>
                    `).join('')}
                </div>
                <div class="product-actions">
                    <button class="btn btn-primary btn-sm view-product" data-id="${product.id}">
                        <i class="fas fa-eye"></i> Ver Detalles
                    </button>
                    <button class="btn btn-outline btn-sm compare-product" data-id="${product.id}">
                        <i class="fas fa-balance-scale"></i> Comparar
                    </button>
                </div>
            </div>
        </div>
    `).join('');

    // Eventos dinámicos
    document.querySelectorAll('.view-product').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const id = parseInt(e.currentTarget.dataset.id);
            showProductDetails(id);
        });
    });

    document.querySelectorAll('.compare-product').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const id = parseInt(e.currentTarget.dataset.id);
            addToComparison(id);
        });
    });
}

function renderStars(rating) {
    const full = Math.floor(rating);
    const half = rating % 1 >= 0.5;
    const empty = 5 - full - (half ? 1 : 0);
    let stars = '';
    for (let i = 0; i < full; i++) stars += '<i class="fas fa-star"></i>';
    if (half) stars += '<i class="fas fa-star-half-alt"></i>';
    for (let i = 0; i < empty; i++) stars += '<i class="far fa-star"></i>';
    return stars;
}

function showProductDetails(productId) {
    const product = state.products.find(p => p.id === productId);
    if (!product || !elements.modalBody) return;

    elements.modalBody.innerHTML = `
        <div class="product-detail">
            <div class="product-detail-image">
                <img src="${product.image}" alt="${product.name}" onerror="this.src='https://via.placeholder.com/300x200?text=Sin+imagen'">
            </div>
            <div class="product-detail-info">
                <h2>${product.name}</h2>
                <div class="product-detail-price">$${product.price.toFixed(2)}</div>
                <div class="product-detail-rating">
                    <div class="stars">${renderStars(product.rating)}</div>
                    <span class="rating-value">${product.rating}/5</span>
                </div>
                <p class="product-detail-description">${product.description}</p>
                <div class="product-detail-features">
                    <h3>Características principales:</h3>
                    ${product.features.map(f => `
                        <div class="product-detail-feature">
                            <i class="fas fa-check"></i>
                            <span>${f}</span>
                        </div>
                    `).join('')}
                </div>
                <div class="product-detail-actions">
                    <button class="btn btn-primary add-to-comparison" data-id="${product.id}">
                        <i class="fas fa-balance-scale"></i> Agregar a comparación
                    </button>
                    <button class="btn btn-outline">
                        <i class="fas fa-shopping-cart"></i> Comprar ahora
                    </button>
                </div>
            </div>
        </div>
    `;

    document.querySelector('.add-to-comparison')?.addEventListener('click', () => {
        addToComparison(productId);
        closeProductModal();
    });

    elements.productModal.style.display = 'block';
}

function addToComparison(productId) {
    if (state.comparisonProducts.some(p => p.id === productId)) {
        showNotification('⚠️ Este producto ya está en la comparación', 'warning');
        return;
    }

    if (state.comparisonProducts.length >= 4) {
        showNotification('⚠️ Máximo 4 productos para comparar', 'warning');
        return;
    }

    const product = state.products.find(p => p.id === productId);
    if (product) {
        state.comparisonProducts.push(product);
        renderComparison();
        showNotification(`✅ "${product.name}" agregado a la comparación`, 'success');
    }
}

function removeFromComparison(productId) {
    state.comparisonProducts = state.comparisonProducts.filter(p => p.id !== productId);
    renderComparison();
}

function clearComparison() {
    state.comparisonProducts = [];
    renderComparison();
}

function renderComparison() {
    const container = elements.comparisonContainer;
    if (!container) return;

    if (state.comparisonProducts.length === 0) {
        container.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-balance-scale"></i>
                <p>Selecciona productos para comparar sus características</p>
            </div>
        `;
        container.classList.remove('active');
        return;
    }

    container.classList.add('active');
    const allFeatures = [...new Set(state.comparisonProducts.flatMap(p => p.features))];

    container.innerHTML = state.comparisonProducts.map(product => `
        <div class="comparison-product">
            <div class="comparison-product-header">
                <h3 class="comparison-product-title">${product.name}</h3>
                <div class="comparison-product-price">$${product.price.toFixed(2)}</div>
            </div>
            <div class="comparison-product-image">
                <img src="${product.image}" alt="${product.name}" style="width:100%; height:150px; object-fit:contain; margin-bottom:15px;" onerror="this.src='https://via.placeholder.com/150?text=Sin+imagen'">
            </div>
            <div class="comparison-product-rating">
                <div class="stars">${renderStars(product.rating)}</div>
                <span class="rating-value">${product.rating}/5</span>
            </div>
            <div class="comparison-product-features">
                ${allFeatures.map(f => `
                    <div class="comparison-feature">
                        <span class="feature-name">${f}</span>
                        <span class="feature-value">
                            ${product.features.includes(f) ? '<i class="fas fa-check" style="color:#2e33cc;"></i>' : '<i class="fas fa-times" style="color:#e74c3c;"></i>'}
                        </span>
                    </div>
                `).join('')}
            </div>
            <div class="comparison-product-actions">
                <button class="btn btn-outline btn-sm view-product" data-id="${product.id}">
                    <i class="fas fa-eye"></i> Ver Detalles
                </button>
                <button class="btn btn-danger btn-sm remove-comparison" data-id="${product.id}">
                    <i class="fas fa-times"></i> Quitar
                </button>
            </div>
        </div>
    `).join('');

    // Eventos dinámicos
    document.querySelectorAll('.comparison-product .view-product').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const id = parseInt(e.currentTarget.dataset.id);
            showProductDetails(id);
        });
    });

    document.querySelectorAll('.comparison-product .remove-comparison').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const id = parseInt(e.currentTarget.dataset.id);
            removeFromComparison(id);
        });
    });
}

// === VALIDACIÓN DE REGISTRO ===
function validateRegisterForm(e) {
    const password = document.getElementById('reg-password')?.value || '';
    const confirm = document.getElementById('confirm-password')?.value || '';
    const terms = document.querySelector('input[name="terms"]')?.checked || false;

    // Limpiar errores
    document.querySelectorAll('.form-group.error').forEach(el => el.classList.remove('error'));
    document.querySelectorAll('.error-message').forEach(el => el.remove());

    let valid = true;

    if (password !== confirm) {
        showError('confirm-password', 'Las contraseñas no coinciden');
        valid = false;
    }

    if (!terms) {
        showNotification('⚠️ Debes aceptar los Términos y Condiciones', 'warning');
        valid = false;
    }

    if (!valid) e.preventDefault();
}

function showError(fieldId, message) {
    const input = document.getElementById(fieldId);
    const group = input.closest('.form-group');
    group.classList.add('error');
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.style.cssText = 'color:#e74c3c; font-size:0.85rem; margin-top:5px;';
    errorDiv.textContent = message;
    group.appendChild(errorDiv);
}

// === NOTIFICACIONES ===
function showNotification(message, type = 'info') {
    const colors = {
        success: '#27ae60',
        warning: '#f39c12',
        error: '#e74c3c',
        info: '#2e33cc'
    };
    
    const bgColor = colors[type] || colors.info;
    const icon = type === 'success' ? 'check-circle' : 
                 type === 'warning' ? 'exclamation-triangle' : 
                 type === 'error' ? 'times-circle' : 'info-circle';

    const notif = document.createElement('div');
    notif.innerHTML = `
        <div style="
            position:fixed; top:20px; right:20px; 
            background:${bgColor}; color:white; padding:15px 20px; 
            border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.15);
            z-index:1100; animation:slideIn 0.3s;
            display:flex; align-items:center; gap:10px;
            font-weight:500;
        ">
            <i class="fas fa-${icon}"></i>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(notif);
    
    setTimeout(() => {
        notif.firstChild.style.animation = 'slideOut 0.3s forwards';
        setTimeout(() => notif.remove(), 300);
    }, 3000);
}

// Animaciones CSS
(function() {
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes slideOut { from { transform: translateX(0); opacity: 1; } to { transform: translateX(100%); opacity: 0; } }
        .form-group.error input { border-color: #e74c3c; }
    `;
    document.head.appendChild(style);
})();
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("registerForm");

    form.addEventListener("submit", (e) => {
        e.preventDefault(); // Evita enviar mientras validamos

        // Obtener valores
        const nombre = document.getElementById("nombre").value.trim();
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value.trim();
        const confirmPassword = document.getElementById("confirmPassword").value.trim();
        const terms = form.querySelector("input[type='checkbox']");

        // Validaciones
        if (nombre.length < 3) {
            return mostrarError("El nombre es demasiado corto.");
        }

        if (!validarEmail(email)) {
            return mostrarError("El correo electrónico no es válido.");
        }

        if (password.length < 6) {
            return mostrarError("La contraseña debe tener al menos 6 caracteres.");
        }

        if (password !== confirmPassword) {
            return mostrarError("Las contraseñas no coinciden.");
        }

        if (!terms.checked) {
            return mostrarError("Debes aceptar los términos y condiciones.");
        }

        // Si todo está OK -> enviamos el formulario
        form.submit();
    });
});

// Función para validar email
function validarEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

// Función para mostrar errores
function mostrarError(mensaje) {
    let errorBox = document.getElementById("errorBox");

    if (!errorBox) {
        errorBox = document.createElement("div");
        errorBox.id = "errorBox";
        errorBox.style.background = "#ffdddd";
        errorBox.style.border = "1px solid #ff6b6b";
        errorBox.style.padding = "10px";
        errorBox.style.marginBottom = "15px";
        errorBox.style.color = "#a50000";
        errorBox.style.borderRadius = "5px";
        errorBox.style.fontSize = "14px";
        document.querySelector(".register-box").prepend(errorBox);
    }

    errorBox.textContent = mensaje;
}

// === CARGAR DATOS DESDE JSON (sin PHP ni servidor) ===
async function cargarDatosTienda(ruta) {
    try {
        const response = await fetch(ruta);
        if (!response.ok) throw new Error(`HTTP ${response.status}`);
        return await response.json();
    } catch (error) {
        console.warn(`⚠️ No se pudo cargar ${ruta}:`, error.message);
        return []; // fallback vacío
    }
}

// === Cargar y combinar datos de todas las tiendas ===
async function cargarProductosReales() {
    const bases = [
        { tienda: 'walmart', ruta: '../scr/tiendas/data/walmart_papel.json' },
        { tienda: 'chedraui', ruta: '../scr/tiendas/data/chedraui_papel.json' },
        { tienda: 'soriana', ruta: '../scr/tiendas/data/soriana_papel.json' }
    ];

    const promesas = bases.map(async base => {
        const datos = await cargarDatosTienda(base.ruta);
        return Array.isArray(datos) ? datos.map(p => ({ ...p, tienda: base.tienda })) : [];
    });

    const resultados = await Promise.all(promesas);
    return resultados.flat();
}

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("registerForm");

    form.addEventListener("submit", function (e) {
        e.preventDefault(); // Evita envío hasta validar

        // Obtener valores
        const nombre = document.getElementById("nombre").value.trim();
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirmPassword").value;

        // Validar campos vacíos
        if (!nombre || !email || !password || !confirmPassword) {
            mostrarAlerta("Por favor, completa todos los campos.");
            return;
        }

        // Validar email
        if (!validarEmail(email)) {
            mostrarAlerta("Por favor, ingresa un correo electrónico válido.");
            return;
        }

        // Validar longitud de la contraseña
        if (password.length < 6) {
            mostrarAlerta("La contraseña debe tener al menos 6 caracteres.");
            return;
        }

        // Validar coincidencia de contraseñas
        if (password !== confirmPassword) {
            mostrarAlerta("Las contraseñas no coinciden.");
            return;
        }

        // Si todo está bien, enviar formulario
        form.submit();
    });
});


// Función para validar email
function validarEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}


// Función para mostrar alertas bonitas (puedes personalizar)
function mostrarAlerta(mensaje) {
    let alerta = document.getElementById("alerta-registro");

    if (!alerta) {
        alerta = document.createElement("div");
        alerta.id = "alerta-registro";
        alerta.style.background = "#ff4d4d";
        alerta.style.color = "white";
        alerta.style.padding = "10px";
        alerta.style.marginTop = "15px";
        alerta.style.borderRadius = "5px";
        alerta.style.textAlign = "center";
        alerta.style.fontWeight = "bold";
        alerta.style.animation = "fadeIn 0.3s ease";
        document.querySelector(".register-box").prepend(alerta);
    }

    alerta.textContent = mensaje;

    // Desaparece después de 3 segundos
    setTimeout(() => {
        alerta.remove();
    }, 3000);
}

