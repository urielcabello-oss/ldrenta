function filtrarCards() {
    const input = document.getElementById('filtroBusqueda');
    const filtro = input.value.toLowerCase();
    const cards = document.querySelectorAll('.card');
  
    cards.forEach(card => {
      const textoCard = card.textContent.toLowerCase();
      if (textoCard.includes(filtro)) {
        card.style.display = '';
      } else {
        card.style.display = 'none';
      }
    });
  }

      function filtrarTabla() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById('filtroBusqueda');
        filter = input.value.toLowerCase();
        table = document.getElementById('tablaUnidades');
        tr = table.getElementsByTagName('tr');

        for (i = 1; i < tr.length; i++) { // Comienza desde 1 para omitir el encabezado
            td = tr[i].getElementsByTagName('td');
            let matchFound = false;
            for (let j = 0; j < td.length; j++) {
                if (td[j]) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        matchFound = true;
                        break;
                    }
                }
            }
            if (matchFound) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }