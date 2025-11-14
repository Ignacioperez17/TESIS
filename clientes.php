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
<title>Clientes - SFI</title>
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

    <h2 class="fw-bold">Gestión de Clientes</h2>
    <p class="text-muted">Administra, registra y controla a tus clientes</p>

    <!-- FORMULARIO -->
    <div class="card-custom mt-3">
        <h4 class="mb-3">➕ Registrar Cliente</h4>

        <form id="formCliente">

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-bold">Nombre del Cliente</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">DNI / RUC</label>
                    <input type="text" id="documento" name="documento" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">Correo</label>
                    <input type="email" id="correo" name="correo" class="form-control">
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-bold">Dirección</label>
                    <input type="text" id="direccion" name="direccion" class="form-control">
                </div>

            </div>

            <button class="btn btn-primary btn-modern mt-3" type="submit">Guardar</button>

        </form>
    </div>

    <!-- TABLA LISTA -->
    <div class="card-custom mt-4">
        <h4 class="mb-3">📃 Lista de Clientes</h4>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>DNI/RUC</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Dirección</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody id="listaClientes"></tbody>
        </table>

    </div>

</div>

<!-- SCRIPT LÓGICO -->
<script>
// Cargar lista
function cargarClientes() {
    fetch("clientes_lista.php")
    .then(res => res.json())
    .then(data => {
        let html = "";
        data.forEach(c => {
            html += `
            <tr>
                <td>${c.id}</td>
                <td>${c.nombre}</td>
                <td>${c.documento}</td>
                <td>${c.telefono}</td>
                <td>${c.correo}</td>
                <td>${c.direccion}</td>
                <td>
                    <button class="btn btn-danger btn-sm btn-modern" onclick="eliminarCliente(${c.id})">Eliminar</button>
                </td>
            </tr>`;
        });
        document.getElementById("listaClientes").innerHTML = html;
    });
}
cargarClientes();

// Guardar cliente
document.getElementById("formCliente").addEventListener("submit", (e) => {
    e.preventDefault();
    let datos = new FormData(e.target);

    fetch("clientes_guardar.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        alert(data.msg);
        if (data.ok) {
            e.target.reset();
            cargarClientes();
        }
    });
});

// Eliminar cliente
function eliminarCliente(id) {
    if (!confirm("¿Seguro que deseas eliminar este cliente?")) return;

    fetch("clientes_eliminar.php?id=" + id)
    .then(res => res.json())
    .then(data => {
        alert(data.msg);
        if (data.ok) cargarClientes();
    });
}

</script>

</body>
</html>
