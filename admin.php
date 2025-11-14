<?php
session_start();
require_once("conexion.php");

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: index.html");
    exit();
}

// Obtener estadísticas desde la base de datos
$total_ventas = 0;
$total_productos = 0;
$total_clientes = 0;

try {
    // Total de ventas
    $res = $conn->query("SELECT SUM(total) AS total_ventas FROM ventas");
    if ($res && $row = $res->fetch_assoc()) {
        $total_ventas = $row['total_ventas'] ?: 0;
    }

    // Total de productos
    $res = $conn->query("SELECT COUNT(*) AS total_productos FROM productos");
    if ($res && $row = $res->fetch_assoc()) {
        $total_productos = $row['total_productos'];
    }

    // Total de clientes
    $res = $conn->query("SELECT COUNT(*) AS total_clientes FROM clientes");
    if ($res && $row = $res->fetch_assoc()) {
        $total_clientes = $row['total_clientes'];
    }
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - SFI</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            background-color: #343a40;
            height: 100vh;
            color: white;
            position: fixed;
            width: 240px;
            top: 0;
            left: 0;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h4 class="text-center mb-4">🧭 Panel Admin</h4>
        <a href="admin.php">🏠 Dashboard</a>
        <a href="productos.php">📦 Productos</a>
        <a href="clientes.php">🧍 Clientes</a>
        <a href="ventas.php">💰 Ventas</a>
        <a href="reportes.php">📊 Reportes</a>
        <a href="usuarios.php">👥 Usuarios</a>
        <a href="logout.php" class="text-danger">🚪 Cerrar sesión</a>
    </div>

    <div class="main-content">
        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?> 👋</h2>
        <p class="text-muted">Resumen general del sistema</p>

        <div class="row mt-4">
            <div class="col-md-4 mb-3">
                <div class="card text-center p-4">
                    <h4>💰 Total de Ventas</h4>
                    <h2 class="text-success">S/. <?php echo number_format($total_ventas, 2); ?></h2>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center p-4">
                    <h4>📦 Productos</h4>
                    <h2 class="text-primary"><?php echo $total_productos; ?></h2>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center p-4">
                    <h4>🧍 Clientes</h4>
                    <h2 class="text-warning"><?php echo $total_clientes; ?></h2>
                </div>
            </div>
        </div>

        <div class="card p-4 mt-4">
            <h4>📈 Gráfico de ventas (ejemplo)</h4>
            <canvas id="graficoVentas"></canvas>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('graficoVentas');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
                datasets: [{
                    label: 'Ventas S/.',
                    data: [1000, 1500, 900, 1200, 2000, 1800, 2200],
                    borderWidth: 1,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)'
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>

</body>
</html>
