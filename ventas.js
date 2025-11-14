// ======================
// BUSCAR PRODUCTOS
// ======================
$("#btnBuscar").click(function () {
    let texto = $("#buscar_producto").val();

    $.ajax({
        url: "productos_buscar.php",
        type: "POST",
        data: { texto: texto },
        dataType: "json",
        success: function (data) {
            let tabla = "";

            data.forEach(p => {
                tabla += `
                    <tr>
                        <td>${p.nombre}</td>
                        <td>S/. ${p.precio}</td>
                        <td>${p.stock}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" 
                                onclick="agregarProducto(${p.id}, '${p.nombre}', ${p.precio})">
                                Agregar
                            </button>
                        </td>
                    </tr>
                `;
            });

            $("#tablaProductos").html(tabla);
        }
    });
});


// ======================
// CARRITO
// ======================

let carrito = [];

function agregarProducto(id, nombre, precio) {

    let existe = carrito.find(p => p.id === id);

    if (existe) {
        existe.cantidad++;
    } else {
        carrito.push({
            id: id,
            nombre: nombre,
            precio: precio,
            cantidad: 1
        });
    }

    actualizarCarrito();
}

function actualizarCarrito() {
    let tabla = "";
    let total = 0;

    carrito.forEach((p, index) => {
        let subtotal = p.precio * p.cantidad;
        total += subtotal;

        tabla += `
            <tr>
                <td>${p.nombre}</td>
                <td>
                    <input type="number" min="1" class="form-control form-control-sm"
                        value="${p.cantidad}"
                        onchange="cambiarCantidad(${index}, this.value)">
                </td>
                <td>S/. ${p.precio}</td>
                <td>S/. ${subtotal.toFixed(2)}</td>
                <td>
                    <button class="btn btn-danger btn-sm" onclick="quitar(${index})">X</button>
                </td>
            </tr>
        `;
    });

    $("#tablaCarrito").html(tabla);
    $("#total").text(total.toFixed(2));
}

function cambiarCantidad(index, valor) {
    carrito[index].cantidad = parseInt(valor);
    actualizarCarrito();
}

function quitar(index) {
    carrito.splice(index, 1);
    actualizarCarrito();
}


// ==========================
// REGISTRAR VENTA
// ==========================
$("#btnRegistrarVenta").click(function () {

    if ($("#cliente").val() === "") {
        alert("Debe seleccionar un cliente.");
        return;
    }

    if (carrito.length === 0) {
        alert("Debe agregar al menos un producto.");
        return;
    }

    $.ajax({
        url: "ventas_guardar.php",
        type: "POST",
        data: {
            cliente: $("#cliente").val(),
            carrito: JSON.stringify(carrito)
        },
        success: function (resp) {
            alert("Venta registrada con éxito");
            location.reload();
        }
    });

});
