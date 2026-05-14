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