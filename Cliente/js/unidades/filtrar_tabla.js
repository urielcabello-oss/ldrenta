
function aplicarFiltros() {
    const texto = document.getElementById('filtroBusqueda').value.toLowerCase();
    const marca = document.getElementById('filtroMarca').value.toLowerCase();
    const modelo = document.getElementById('filtroModelo').value.toLowerCase();
    const estado = document.getElementById('filtroEstado').value.toLowerCase();
    const tipo = document.getElementById('filtroTipo').value.toLowerCase();
    const sede = document.getElementById('filtroSede').value.toLowerCase();

    const filas = document.querySelectorAll('#tablaUnidades tbody tr');

    filas.forEach(fila => {
        let ok = true;

        if (texto && !fila.innerText.toLowerCase().includes(texto)) ok = false;
        if (marca && fila.dataset.marca.toLowerCase() !== marca) ok = false;
        if (modelo && fila.dataset.modelo.toLowerCase() !== modelo) ok = false;
        if (estado && fila.dataset.estado.toLowerCase() !== estado) ok = false;
        if (tipo && fila.dataset.tipo.toLowerCase() !== tipo) ok = false;
        if (sede && fila.dataset.sede.toLowerCase() !== sede) ok = false;

        fila.style.display = ok ? '' : 'none';
    });
}

function limpiarFiltros(){
    document.querySelectorAll('.form-select, #filtroBusqueda')
      .forEach(i => i.value = '');

    aplicarFiltros();
}


    