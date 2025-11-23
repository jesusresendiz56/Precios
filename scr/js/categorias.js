// Datos de categorías
const categories = [
    {
        id: "electronics",
        name: "Electrónica",
        image: "../img/categorias/electronica.png", // Ajusta la ruta según tu estructura
        description: "Smartphones, laptops, tablets y más"
    },
    {
        id: "home",
        name: "Hogar",
        image: "../img/categorias/hogar.png",
        description: "Electrodomésticos y decoración"
    },
    {
        id: "fashion",
        name: "Moda",
        image: "../img/categorias/moda.png",
        description: "Ropa, calzado y accesorios"
    },
    {
        id: "sports",
        name: "Deportes",
        image: "../img/categorias/deportes.png",
        description: "Equipamiento y ropa deportiva"
    },
    {
        id: "beauty",
        name: "Belleza",
        image: "../img/categorias/belleza.png",
        description: "Cuidado personal y cosméticos"
    },
    {
        id: "toys",
        name: "Juguetes",
        image: "../img/categorias/juguetes.png",
        description: "Para niños y coleccionistas"
    }
];

// Elementos del DOM
const categoriasGrid = document.getElementById('categoriasGrid');

// Renderizar categorías
function renderCategories() {
    if (!categoriasGrid) return;

    categoriasGrid.innerHTML = categories.map(category => `
        <div class="category-card" data-id="${category.id}">
            <div class="category-image">
                <img src="${category.image}" alt="${category.name}">
            </div>
            <div class="category-info">
                <h3>${category.name}</h3>
                <p>${category.description}</p>
                <!-- Opcional: botón para ver productos de la categoría -->
                <!-- <a href="#" class="category-btn">Ver Productos</a> -->
            </div>
        </div>
    `).join('');

    // Agregar event listeners a las tarjetas
    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-id');
            alert(`Has seleccionado la categoría: ${categoryId}`);
            // Aquí puedes redirigir a una página de productos por categoría
            // window.location.href = `productos.html?categoria=${categoryId}`;
        });
    });
}

// Inicialización
document.addEventListener('DOMContentLoaded', function() {
    renderCategories();
});