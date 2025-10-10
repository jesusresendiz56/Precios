// Datos de ejemplo para productos
const sampleProducts = [
    {
        id: 1,
        name: "Smartphone XYZ Pro",
        category: "electronics",
        price: 699,
        rating: 4.5,
        image: "https://via.placeholder.com/300x200?text=Smartphone",
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
        image: "https://via.placeholder.com/300x200?text=Laptop",
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
        image: "https://via.placeholder.com/300x200?text=Auriculares",
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
        image: "https://via.placeholder.com/300x200?text=Tablet",
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
        image: "https://via.placeholder.com/300x200?text=Smart+TV",
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
        image: "https://via.placeholder.com/300x200?text=Zapatillas",
        description: "Zapatillas cómodas para running con tecnología de amortiguación avanzada.",
        features: [
            "Amortiguación reactiva",
            "Material transpirable",
            "Suela antideslizante",
            "Peso ligero"
        ]
    }
];

// Estado de la aplicación
let state = {
    products: sampleProducts,
    filteredProducts: sampleProducts,
    comparisonProducts: [],
    currentCategory: '',
    currentPriceRange: ''
};

// Elementos del DOM
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
    closeModal: document.querySelector('.close')
};

// Inicialización
document.addEventListener('DOMContentLoaded', function() {
    initApp();
});

function initApp() {
    // Cargar productos recomendados
    renderRecommendedProducts();
    
    // Configurar event listeners
    setupEventListeners();
}

function setupEventListeners() {
    // Búsqueda
    elements.searchBtn.addEventListener('click', handleSearch);
    elements.searchInput.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            handleSearch();
        }
    });
    
    // Filtros
    elements.categoryFilter.addEventListener('change', handleFilterChange);
    elements.priceFilter.addEventListener('change', handleFilterChange);
    
    // Comparación
    elements.clearComparisonBtn.addEventListener('click', clearComparison);
    
    // Modal
    elements.closeModal.addEventListener('click', closeProductModal);
    window.addEventListener('click', function(e) {
        if (e.target === elements.productModal) {
            closeProductModal();
        }
    });
}

function handleSearch() {
    const searchTerm = elements.searchInput.value.trim().toLowerCase();
    
    if (searchTerm) {
        state.filteredProducts = state.products.filter(product => 
            product.name.toLowerCase().includes(searchTerm) ||
            product.description.toLowerCase().includes(searchTerm)
        );
    } else {
        state.filteredProducts = state.products;
    }
    
    renderRecommendedProducts();
}

function handleFilterChange() {
    state.currentCategory = elements.categoryFilter.value;
    state.currentPriceRange = elements.priceFilter.value;
    
    applyFilters();
}

function applyFilters() {
    let filtered = state.products;
    
    // Filtrar por categoría
    if (state.currentCategory) {
        filtered = filtered.filter(product => product.category === state.currentCategory);
    }
    
    // Filtrar por rango de precio
    if (state.currentPriceRange) {
        filtered = filtered.filter(product => {
            switch(state.currentPriceRange) {
                case '0-50':
                    return product.price < 50;
                case '50-100':
                    return product.price >= 50 && product.price < 100;
                case '100-200':
                    return product.price >= 100 && product.price < 200;
                case '200+':
                    return product.price >= 200;
                default:
                    return true;
            }
        });
    }
    
    state.filteredProducts = filtered;
    renderRecommendedProducts();
}

