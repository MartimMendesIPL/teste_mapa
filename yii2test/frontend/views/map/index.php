<?php

/** @var yii\web\View $this */
/** @var string $sitesJson */

use yii\helpers\Html;

$this->title = 'Mapa Interativo de Portugal - Museus, Monumentos e Locais Culturais';
$this->params['breadcrumbs'][] = $this->title;

// Register Leaflet CSS
$this->registerCssFile('https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', [
    'integrity' => 'sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=',
    'crossorigin' => '',
]);

// Register Leaflet JS
$this->registerJsFile('https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', [
    'integrity' => 'sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=',
    'crossorigin' => '',
    'position' => \yii\web\View::POS_HEAD,
]);

// Custom CSS for the map
$this->registerCss('
    #map { 
        height: 600px; 
        width: 100%;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .filter-section {
        margin-bottom: 20px;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 8px;
    }
    .site-popup h3 {
        margin-top: 0;
        color: #0d6efd;
    }
    .site-popup img {
        max-width: 100%;
        height: auto;
        border-radius: 4px;
        margin: 10px 0;
    }
    .site-popup .info-item {
        margin: 8px 0;
    }
    .site-popup .info-item strong {
        display: inline-block;
        width: 120px;
    }
    .legend {
        line-height: 18px;
        color: #555;
        background-color: white;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 0 15px rgba(0,0,0,0.2);
    }
    .legend i {
        width: 18px;
        height: 18px;
        float: left;
        margin-right: 8px;
        opacity: 0.7;
    }
    .legend .museum { background-color: #e74c3c; }
    .legend .monument { background-color: #3498db; }
    .legend .cultural_site { background-color: #2ecc71; }
');
?>

<div class="map-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="filter-section">
        <div class="row">
            <div class="col-md-4">
                <label for="filter-type">Filtrar por Tipo:</label>
                <select id="filter-type" class="form-control">
                    <option value="">Todos</option>
                    <option value="museum">Museus</option>
                    <option value="monument">Monumentos</option>
                    <option value="cultural_site">Locais Culturais</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="filter-region">Filtrar por Região:</label>
                <input type="text" id="filter-region" class="form-control" placeholder="Ex: Lisboa, Porto">
            </div>
            <div class="col-md-4">
                <label>&nbsp;</label>
                <button id="apply-filter" class="btn btn-primary form-control">Aplicar Filtro</button>
            </div>
        </div>
    </div>

    <div id="map"></div>

    <div class="mt-3">
        <p><strong>Total de locais:</strong> <span id="site-count">0</span></p>
    </div>
</div>

<?php
// JavaScript for the interactive map
$js = <<<JS
(function() {
    // Initialize the map centered on Portugal
    var map = L.map('map').setView([39.3999, -8.2245], 7);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);

    // Cultural sites data from PHP
    var allSites = $sitesJson;
    var markers = [];

    // Function to get marker color based on type
    function getMarkerColor(type) {
        switch(type) {
            case 'museum': return '#e74c3c';
            case 'monument': return '#3498db';
            case 'cultural_site': return '#2ecc71';
            default: return '#95a5a6';
        }
    }

    // Function to create custom icon
    function createIcon(type) {
        return L.divIcon({
            className: 'custom-marker',
            html: '<div style="background-color: ' + getMarkerColor(type) + '; width: 25px; height: 25px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 5px rgba(0,0,0,0.5);"></div>',
            iconSize: [25, 25],
            iconAnchor: [12, 12]
        });
    }

    // Function to create popup content
    function createPopupContent(site) {
        var html = '<div class="site-popup">';
        html += '<h3>' + site.name + '</h3>';
        
        if (site.image_url) {
            html += '<img src="' + site.image_url + '" alt="' + site.name + '">';
        }
        
        if (site.description) {
            html += '<p>' + site.description + '</p>';
        }
        
        html += '<div class="info-item"><strong>Tipo:</strong> ' + getTypeLabel(site.type) + '</div>';
        html += '<div class="info-item"><strong>Cidade:</strong> ' + site.city + '</div>';
        html += '<div class="info-item"><strong>Região:</strong> ' + site.region + '</div>';
        
        if (site.address) {
            html += '<div class="info-item"><strong>Endereço:</strong> ' + site.address + '</div>';
        }
        
        if (site.phone) {
            html += '<div class="info-item"><strong>Telefone:</strong> ' + site.phone + '</div>';
        }
        
        if (site.opening_hours) {
            html += '<div class="info-item"><strong>Horário:</strong> ' + site.opening_hours + '</div>';
        }
        
        if (site.website) {
            html += '<div class="info-item"><strong>Website:</strong> <a href="' + site.website + '" target="_blank">Visitar</a></div>';
        }
        
        html += '</div>';
        return html;
    }

    // Function to get type label in Portuguese
    function getTypeLabel(type) {
        switch(type) {
            case 'museum': return 'Museu';
            case 'monument': return 'Monumento';
            case 'cultural_site': return 'Local Cultural';
            default: return type;
        }
    }

    // Function to add markers to the map
    function displaySites(sites) {
        // Clear existing markers
        markers.forEach(function(marker) {
            map.removeLayer(marker);
        });
        markers = [];

        // Add new markers
        sites.forEach(function(site) {
            var marker = L.marker([site.latitude, site.longitude], {
                icon: createIcon(site.type)
            }).addTo(map);
            
            marker.bindPopup(createPopupContent(site), {
                maxWidth: 300
            });
            
            markers.push(marker);
        });

        // Update count
        $('#site-count').text(sites.length);
    }

    // Display all sites initially
    displaySites(allSites);

    // Add legend
    var legend = L.control({position: 'bottomright'});
    legend.onAdd = function(map) {
        var div = L.DomUtil.create('div', 'legend');
        div.innerHTML = '<h4>Legenda</h4>';
        div.innerHTML += '<i class="museum"></i> Museus<br>';
        div.innerHTML += '<i class="monument"></i> Monumentos<br>';
        div.innerHTML += '<i class="cultural_site"></i> Locais Culturais<br>';
        return div;
    };
    legend.addTo(map);

    // Filter functionality
    $('#apply-filter').on('click', function() {
        var filterType = $('#filter-type').val();
        var filterRegion = $('#filter-region').val().trim().toLowerCase();

        var filteredSites = allSites.filter(function(site) {
            var matchType = !filterType || site.type === filterType;
            var matchRegion = !filterRegion || 
                site.region.toLowerCase().includes(filterRegion) ||
                site.city.toLowerCase().includes(filterRegion);
            return matchType && matchRegion;
        });

        displaySites(filteredSites);

        // Adjust map view to show all filtered markers
        if (filteredSites.length > 0) {
            var group = new L.featureGroup(markers);
            map.fitBounds(group.getBounds().pad(0.1));
        }
    });

    // Reset filters on clear
    $('#filter-type, #filter-region').on('change keyup', function(e) {
        if (e.type === 'keyup' && e.keyCode === 13) {
            $('#apply-filter').click();
        }
    });
})();
JS;

$this->registerJs($js, \yii\web\View::POS_READY);
?>
