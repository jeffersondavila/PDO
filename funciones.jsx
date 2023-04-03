llenarCombo();

function llenarCombo() {
    $.ajax({
        url: 'getCategoria.php',
        type: 'GET',
        success: function (response) {
            var template = "";
            var datos = JSON.parse(response);
            var combo = document.getElementById("combo_categoria");

            combo.innerHTML = '<option value = "">Seleccione una categoria</option>';

            for (var i = 0; i < datos[0].cantidad; i++) {
                template += `<option value = "${datos[0].id[i]}">${datos[0].nombre[i]}</option>`;
                combo.innerHTML += template;
                template = "";
            }
        }
    });
}

var seleccionarCombo = document.getElementById('combo_categoria');

seleccionarCombo.addEventListener("change", function () {
    var posicionCombo = seleccionarCombo.value;

    $.ajax({
        url: 'postProductos.php',
        type: 'POST',
        data: { posicionCombo },
        success: function (response) {
            var tbody = document.getElementById('tabla_body');
            tbody.innerHTML = "";

            var datosObtenidos = JSON.parse(response);
            var template = "";

            for (var i = 0; i < datosObtenidos[0].cantidad; i++) {
                template += `
                <tr>
                    <th>${datosObtenidos[0].idproducto[i]}</th>
                    <th>${datosObtenidos[0].nombre[i]}</th>
                </tr>`;
                tbody.innerHTML = template;
            }
        }
    })
});