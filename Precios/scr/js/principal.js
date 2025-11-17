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
    // ❌ registerModal: document.getElementById('register-modal'), → eliminado
    openLoginModalBtn: document.getElementById('open-login-modal'),
    // ❌ openRegisterModalBtn: document.getElementById('open-register-modal'),
    closeLoginModalBtn: document.querySelector('#login-modal .close'),
    // ❌ closeRegisterModalBtn: document.querySelector('#register-modal .close'),
    closeProductModalBtn: document.querySelector('#product-modal .close'),
    // ❌ switchToRegisterLink: document.getElementById('switch-to-register'),
    switchToLoginLink: document.getElementById('switch-to-login')
};

// === INICIALIZACIÓN ===
document.addEventListener('DOMContentLoaded', function() {
    initApp();
    setupSplashAndHeader();
    handleUrlParams(); // ← para abrir login automáticamente si hay ?open=login
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

    // 🚫 Registro: ya no hay modal → ¡eliminado totalmente!

    // Cambio entre modales (solo login queda)
    // elements.switchToRegisterLink?.addEventListener(...) → eliminado
    elements.switchToLoginLink?.addEventListener('click', (e) => {
        e.preventDefault();
        closeRegisterModal(); // por si acaso (fallback)
        openLoginModal();
    });

    // Tecla Esc
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            if (elements.loginModal?.style.display === 'block') closeLoginModal();
            if (elements.productModal?.style.display === 'block') closeProductModal();
        }
    });

    // Producto
    elements.closeProductModalBtn?.addEventListener('click', closeProductModal);
    elements.productModal?.addEventListener('click', (e) => {
        if (e.target === elements.productModal) closeProductModal();
    });

    // Validación de registro (solo en register.html → no aquí)
}

// === FUNCIONES DE MODAL ===
function openLoginModal() {
    if (elements.loginModal) {
        elements.loginModal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
}

function closeLoginModal() {
    if (elements.loginModal) {
        elements.loginModal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// 🚫 Eliminamos openRegisterModal y closeRegisterModal (no se usan)

function closeRegisterModal() {
    // Fallback por compatibilidad con switch-to-login
    const registerModal = document.getElementById('register-modal');
    if (registerModal) registerModal.style.display = 'none';
}

function closeProductModal() {
    if (elements.productModal) {
        elements.productModal.style.display = 'none';
    }
}

// === FUNCIONES PARA REDIRECCIÓN POR URL ===
function handleUrlParams() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('open') === 'login') {
        setTimeout(() => {
            // ✅ Primero: ocultar splash screen SI existe
            const splashScreen = document.getElementById('splash-screen');
            const mainHeader = document.getElementById('main-header');
            if (splashScreen && !splashScreen.classList.contains('splash-hidden')) {
                splashScreen.classList.add('splash-hidden');
                if (mainHeader) {
                    mainHeader.classList.remove('initial');
                    mainHeader.classList.add('scrolled');
                }
            }

            // ✅ Luego: abrir login
            openLoginModal();

            // ✅ Limpiar URL opcionalmente
            history.replaceState(null, '', window.location.pathname);
        }, 300);
    }
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
                <img src="../scr/img/logo/logo.png" alt="ItemWise Logo" class="logo-img">
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

// Animaciones CSS dinámicas
(function() {
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes slideOut { from { transform: translateX(0); opacity: 1; } to { transform: translateX(100%); opacity: 0; } }
    `;
    document.head.appendChild(style);
})();