document.addEventListener("DOMContentLoaded", function () {
  const modalMapa = new bootstrap.Modal(document.getElementById("modalMapa"));
  const mapaDiv = document.getElementById("mapaUnidad");

  let map;
  let marker;

  // Redibuja el mapa cuando se muestre la modal
  document.getElementById("modalMapa")?.addEventListener("shown.bs.modal", function () {
    if (map) map.invalidateSize();
  });

  // Delegación: funciona para flotilla o demos
  document.addEventListener("click", function(e) {
    const boton = e.target.closest(".btnubicacionunidad");
    if (!boton) return;

    const vin = boton.getAttribute("data-vin");
    mostrarUbicacionUnidad(vin);
  });

  function mostrarUbicacionUnidad(vin) {
    fetch(`../../Servidor/solicitudes/unidades/get_ubicacion_por_vin.php?vin=${vin}`)
      .then(response => {
        if (!response.ok) throw new Error("No se pudo obtener respuesta del servidor");
        return response.json();
      })
      .then(data => {
        const lat = parseFloat(data.lat);
        const lng = parseFloat(data.lng);

        if (isNaN(lat) || isNaN(lng)) {
          throw new Error("Ubicación no válida");
        }

        if (!map) {
          map = L.map(mapaDiv).setView([lat, lng], 15);
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
          }).addTo(map);

          marker = L.marker([lat, lng]).addTo(map);
        } else {
          map.setView([lat, lng], 15);
          marker.setLatLng([lat, lng]);
        }

        modalMapa.show();
      })
      .catch(error => {
        console.error("Error al obtener ubicación:", error);
        Swal.fire({
          icon: 'error',
          title: 'Ubicación no encontrada',
          text: 'No se pudo obtener la ubicación de la unidad. Verifica que esté activa en el sistema GPS TELEMATICS.',
          confirmButtonText: 'Entendido'
        });
      });
  }
});