function renderRecommendedProducts() {
    const container = elements.recommendationsContainer;
    
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
                <img src="${product.image}" alt="${product.name}">
            </div>
            <div class="product-info">
                <h3 class="product-title">${product.name}</h3>
                <div class="product-price">$${product.price}</div>
                <div class="product-rating">
                    <div class="stars">
                        ${renderStars(product.rating)}
                    </div>
                    <span class="rating-value">${product.rating}/5</span>
                </div>
                <div class="product-features">
                    ${product.features.slice(0, 2).map(feature => `
                        <div class="product-feature">
                            <i class="fas fa-check"></i>
                            <span>${feature}</span>
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
    
    // Agregar event listeners a los botones de los productos
    document.querySelectorAll('.view-product').forEach(button => {
        button.addEventListener('click', function() {
            const productId = parseInt(this.getAttribute('data-id'));
            showProductDetails(productId);
        });
    });
    
    document.querySelectorAll('.compare-product').forEach(button => {
        button.addEventListener('click', function() {
            const productId = parseInt(this.getAttribute('data-id'));
            addToComparison(productId);
        });
    });
}

function renderStars(rating) {
    const fullStars = Math.floor(rating);
    const halfStar = rating % 1 >= 0.5;
    const emptyStars = 5 - fullStars - (halfStar ? 1 : 0);
    
    let starsHTML = '';
    
    // Estrellas llenas
    for (let i = 0; i < fullStars; i++) {
        starsHTML += '<i class="fas fa-star"></i>';
    }
    
    // Media estrella
    if (halfStar) {
        starsHTML += '<i class="fas fa-star-half-alt"></i>';
    }
    
    // Estrellas vacías
    for (let i = 0; i < emptyStars; i++) {
        starsHTML += '<i class="far fa-star"></i>';
    }
    
    return starsHTML;
}

function showProductDetails(productId) {
    const product = state.products.find(p => p.id === productId);
    
    if (!product) return;
    
    elements.modalBody.innerHTML = `
        <div class="product-detail">
            <div class="product-detail-image">
                <img src="${product.image}" alt="${product.name}">
            </div>
            <div class="product-detail-info">
                <h2>${product.name}</h2>
                <div class="product-detail-price">$${product.price}</div>
                <div class="product-detail-rating">
                    <div class="stars">
                        ${renderStars(product.rating)}
                    </div>
                    <span class="rating-value">${product.rating}/5</span>
                </div>
                <p class="product-detail-description">${product.description}</p>
                <div class="product-detail-features">
                    <h3>Características principales:</h3>
                    ${product.features.map(feature => `
                        <div class="product-detail-feature">
                            <i class="fas fa-check"></i>
                            <span>${feature}</span>
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
    
    // Agregar event listener al botón de comparación en el modal
    document.querySelector('.add-to-comparison').addEventListener('click', function() {
        addToComparison(productId);
        closeProductModal();
    });
    
    elements.productModal.style.display = 'block';
}

function closeProductModal() {
    elements.productModal.style.display = 'none';
}

function addToComparison(productId) {
    // Verificar si el producto ya está en la comparación
    if (state.comparisonProducts.some(p => p.id === productId)) {
        alert('Este producto ya está en la comparación');
        return;
    }
    
    // Verificar límite de productos para comparar (máximo 4)
    if (state.comparisonProducts.length >= 4) {
        alert('Solo puedes comparar hasta 4 productos a la vez');
        return;
    }
    
    const product = state.products.find(p => p.id === productId);
    
    if (product) {
        state.comparisonProducts.push(product);
        renderComparison();
        
        // Mostrar mensaje de confirmación
        showNotification(`"${product.name}" agregado a la comparación`);
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
    
    // Encontrar todas las características únicas de los productos
    const allFeatures = [...new Set(state.comparisonProducts.flatMap(p => p.features))];
    
    container.innerHTML = state.comparisonProducts.map(product => `
        <div class="comparison-product">
            <div class="comparison-product-header">
                <h3 class="comparison-product-title">${product.name}</h3>
                <div class="comparison-product-price">$${product.price}</div>
            </div>
            <div class="comparison-product-image">
                <img src="${product.image}" alt="${product.name}" style="width: 100%; height: 150px; object-fit: contain; margin-bottom: 15px;">
            </div>
            <div class="comparison-product-rating">
                <div class="stars">
                    ${renderStars(product.rating)}
                </div>
                <span class="rating-value">${product.rating}/5</span>
            </div>
            <div class="comparison-product-features">
                ${allFeatures.map(feature => `
                    <div class="comparison-feature">
                        <span class="feature-name">${feature}</span>
                        <span class="feature-value">
                            ${product.features.includes(feature) ? '<i class="fas fa-check" style="color: var(--secondary);"></i>' : '<i class="fas fa-times" style="color: var(--danger);"></i>'}
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
    
    // Agregar event listeners a los botones de la comparación
    document.querySelectorAll('.comparison-product .view-product').forEach(button => {
        button.addEventListener('click', function() {
            const productId = parseInt(this.getAttribute('data-id'));
            showProductDetails(productId);
        });
    });
    
    document.querySelectorAll('.comparison-product .remove-comparison').forEach(button => {
        button.addEventListener('click', function() {
            const productId = parseInt(this.getAttribute('data-id'));
            removeFromComparison(productId);
        });
    });
}

function showNotification(message) {
    // Crear elemento de notificación
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-check-circle"></i>
            <span>${message}</span>
        </div>
    `;
    
    // Estilos para la notificación
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: var(--secondary);
        color: white;
        padding: 15px 20px;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        z-index: 1000;
        animation: slideIn 0.3s ease-out;
    `;
    
    document.body.appendChild(notification);
    
    // Remover la notificación después de 3 segundos
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-in';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

// Agregar estilos de animación para las notificaciones
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);