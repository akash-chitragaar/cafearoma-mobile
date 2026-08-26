<?php
// Mobile Location Selector - Home Page
$page_title = "Select a Location - Cafe Adora";
$page_description = "Find your nearest Cafe Adora location in NYC";

// Load locations from JSON
$locations_json = file_get_contents('locations.json');
$locations_data = json_decode($locations_json, true);
$locations = $locations_data['locations'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $page_description; ?>">
    <title><?php echo $page_title; ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
    
    <!-- Social -->
    <meta property="og:site_name" content="Cafe Adora NYC">
    <meta property="og:title" content="<?php echo $page_title; ?>">
    <meta property="og:description" content="<?php echo $page_description; ?>">
    <meta property="og:image" content="assets/images/opengraph.png">
    <meta property="og:type" content="website">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }
        
        .header {
            background: linear-gradient(135deg, #6f4e37 0%, #8b6343 100%);
            color: white;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-content {
            display: flex;
            align-items: center;
            gap: 15px;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .logo-img {
            height: 50px;
            width: auto;
            border-radius: 5px;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .header-text h1 {
            font-size: 22px;
            font-weight: 600;
            margin: 0;
        }
        
        .header-text p {
            font-size: 14px;
            margin: 0;
            opacity: 0.9;
        }
        
        .location-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 16px;
        }
        
        .location-list {
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .location-card {
            background: white;
            border: 1px solid #e0e0e0;
            margin-bottom: 0;
            padding: 0;
            display: flex;
            gap: 0;
            align-items: stretch;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .location-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: transparent;
            transition: all 0.3s ease;
        }
        
        .location-card:hover {
            background: #f8f9fa;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        
        .location-card:hover::before {
            background: #6f4e37;
        }
        
        .location-image {
            width: 120px;
            min-height: 120px;
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            border-radius: 0;
        }
        
        .location-image::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0);
            transition: all 0.3s ease;
            pointer-events: none;
        }
        
        .location-card:hover .location-image::after {
            background: rgba(0,0,0,0.03);
        }
        
        .location-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .location-image.placeholder {
            font-size: 40px;
            color: #adb5bd;
        }
        
        .location-details {
            flex: 1;
            min-width: 0;
            padding: 16px;
        }
        
        .location-name {
            font-size: 18px;
            font-weight: 600;
            color: #2c1810;
            margin: 0 0 8px 0;
            letter-spacing: -0.3px;
        }
        
        .location-address {
            font-size: 14px;
            color: #666;
            margin: 0 0 6px 0;
        }
        
        .location-distance {
            font-size: 14px;
            color: #666;
            font-weight: 500;
            margin: 0 0 6px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .location-distance i {
            color: #666;
        }
        
        .location-distance.nearest {
            color: #28a745;
        }
        
        .location-distance.nearest i {
            color: #28a745;
        }
        
        .location-distance.calculating {
            color: #6c757d;
        }
        
        .location-distance.calculating i {
            color: #6c757d;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .location-hours {
            font-size: 13px;
            color: #666;
            margin: 0;
        }
        
        .future-badge {
            display: inline-block;
            background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
            color: #000;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            margin-left: 8px;
            box-shadow: 0 2px 4px rgba(255, 193, 7, 0.3);
            text-transform: uppercase;
        }
        
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            gap: 20px;
        }
        
        .loading-overlay.hidden {
            display: none;
        }
        
        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #6f4e37;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        .loading-text {
            font-size: 16px;
            color: #6f4e37;
            font-weight: 500;
        }
        
        .location-permission-banner {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 16px;
            margin: 16px;
            border-radius: 4px;
        }
        
        .location-permission-banner.error {
            background: #f8d7da;
            border-left-color: #dc3545;
        }
        
        .location-permission-banner h3 {
            font-size: 16px;
            margin: 0 0 8px 0;
            color: #856404;
        }
        
        .location-permission-banner.error h3 {
            color: #721c24;
        }
        
        .location-permission-banner p {
            font-size: 14px;
            margin: 0;
            color: #856404;
        }
        
        .location-permission-banner.error p {
            color: #721c24;
        }
        
        .retry-btn {
            margin-top: 10px;
            background: #6f4e37;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .retry-btn:hover {
            background: #5a3d2a;
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="loading-overlay">
        <div class="spinner"></div>
        <div class="loading-text">Finding nearest locations...</div>
    </div>
    
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <img src="assets/images/logo.png" alt="Cafe Adora Logo" class="logo-img">
            <div class="header-text">
                <h1>Cafe Adora</h1>
                <p>Select a location to order</p>
            </div>
        </div>
    </div>
    
    <!-- Location Permission Banner (hidden by default) -->
    <div id="permissionBanner" style="display: none;"></div>
    
    <!-- Location List -->
    <div class="location-container">
        <div class="location-list" id="locationList">
            <?php foreach ($locations as $location): ?>
            <div class="location-card" 
                 data-id="<?php echo $location['id']; ?>"
                 data-lat="<?php echo $location['lat']; ?>"
                 data-lng="<?php echo $location['lng']; ?>"
                 data-status="<?php echo $location['status']; ?>"
                 data-order-url="<?php echo $location['order_url']; ?>"
                 onclick="handleLocationClick(<?php echo $location['id']; ?>)">
                <div class="location-image">
                    <?php if (!empty($location['image']) && file_exists($location['image'])): ?>
                        <img src="<?php echo htmlspecialchars($location['image']); ?>" alt="<?php echo htmlspecialchars($location['name']); ?>">
                    <?php else: ?>
                        <i class="fas fa-store" style="font-size: 40px; color: #adb5bd;"></i>
                    <?php endif; ?>
                </div>
                <div class="location-details">
                    <h2 class="location-name">
                        <?php echo htmlspecialchars($location['name']); ?>
                        <?php if ($location['status'] === 'future'): ?>
                            <span class="future-badge">Coming Soon</span>
                        <?php endif; ?>
                    </h2>
                    <p class="location-address">
                        <span><?php echo htmlspecialchars($location['address']); ?></span>
                    </p>
                    <p class="location-distance calculating" data-location-id="<?php echo $location['id']; ?>">
                        <i class="fas fa-spinner"></i>
                        <span>Calculating distance...</span>
                    </p>
                    <p class="location-hours">
                        <?php echo htmlspecialchars($location['hours']); ?>
                    </p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Google Maps API -->
    <script>
        // Location data from PHP
        const locations = <?php echo json_encode($locations); ?>;
        let userLocation = null;
        let sortedByDistance = false;
        
        // Detect OS and return appropriate campaign parameter
        function detectOS() {
            const userAgent = navigator.userAgent || navigator.vendor || window.opera;
            
            // iOS detection
            if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
                return 'iphone';
            }
            
            // Android detection
            if (/android/i.test(userAgent)) {
                return 'android';
            }
            
            // Fallback to mobile
            return 'mobile';
        }
        
        // Build order URL with dynamic parameters
        function buildOrderUrl(baseUrl) {
            const campaign = detectOS();
            const source = 'brandedapp';
            
            // Check if URL already has query parameters
            const separator = baseUrl.includes('?') ? '&' : '?';
            
            return `${baseUrl}${separator}source=${source}&campaign=${campaign}`;
        }
        
        // Calculate distance between two coordinates using Haversine formula
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 3959; // Radius of Earth in miles
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = 
                Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            const distance = R * c;
            return distance;
        }
        
        // Format distance for display
        function formatDistance(miles) {
            if (miles < 0.1) {
                return Math.round(miles * 5280) + 'ft away';
            } else if (miles < 1) {
                return (miles * 5280).toFixed(0) + 'ft away';
            } else {
                return miles.toFixed(1) + ' Mile' + (miles !== 1 ? 's' : '') + ' Away';
            }
        }
        
        // Update distance displays
        function updateDistances(userLat, userLng) {
            const locationsWithDistance = locations.map(location => {
                const distance = calculateDistance(userLat, userLng, location.lat, location.lng);
                return {
                    ...location,
                    distance: distance
                };
            });
            
            // Sort by distance
            locationsWithDistance.sort((a, b) => a.distance - b.distance);
            
            // Update UI
            locationsWithDistance.forEach((location, index) => {
                const distanceElement = document.querySelector(`[data-location-id="${location.id}"]`);
                if (distanceElement) {
                    distanceElement.classList.remove('calculating');
                    
                    // First location (nearest) gets green with check icon
                    if (index === 0) {
                        distanceElement.classList.add('nearest');
                        distanceElement.innerHTML = `
                            <i class="fas fa-check-circle"></i>
                            <span>${formatDistance(location.distance)}</span>
                        `;
                    } else {
                        distanceElement.innerHTML = `
                            <i class="fas fa-location-arrow"></i>
                            <span>${formatDistance(location.distance)}</span>
                        `;
                    }
                }
            });
            
            // Re-order cards in DOM
            const locationList = document.getElementById('locationList');
            locationsWithDistance.forEach(location => {
                const card = document.querySelector(`[data-id="${location.id}"]`);
                if (card) {
                    locationList.appendChild(card);
                }
            });
            
            sortedByDistance = true;
        }
        
        // Show permission banner
        function showPermissionBanner(type = 'warning', title, message, showRetry = false) {
            const banner = document.getElementById('permissionBanner');
            banner.className = `location-permission-banner ${type}`;
            banner.innerHTML = `
                <h3><i class="fas fa-${type === 'error' ? 'exclamation-triangle' : 'info-circle'}"></i> ${title}</h3>
                <p>${message}</p>
                ${showRetry ? '<button class="retry-btn" onclick="getUserLocation()"><i class="fas fa-redo"></i> Try Again</button>' : ''}
            `;
            banner.style.display = 'block';
        }
        
        // Get user's location
        function getUserLocation() {
            const loadingOverlay = document.getElementById('loadingOverlay');
            loadingOverlay.classList.remove('hidden');
            
            if (!navigator.geolocation) {
                loadingOverlay.classList.add('hidden');
                showPermissionBanner('error', 'Geolocation Not Supported', 
                    'Your browser does not support location services. Locations are shown in default order.');
                setDefaultDistances();
                return;
            }
            
            navigator.geolocation.getCurrentPosition(
                // Success callback
                function(position) {
                    userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    
                    updateDistances(userLocation.lat, userLocation.lng);
                    loadingOverlay.classList.add('hidden');
                },
                // Error callback
                function(error) {
                    console.error('Geolocation error:', error);
                    loadingOverlay.classList.add('hidden');
                    
                    let errorMessage = '';
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage = 'Location permission denied. Please enable location access in your browser settings to see distances.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMessage = 'Location information unavailable. Please check your device settings.';
                            break;
                        case error.TIMEOUT:
                            errorMessage = 'Location request timed out. Please try again.';
                            break;
                        default:
                            errorMessage = 'An unknown error occurred while getting your location.';
                    }
                    
                    showPermissionBanner('error', 'Location Access Error', errorMessage, true);
                    setDefaultDistances();
                },
                // Options
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 300000
                }
            );
        }
        
        // Set default distances when location is not available
        function setDefaultDistances() {
            locations.forEach((location, index) => {
                const distanceElement = document.querySelector(`[data-location-id="${location.id}"]`);
                if (distanceElement) {
                    distanceElement.classList.remove('calculating');
                    distanceElement.innerHTML = `
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Location ${index + 1}</span>
                    `;
                }
            });
        }
        
        // Handle location card click
        function handleLocationClick(locationId) {
            const card = document.querySelector(`[data-id="${locationId}"]`);
            const orderUrl = card.dataset.orderUrl;
            const status = card.dataset.status;
            
            if (status === 'future') {
                alert('This location is coming soon! Stay tuned.');
                return;
            }
            
            if (orderUrl) {
                // Build URL with dynamic OS detection and campaign parameters
                const finalUrl = buildOrderUrl(orderUrl);
                console.log('Redirecting to:', finalUrl); // For debugging
                window.location.href = finalUrl;
            }
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            getUserLocation();
            
            // Log detected OS for debugging
            const detectedOS = detectOS();
            console.log('Detected OS:', detectedOS);
            console.log('User Agent:', navigator.userAgent);
            
            // Test URL generation for all locations
            console.log('=== URL Generation Test ===');
            locations.forEach(location => {
                const testUrl = buildOrderUrl(location.order_url);
                console.log(`${location.name}: ${testUrl}`);
            });
        });
    </script>
</body>
</html>

