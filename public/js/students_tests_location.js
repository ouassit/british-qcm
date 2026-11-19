document.addEventListener('DOMContentLoaded', function () {
    var panel = document.getElementById('page-location');
    var button = document.getElementById('share-page-location');
    var message = document.getElementById('page-location-status');
    if (!panel || !button) return;

    button.addEventListener('click', function () {
        button.disabled = true;
        message.textContent = 'Localisation en cours…';
        function save(status, coords) {
            var data = {token: panel.dataset.token, location_status: status};
            if (coords) {
                data.latitude = coords.latitude;
                data.longitude = coords.longitude;
                data.accuracy = coords.accuracy;
            }
            fetch(panel.dataset.url, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': panel.dataset.csrf},
                body: JSON.stringify(data)
            }).then(function (response) {
                if (!response.ok) throw new Error('Save failed');
                message.textContent = status === 'granted' ? 'Localisation enregistrée.' : 'Localisation indisponible ou refusée. Votre IP est enregistrée.';
                button.disabled = false;
            }).catch(function () {
                message.textContent = 'Localisation non enregistrée. Réessayez ou actualisez la page. Votre IP est enregistrée.';
                button.disabled = false;
            });
        }
        if (!navigator.geolocation || !window.isSecureContext) {
            save('unavailable');
            return;
        }
        navigator.geolocation.getCurrentPosition(function (position) {
            save('granted', position.coords);
        }, function (error) {
            save(error.code === 1 ? 'denied' : (error.code === 3 ? 'timeout' : 'unavailable'));
        }, {enableHighAccuracy: false, timeout: 10000, maximumAge: 0});
    });
});
