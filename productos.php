<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Productos - SFI</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- BOOTSTRAP -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        background-color: #f5f6fa;
    }
    .sidebar {
        background-color: #343a40;
        height: 100vh;
        width: 250px;
        position: fixed;
        top: 0;
        left: 0;
        padding-top: 20px;
        color: white;
    }
    .sidebar a {
        color: #ddd;
        padding: 12px 20px;
        display: block;
        text-decoration: none;
        font-size: 16px;
    }
    .sidebar a:hover {
        background-color: #495057;
        border-radius: 8px;
    }
    .main-content {
        margin-left: 260px;
        padding: 25px;
    }
    .card-custom {
        border-radius: 18px;
        border: none;
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        padding: 20px;
    }
    .btn-modern {
        border-radius: 10px;
        padding: 8px 15px;
    }
    table {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }
    th {
        background-color: #343a40 !important;
        color: white;
    }
</style>
</head>

<body>



<!-- CONTENIDO -->
<div class="main-content">

    <h2 class="fw-bold">Gestión de Productos</h2>
    <p class="text-muted">Administra, registra y controla tus productos</p>

    <!-- FORMULARIO -->
    <div class="card-custom mt-3">
        <h4 class="mb-3">➕ Agregar / Editar Producto</h4>

        <form id="formProducto">

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-bold">Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">ID Categoría</label>
                    <input type="number" id="id_categoria" name="id_categoria" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Proveedor</label>
                    <select id="id_proveedor" name="id_proveedor" class="form-select" required></select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Precio compra</label>
                    <input type="number" step="0.01" id="precio_compra" name="precio_compra" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Precio venta</label>
                    <input type="number" step="0.01" id="precio_venta" name="precio_venta" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Stock</label>
                    <input type="number" id="stock" name="stock" class="form-control" required>
                </div>
            </div>

            <button class="btn btn-primary btn-modern mt-3" type="submit">Guardar</button>
        </form>
    </div>

    <!-- TABLA -->
    <div class="card-custom mt-4">
        <h4 class="mb-3">📃 Lista de Productos</h4>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Proveedor</th>
                    <th>Compra</th>
                    <th>Venta</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="listaProductos"></tbody>
        </table>
    </div>

</div>

<!-- SCRIPTS -->
<script>
// Cargar productos
function cargarProductos() {
    fetch("productos_lista.php")
    .then(res => res.json())
    .then(data => {
        let html = "";
        data.forEach(p => {
            html += `
            <tr>
                <td>${p.id}</td>
                <td>${p.nombre}</td>
                <td>${p.id_categoria}</td>
                <td>${p.id_proveedor}</td>
                <td>S/. ${p.precio_compra}</td>
                <td>S/. ${p.precio_venta}</td>
                <td>${p.stock}</td>
                <td>
                    <button class="btn btn-warning btn-sm btn-modern" onclick="editarProducto(${p.id}, '${p.nombre}', ${p.id_categoria}, ${p.id_proveedor}, ${p.precio_compra}, ${p.precio_venta}, ${p.stock})">Editar</button>
                    <button class="btn btn-danger btn-sm btn-modern" onclick="eliminarProducto(${p.id})">Eliminar</button>
                </td>
            </tr>`;
        });

        document.getElementById("listaProductos").innerHTML = html;
    });
}
cargarProductos();

// Guardar producto
document.getElementById("formProducto").addEventListener("submit", (e) => {
    e.preventDefault();
    let datos = new FormData(e.target);
    let id = e.target.dataset.id;
    let url = id ? "productos_editar.php" : "productos_guardar.php";

    if (id) datos.append("id", id);

    fetch(url, { method: "POST", body: datos })
    .then(res => res.json())
    .then(data => {
        alert(data.msg);
        if (data.ok) {
            e.target.reset();
            delete e.target.dataset.id;
            cargarProductos();
        }
    });
});

// Proveedores
function cargarProveedores() {
    fetch("proveedores_lista.php")
    .then(res => res.json())
    .then(data => {
        let opciones = '<option disabled selected>Seleccione...</option>';
        data.forEach(p => {
            opciones += `<option value="${p.id}">${p.nombre_empresa}</option>`;
        });
        document.getElementById("id_proveedor").innerHTML = opciones;
    });
}
cargarProveedores();

// Eliminar
function eliminarProducto(id) {
    if (!confirm("¿Eliminar este producto?")) return;

    let datos = new FormData();
    datos.append("id", id);

    fetch("productos_eliminar.php", { method: "POST", body: datos })
    .then(res => res.json())
    .then(data => {
        alert(data.msg);
        if (data.ok) cargarProductos();
    });
}

// Editar
function editarProducto(id, nombre, id_categoria, id_proveedor, precio_compra, precio_venta, stock) {

    formProducto.dataset.id = id;
    document.getElementById("nombre").value = nombre;
    document.getElementById("id_categoria").value = id_categoria;
    document.getElementById("id_proveedor").value = id_proveedor;
    document.getElementById("precio_compra").value = precio_compra;
    document.getElementById("precio_venta").value = precio_venta;
    document.getElementById("stock").value = stock;
}
</script>

</body>
</html>
