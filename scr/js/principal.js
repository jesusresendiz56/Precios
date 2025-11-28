const sampleProducts = [
    // === Electrónicos ===
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
        ],
        brand: "XYZ",
        stores: ["TechMall", "ElectroPlus", "MegaStore"]
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
        ],
        brand: "NovaTech",
        stores: ["PCWorld", "MegaStore", "OfficeHub"]
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
        ],
        brand: "SonicGear",
        stores: ["AudioMax", "TechMall", "ElectroPlus"]
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
        ],
        brand: "TabWorks",
        stores: ["PCWorld", "MegaStore"]
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
        ],
        brand: "VisionPro",
        stores: ["ElectroPlus", "MegaStore", "HomeCenter"]
    },
    {
        id: 6,
        name: "Consola GameStation X",
        category: "electronics",
        price: 449,
        rating: 4.9,
        image: "https://hips.hearstapps.com/hmg-prod/images/xbox-series-s-x-1600085626.jpg?crop=0.75xw:1xh;center,top&resize=1200:*",
        description: "Consola de última generación con gráficos 4K y carga ultrarrápida.",
        features: [
            "Procesador Zen 2",
            "SSD 825GB",
            "Ray tracing",
            "Controlador háptico"
        ],
        brand: "GameStation",
        stores: ["GameHub", "TechMall", "MegaStore"]
    },
    {
        id: 7,
        name: "Reloj Inteligente FitTrack",
        category: "electronics",
        price: 199,
        rating: 4.4,
        image: "https://selectsound.com.mx/cdn/shop/products/smartwatch-multi-sport-horus-zeit-550985_1200x1200.png?v=1720801409",
        description: "Reloj con monitoreo de salud, GPS y notificaciones inteligentes.",
        features: [
            "Monitor de ritmo cardíaco",
            "GPS integrado",
            "Resistente al agua 5ATM",
            "Batería 3 días"
        ],
        brand: "FitTrack",
        stores: ["TechMall", "SportsLife", "MegaStore"]
    },
    {
        id: 8,
        name: "Drone SkyFly Pro",
        category: "electronics",
        price: 799,
        rating: 4.5,
        image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSBhnnyzTd3Vf5554XZVJLaVZDwp0F3rIqjAA&s",
        description: "Drone con cámara 4K, estabilización y vuelo autónomo.",
        features: [
            "Cámara 4K 30fps",
            "Estabilización de 3 ejes",
            "30 min de vuelo",
            "Modo seguimiento automático"
        ],
        brand: "SkyFly",
        stores: ["DroneWorld", "TechMall"]
    },
    {
        id: 9,
        name: "Impresora Multifuncional",
        category: "electronics",
        price: 129,
        rating: 4.0,
        image: "https://m.media-amazon.com/images/I/61Kv6U3uGpL._AC_SL1500_.jpg",
        description: "Impresora láser color con escáner y copiadora, ideal para oficina.",
        features: [
            "Impresión/escaneo/copia",
            "Conexión Wi-Fi",
            "Velocidad 20ppm",
            "Alimentador automático"
        ],
        brand: "PrintPro",
        stores: ["OfficeHub", "MegaStore"]
    },
    {
        id: 10,
        name: "Proyector HD Mini",
        category: "electronics",
        price: 299,
        rating: 4.1,
        image: "https://m.media-amazon.com/images/I/71zXlnG0K5L._AC_SL1500_.jpg",
        description: "Proyector portátil HD compatible con HDMI, USB y streaming.",
        features: [
            "Resolución 1080p",
            "Brillo 3000 lúmenes",
            "Altavoz integrado",
            "Conectividad Bluetooth"
        ],
        brand: "LumaTech",
        stores: ["TechMall", "HomeCenter"]
    },

    // === Deportes ===
    {
        id: 11,
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
        ],
        brand: "RunFlex",
        stores: ["SportsLife", "MegaStore", "FootHub"]
    },
    {
        id: 12,
        name: "Mancuerna Ajustable 20kg",
        category: "sports",
        price: 75,
        rating: 4.6,
        image: "https://m.media-amazon.com/images/I/71jDy2nQJlL._AC_SL1500_.jpg",
        description: "Mancuerna regulable con sistema de cambio rápido de peso.",
        features: [
            "Rango 2–20kg por unidad",
            "Ajuste en segundos",
            "Mango ergonómico antideslizante",
            "Material recubierto de goma"
        ],
        brand: "IronCore",
        stores: ["GymPro", "SportsLife"]
    },
    {
        id: 13,
        name: "Bicicleta Urbana EcoRide",
        category: "sports",
        price: 420,
        rating: 4.3,
        image: "https://assets.bikeexchange.com/2022/10/urban-bike-1024x683.jpg",
        description: "Bicicleta plegable ideal para ciudad, ligera y con cambio Shimano.",
        features: [
            "Marco de aluminio",
            "8 velocidades Shimano",
            "Ruedas 20\"",
            "Plegable en 15 segundos"
        ],
        brand: "EcoRide",
        stores: ["BikeWorld", "SportsLife", "GreenHub"]
    },
    {
        id: 14,
        name: "Colchoneta Yoga Eco",
        category: "sports",
        price: 35,
        rating: 4.7,
        image: "https://m.media-amazon.com/images/I/81y6YxVfPQL._AC_SL1500_.jpg",
        description: "Colchoneta antideslizante, ecológica y extra gruesa para yoga y pilates.",
        features: [
            "Grosor 6mm",
            "Material TPE biodegradable",
            "Superficie texturizada",
            "Libre de látex y PVC"
        ],
        brand: "ZenMat",
        stores: ["SportsLife", "WellnessShop"]
    },
    {
        id: 15,
        name: "Balón de Fútbol Profesional",
        category: "sports",
        price: 45,
        rating: 4.8,
        image: "https://m.media-amazon.com/images/I/71xP4vJYDzL._AC_SL1500_.jpg",
        description: "Balón oficial FIFA Quality Pro para entrenamiento y competición.",
        features: [
            "Tamaño 5",
            "Cámara de butilo",
            "Costuras termoselladas",
            "Resistente a la humedad"
        ],
        brand: "StrikeBall",
        stores: ["SportsLife", "FootHub", "GameHub"]
    },

    // === Hogar ===
    {
        id: 16,
        name: "Aspiradora Robot CleanBot",
        category: "home",
        price: 249,
        rating: 4.5,
        image: "https://m.media-amazon.com/images/I/71zD+YV8QQL._AC_SL1500_.jpg",
        description: "Aspiradora autónoma con mapeo láser y control por app.",
        features: [
            "Mapeo 3D LIDAR",
            "Filtro HEPA",
            "Succión 2500Pa",
            "Programable por zonas"
        ],
        brand: "CleanBot",
        stores: ["HomeCenter", "TechMall", "MegaStore"]
    },
    {
        id: 17,
        name: "Set de Ollas Antiadherentes",
        category: "home",
        price: 65,
        rating: 4.2,
        image: "https://m.media-amazon.com/images/I/71xN1FQkZqL._AC_SL1500_.jpg",
        description: "Juego de 5 ollas con base de aluminio y recubrimiento cerámico.",
        features: [
            "Recubrimiento cerámico",
            "Apto para inducción",
            "Mango ergonómico",
            "Lavavajillas seguro"
        ],
        brand: "KitchenPro",
        stores: ["HomeCenter", "MegaStore"]
    },
    {
        id: 18,
        name: "Cafetera Espresso Automática",
        category: "home",
        price: 189,
        rating: 4.6,
        image: "https://m.media-amazon.com/images/I/71N5sJZrO+L._AC_SL1500_.jpg",
        description: "Cafetera con molinillo integrado y sistema de leche automático.",
        features: [
            "15 bares de presión",
            "Molinillo ajustable",
            "Vaporizador automático",
            "Depósito 1.8L"
        ],
        brand: "BrewMaster",
        stores: ["HomeCenter", "MegaStore", "OfficeHub"]
    },
    {
        id: 19,
        name: "Silla Ergonómica Oficina",
        category: "home",
        price: 159,
        rating: 4.4,
        image: "https://m.media-amazon.com/images/I/71i+-V+g0QL._AC_SL1500_.jpg",
        description: "Silla de oficina con soporte lumbar ajustable y reposabrazos 4D.",
        features: [
            "Reposacabezas regulable",
            "Soporte lumbar dinámico",
            "Base de aluminio",
            "Ruedas silenciosas"
        ],
        brand: "ErgoWork",
        stores: ["OfficeHub", "HomeCenter"]
    },
    {
        id: 20,
        name: "Lámpara Inteligente RGB",
        category: "home",
        price: 42,
        rating: 4.3,
        image: "https://m.media-amazon.com/images/I/61h+I2VhPdL._AC_SL1500_.jpg",
        description: "Lámpara LED con control por app y sincronización con música.",
        features: [
            "16 millones de colores",
            "Programación horaria",
            "Modo atardecer/amanecer",
            "Compatible con Alexa/Google"
        ],
        brand: "LumaHome",
        stores: ["HomeCenter", "TechMall"]
    },

    // === Belleza ===
    {
        id: 21,
        name: "Secador de Cabello Profesional",
        category: "beauty",
        price: 89,
        rating: 4.5,
        image: "https://m.media-amazon.com/images/I/61qz7kR+QaL._AC_SL1500_.jpg",
        description: "Secador con tecnología iónica y 3 ajustes de temperatura y flujo.",
        features: [
            "Motor AC de larga vida",
            "Tecnología iónica",
            "Boquilla concentradora",
            "2 años de garantía"
        ],
        brand: "HairPro",
        stores: ["BeautyHub", "MegaStore"]
    },
    {
        id: 22,
        name: "Crema Hidratante Facial SPF50",
        category: "beauty",
        price: 28,
        rating: 4.7,
        image: "https://m.media-amazon.com/images/I/71JU2eX+DqL._SL1500_.jpg",
        description: "Hidratante no grasa con protección solar y antioxidantes.",
        features: [
            "Factor SPF50+",
            "Fórmula no comedogénica",
            "Con vitamina E y ácido hialurónico",
            "Apto para piel sensible"
        ],
        brand: "DermaCare",
        stores: ["BeautyHub", "PharmaPlus", "MegaStore"]
    },
    {
        id: 23,
        name: "Plancha de Cabello Cerámica",
        category: "beauty",
        price: 49,
        rating: 4.4,
        image: "https://m.media-amazon.com/images/I/61Vf3jvGKPL._AC_SL1500_.jpg",
        description: "Plancha con placas de cerámica y ajuste digital de temperatura.",
        features: [
            "Placas de turmalina",
            "Rango 120–230°C",
            "Cable giratorio 360°",
            "Calentamiento en 15s"
        ],
        brand: "StylePro",
        stores: ["BeautyHub", "MegaStore"]
    },

    // === Libros y Oficina ===
    {
        id: 24,
        name: "Cuaderno Inteligente Reutilizable",
        category: "office",
        price: 32,
        rating: 4.6,
        image: "https://m.media-amazon.com/images/I/71K7Q4FpvzL._AC_SL1500_.jpg",
        description: "Cuaderno con páginas borrables y app para escanear notas.",
        features: [
            "Tinta borrable con agua",
            "App integrada (iOS/Android)",
            "Cubierta impermeable",
            "80 páginas"
        ],
        brand: "SmartNote",
        stores: ["OfficeHub", "MegaStore"]
    },
    {
        id: 25,
        name: "Libro: 'Hábitos Atómicos'",
        category: "books",
        price: 18,
        rating: 4.9,
        image: "https://m.media-amazon.com/images/I/81wgcld4wxL._SL1500_.jpg",
        description: "Guía práctica para construir buenos hábitos y romper los malos.",
        features: [
            "Autor: James Clear",
            "Edición tapa dura",
            "Incluye resúmenes al final",
            "Traducción al español"
        ],
        brand: "Editorial Éxito",
        stores: ["LibroWorld", "MegaStore", "OfficeHub"]
    },
    {
        id: 26,
        name: "Bolígrafo Premium Metal",
        category: "office",
        price: 22,
        rating: 4.8,
        image: "https://m.media-amazon.com/images/I/61xKdJ4K4eL._AC_SL1200_.jpg",
        description: "Bolígrafo de aluminio con recarga de gel y empaque regalo incluido.",
        features: [
            "Cuerpo de aluminio cepillado",
            "Recarga de gel negra",
            "Diseño antideslizante",
            "Empaque de regalo"
        ],
        brand: "InkLuxe",
        stores: ["OfficeHub", "GiftShop"]
    },

    // === Jardín y Mascotas ===
    {
        id: 27,
        name: "Comedero Automático para Mascotas",
        category: "pets",
        price: 69,
        rating: 4.3,
        image: "https://m.media-amazon.com/images/I/71F5J+VvRIL._AC_SL1500_.jpg",
        description: "Dispensador programable con grabación de voz y batería de respaldo.",
        features: [
            "Programable hasta 4 comidas/día",
            "Capacidad 4L",
            "Batería de respaldo",
            "Grabación de 10s de voz"
        ],
        brand: "PetCare",
        stores: ["PetWorld", "MegaStore"]
    },
    {
        id: 28,
        name: "Kit de Riego Automático",
        category: "garden",
        price: 55,
        rating: 4.2,
        image: "https://m.media-amazon.com/images/I/81QZb0XySQL._AC_SL1500_.jpg",
        description: "Sistema de goteo programable para macetas y huertos pequeños.",
        features: [
            "Temporizador digital 7 días",
            "20 emisores ajustables",
            "Fácil instalación sin herramientas",
            "Funciona con batería o USB"
        ],
        brand: "GreenDrop",
        stores: ["GreenHub", "HomeCenter"]
    },

    // === Otros ===
    {
        id: 29,
        name: "Mochila Antirrobo para Laptop",
        category: "accessories",
        price: 59,
        rating: 4.5,
        image: "https://m.media-amazon.com/images/I/71uXz7+QnFL._AC_SL1500_.jpg",
        description: "Mochila ligera con cierre oculto, puerto USB y compartimento acolchado.",
        features: [
            "Compartimento para laptop 15.6\"",
            "Puerto USB externo",
            "Material resistente al agua",
            "Cierre trasero antirrobo"
        ],
        brand: "SafePack",
        stores: ["MegaStore", "OfficeHub", "TravelGear"]
    },
    {
        id: 30,
        name: "Power Bank 20000mAh",
        category: "accessories",
        price: 45,
        rating: 4.6,
        image: "https://m.media-amazon.com/images/I/71xHRYJ7DIL._AC_SL1500_.jpg",
        description: "Batería externa con carga rápida y 3 puertos de salida.",
        features: [
            "20000mAh capacidad",
            "Carga rápida 18W",
            "Puertos: USB-C, USB-A x2",
            "Pantalla LED de batería"
        ],
        brand: "PowerMax",
        stores: ["TechMall", "MegaStore", "TravelGear"]
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
                        Comparar
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
                        Agregar a comparación
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