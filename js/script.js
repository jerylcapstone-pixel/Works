// Initialize map centered on Philippines
const map = L.map('map').setView([12.8797, 121.7740], 6);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Function to show messages
function showMessage(message, type = 'info') {
    const messageDiv = document.getElementById('message');
    messageDiv.innerHTML = `<div class="alert alert-${type}" role="alert">${message}</div>`;
    setTimeout(() => {
        messageDiv.innerHTML = '';
    }, 5000);
}

// Load locations from server
function loadLocations() {
    fetch('php/get_locations.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to load locations');
            }
            return response.json();
        })
        .then(data => {
            // Clear existing markers
            map.eachLayer(layer => {
                if (layer instanceof L.Marker) {
                    map.removeLayer(layer);
                }
            });
            // Add markers
            data.forEach(loc => {
                if (loc.lat && loc.lng) {
                    let popupContent = loc.description || 'Homeless dog reported';
                    popupContent += '<br><small>Reported on: ' + new Date(loc.created_at).toLocaleString() + '</small>';
                    L.marker([loc.lat, loc.lng]).addTo(map)
                        .bindPopup(popupContent);
                }
            });
        })
        .catch(error => {
            console.error('Error loading locations:', error);
            showMessage('Failed to load locations. Please try again.', 'danger');
        });
}

// Load locations on page load
loadLocations();

// Get user's current location
document.getElementById('getLocationBtn').addEventListener('click', function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;
            showMessage('Location retrieved successfully!', 'success');
        }, error => {
            console.error('Geolocation error:', error);
            showMessage('Unable to retrieve your location. Please enter coordinates manually.', 'warning');
        });
    } else {
        showMessage('Geolocation is not supported by this browser.', 'warning');
    }
});

// Handle form submission
document.getElementById('addLocationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const lat = parseFloat(document.getElementById('lat').value);
    const lng = parseFloat(document.getElementById('lng').value);
    const description = document.getElementById('description').value.trim();

    // Validation
    if (isNaN(lat) || lat < -90 || lat > 90) {
        showMessage('Please enter a valid latitude (-90 to 90).', 'danger');
        return;
    }
    if (isNaN(lng) || lng < -180 || lng > 180) {
        showMessage('Please enter a valid longitude (-180 to 180).', 'danger');
        return;
    }

    const locationData = { lat, lng, description };

    fetch('php/add_location.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(locationData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to add location');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showMessage('Location added successfully!', 'success');
            loadLocations(); // Reload markers
            document.getElementById('addLocationForm').reset();
        } else {
            throw new Error('Server returned failure');
        }
    })
    .catch(error => {
        console.error('Error adding location:', error);
        showMessage('Failed to add location. Please try again.', 'danger');
    });
});