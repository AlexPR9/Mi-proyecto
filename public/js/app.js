const API_URL = "http://localhost/mi-proyecto/public/index.php";

// Variable para controlar si las listas están visibles
let categoriasVisibles = false;
let productosVisibles = false;

// Obtener categorías
function obtenerCategorias() {
    fetch(`${API_URL}/categorias`)
        .then(response => response.json())
        .then(data => {
            let lista = document.getElementById("categorias-lista");
            lista.innerHTML = "";
            
            if (data.length === 0) {
                lista.innerHTML = `<li class="list-group-item text-center">No hay categorías disponibles.</li>`;
            } else {
                data.forEach(categoria => {
                    lista.innerHTML += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>${categoria.nombre}</strong>: ${categoria.descripcion}
                            </div>
                            <button class="btn btn-danger btn-sm" onclick="eliminarCategoria(${categoria.id})">Eliminar</button>
                        </li>`;
                });
            }

            // Mostrar botón de ocultar solo si hay datos
            document.getElementById("ocultarCategorias").classList.remove("d-none");
            categoriasVisibles = true;
        });
}

// Ocultar categorías
function ocultarCategorias() {
    if (categoriasVisibles) {
        document.getElementById("categorias-lista").innerHTML = "";
        document.getElementById("ocultarCategorias").classList.add("d-none");
        categoriasVisibles = false;
    }
}

// Obtener productos
function obtenerProductos() {
    fetch(`${API_URL}/productos`)
        .then(response => response.json())
        .then(data => {
            let lista = document.getElementById("productos-lista");
            lista.innerHTML = "";
            
            if (data.length === 0) {
                lista.innerHTML = `<li class="list-group-item text-center">No hay productos disponibles.</li>`;
            } else {
                data.forEach(producto => {
                    lista.innerHTML += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>${producto.nombre}</strong>: ${producto.descripcion}, Precio: $${producto.precio}
                            </div>
                            <button class="btn btn-danger btn-sm" onclick="eliminarProducto(${producto.id})">Eliminar</button>
                        </li>`;
                });
            }

            // Mostrar botón de ocultar solo si hay datos
            document.getElementById("ocultarProductos").classList.remove("d-none");
            productosVisibles = true;
        });
}

// Ocultar productos
function ocultarProductos() {
    if (productosVisibles) {
        document.getElementById("productos-lista").innerHTML = "";
        document.getElementById("ocultarProductos").classList.add("d-none");
        productosVisibles = false;
    }
}

// Crear categoría
function crearCategoria() {
    const nombre = document.getElementById("nombre-categoria").value;
    const descripcion = document.getElementById("descripcion-categoria").value;

    fetch(`${API_URL}/categorias`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ nombre, descripcion })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.mensaje);
        obtenerCategorias();
    });
}

// Eliminar categoría
function eliminarCategoria(id) {
    fetch(`${API_URL}/categorias?id=${id}`, {
        method: "DELETE"
    })
    .then(response => response.json())
    .then(data => {
        alert(data.mensaje);
        obtenerCategorias();
    });
}

// Crear producto
function crearProducto() {
    const nombre = document.getElementById("nombre-producto").value;
    const descripcion = document.getElementById("descripcion-producto").value;
    const precio = parseFloat(document.getElementById("precio-producto").value);
    const categoria_id = parseInt(document.getElementById("categoria-id-producto").value);

    fetch(`${API_URL}/productos`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ nombre, descripcion, precio, categoria_id })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.mensaje);
        obtenerProductos();
    });
}

// Eliminar producto
function eliminarProducto(id) {
    fetch(`${API_URL}/productos?id=${id}`, {
        method: "DELETE"
    })
    .then(response => response.json())
    .then(data => {
        alert(data.mensaje);
        obtenerProductos();
    });
}
