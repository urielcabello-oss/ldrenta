const apiUrltelematics = 'https://portal.telematicsadvance.com.mx/api/v1/unit/list.json';
        const apiKey = '763fcd49ab3a7bc87060e21d822c37e45d1ab780'; 

        // Función para obtener el kilometraje y el VIN
        function obtenerKilometrajeYVIN() {
            fetch(`${apiUrltelematics}?key=${apiKey}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la conexión a la API');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Datos de las unidades:', data);

                    // Limpiar la vista previa de kilometraje y VIN
                    const unitInfoDiv = document.getElementById('unit-info');
                    unitInfoDiv.innerHTML = ''; // Limpiar la vista anterior

                    // Recorrer las unidades y mostrar el kilometraje y el VIN
                    data.data.units.forEach(unit => {
                        const mileageInKm = unit.mileage / 1000; // Convertir metros a kilómetros

                        // Constante para obtener el VIN
                        const vin = unit.vin || "VIN no disponible"; 
                        
                        // Crear un nuevo elemento para mostrar el kilometraje y el VIN
                        const unitElement = document.createElement('div');
                        unitElement.innerHTML = `
                            <strong>Unidad:</strong> ${unit.label} <br>
                            <strong>VIN:</strong> ${vin} <br>
                            <strong>Kilometraje:</strong> ${mileageInKm.toFixed(2)} km
                        `;
                        
                        // Agregarlo al contenedor
                        unitInfoDiv.appendChild(unitElement);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // Ejecutar la función de obtener kilometraje y VIN cada 10 segundos
        setInterval(obtenerKilometrajeYVIN, 10000);  // 10000ms = 10 segundos

        // Llamar a la función inicialmente para mostrar los datos al cargar
        obtenerKilometrajeYVIN();