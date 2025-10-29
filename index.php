<?php
// Mobile Location Selector - Home Page
$page_title = "Select a Location - Cafe Aroma";
$page_description = "Find your nearest Cafe Aroma location in NYC";

// Load locations from JSON
$locations_json = file_get_contents('locations.json');
$locations_data = json_decode($locations_json, true);
$locations = $locations_data['locations'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="<?php echo $page_description; ?>">
    <meta name="theme-color" content="#6f4e37">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title><?php echo $page_title; ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
    <link rel="apple-touch-icon" href="assets/images/logo.png">
    
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
        
        html {
            scroll-behavior: smooth;
            -webkit-tap-highlight-color: transparent;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
            padding-bottom: 20px;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        .header {
            background: #6f4e37;
            color: white;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-content {
            display: flex;
            align-items: center;
            gap: 16px;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .logo {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }
        
        .header-text h1 {
            font-size: 22px;
            font-weight: 600;
            margin: 0;
        }
        
        .header-text p {
            font-size: 14px;
            margin: 4px 0 0 0;
            opacity: 0.9;
        }
        
        .location-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 16px 12px 0;
        }
        
        .location-count {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 12px;
            padding: 0 4px;
            font-weight: 500;
        }
        
        .location-count i {
            color: #6f4e37;
            margin-right: 6px;
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
            border-radius: 12px;
            padding: 16px;
            display: flex;
            gap: 16px;
            align-items: flex-start;
            transition: all 0.2s ease;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            position: relative;
        }
        
        .location-card:hover {
            border-color: #6f4e37;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .location-card:active {
            transform: scale(0.98);
        }
        
        .location-image {
            width: 100px;
            height: 100px;
            background: #f0f0f0;
            border-radius: 8px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .location-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .location-image.placeholder {
            font-size: 42px;
            color: #adb5bd;
        }
        
        .location-details {
            flex: 1;
            min-width: 0;
        }
        
        .location-name {
            font-size: 17px;
            font-weight: 600;
            color: #2c1810;
            margin: 0 0 8px 0;
            display: flex;
            align-items: center;
            gap: 8px;
            line-height: 1.3;
        }
        
        .location-address {
            font-size: 14px;
            color: #495057;
            margin: 0 0 8px 0;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            line-height: 1.5;
        }
        
        .location-address i {
            margin-top: 3px;
            color: #6f4e37;
            flex-shrink: 0;
            font-size: 13px;
        }
        
        .location-distance {
            font-size: 13px;
            color: #28a745;
            font-weight: 500;
            margin: 0 0 6px 0;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .location-distance i {
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
            color: #6c757d;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .location-hours i {
            color: #6f4e37;
            font-size: 12px;
        }
        
        .future-badge {
            display: inline-flex;
            align-items: center;
            background: #ffc107;
            color: #000;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        .order-cta {
            display: none;
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
            gap: 16px;
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
            animation: spin 0.8s linear infinite;
        }
        
        .loading-text {
            font-size: 15px;
            color: #6f4e37;
            font-weight: 500;
        }
        
        .loading-subtext {
            font-size: 13px;
            color: #6c757d;
        }
        
        .location-permission-banner {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-left: 4px solid #ffc107;
            padding: 16px;
            margin: 16px 12px;
            border-radius: 8px;
        }
        
        .location-permission-banner.error {
            background: #f8d7da;
            border-color: #dc3545;
            border-left-color: #dc3545;
        }
        
        .location-permission-banner h3 {
            font-size: 16px;
            margin: 0 0 10px 0;
            color: #856404;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .location-permission-banner.error h3 {
            color: #721c24;
        }
        
        .location-permission-banner p {
            font-size: 14px;
            margin: 0;
            color: #856404;
            line-height: 1.5;
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
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .retry-btn:hover {
            background: #5a3d2a;
        }
        
        .nearest-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: #28a745;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        .nearest-badge i {
            font-size: 9px;
        }
        
        @media (max-width: 480px) {
            .location-card {
                flex-direction: column;
                gap: 12px;
            }
            
            .location-image {
                width: 100%;
                height: 180px;
            }
            
            .location-details {
                width: 100%;
            }
        }
        
        
        .footer {
            max-width: 600px;
            margin: 24px auto 0;
            padding: 16px;
            text-align: center;
            color: #6c757d;
            font-size: 13px;
        }
        
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-bottom: 10px;
            flex-wrap: wrap;
        }
        
        .footer-link {
            color: #6f4e37;
            text-decoration: none;
            font-weight: 400;
            transition: color 0.2s ease;
        }
        
        .footer-link:hover {
            color: #8b6343;
        }
        
        .footer-text {
            margin: 0;
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="loading-overlay">
        <div class="spinner"></div>
        <div class="loading-text">Finding nearest locations...</div>
        <div class="loading-subtext">This will only take a moment</div>
    </div>
    
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <div class="logo">
                <i class="fas fa-coffee" style="color: #6f4e37;"></i>
            </div>
            <div class="header-text">
                <h1>Cafe Aroma</h1>
                <p>Select a location to order</p>
            </div>
        </div>
    </div>
    
    <!-- Location Permission Banner (hidden by default) -->
    <div id="permissionBanner" style="display: none;"></div>
    
    <!-- Location List -->
    <div class="location-container">
        <div class="location-count" id="locationCount">
            <i class="fas fa-store"></i>
            <span><?php echo count($locations); ?> locations available</span>
        </div>
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
                        <i class="fas fa-store" style="font-size: 42px; color: #adb5bd;"></i>
                    <?php endif; ?>
                </div>
                <div class="location-details">
                    <h2 class="location-name">
                        <?php echo htmlspecialchars($location['name']); ?>
                        <?php if ($location['status'] === 'future'): ?>
                            <span class="future-badge">COMING SOON</span>
                        <?php endif; ?>
                    </h2>
                    <p class="location-address">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><?php echo htmlspecialchars($location['address']); ?></span>
                    </p>
                    <p class="location-distance calculating" data-location-id="<?php echo $location['id']; ?>">
                        <i class="fas fa-spinner"></i>
                        <span>Calculating...</span>
                    </p>
                    <p class="location-hours">
                        <i class="far fa-clock"></i>
                        <?php echo htmlspecialchars($location['hours']); ?>
                    </p>
                    <?php if ($location['status'] !== 'future'): ?>
                    <div class="order-cta">
                        <span>Tap to order now</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Footer -->
    <div class="footer">
        <div class="footer-links">
            <a href="#" class="footer-link"><i class="fas fa-info-circle"></i> About Us</a>
            <a href="#" class="footer-link"><i class="fas fa-phone"></i> Contact</a>
            <a href="#" class="footer-link"><i class="fas fa-shield-alt"></i> Privacy</a>
        </div>
        <p class="footer-text">
            <i class="fas fa-coffee"></i> Cafe Aroma &copy; <?php echo date('Y'); ?> | Serving NYC with love
        </p>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Google Maps API -->
    <script>
        // Location data from PHP
        const locations = <?php echo json_encode($locations); ?>;
        let userLocation = null;
        let sortedByDistance = false;
        
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
                    distanceElement.innerHTML = `
                        <i class="fas fa-location-arrow"></i>
                        <span>${formatDistance(location.distance)}</span>
                    `;
                }
                
                // Add "Nearest" badge to the closest location
                const card = document.querySelector(`[data-id="${location.id}"]`);
                if (card && index === 0 && location.status !== 'future') {
                    // Remove any existing nearest badges
                    document.querySelectorAll('.nearest-badge').forEach(badge => badge.remove());
                    
                    const nearestBadge = document.createElement('div');
                    nearestBadge.className = 'nearest-badge';
                    nearestBadge.innerHTML = '<i class="fas fa-star"></i> NEAREST';
                    card.appendChild(nearestBadge);
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
                showCustomAlert('Coming Soon!', 'This location is opening soon. Stay tuned for updates!');
                return;
            }
            
            if (orderUrl) {
                // Add a subtle loading state
                card.style.opacity = '0.6';
                setTimeout(() => {
                    window.location.href = orderUrl;
                }, 150);
            }
        }
        
        // Custom alert function
        function showCustomAlert(title, message) {
            const alertDiv = document.createElement('div');
            alertDiv.style.cssText = `
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: white;
                padding: 20px;
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
                z-index: 10000;
                max-width: 300px;
                width: 90%;
                text-align: center;
            `;
            
            alertDiv.innerHTML = `
                <div style="font-size: 40px; margin-bottom: 12px;">☕</div>
                <h3 style="margin: 0 0 10px 0; color: #2c1810; font-size: 18px; font-weight: 600;">${title}</h3>
                <p style="margin: 0 0 16px 0; color: #6c757d; font-size: 14px;">${message}</p>
                <button onclick="this.parentElement.remove(); document.getElementById('alertOverlay').remove();" 
                        style="background: #6f4e37; color: white; border: none; 
                               padding: 10px 20px; border-radius: 6px; font-size: 14px; font-weight: 500; cursor: pointer;">
                    Got it
                </button>
            `;
            
            const overlay = document.createElement('div');
            overlay.id = 'alertOverlay';
            overlay.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.4);
                z-index: 9999;
            `;
            overlay.onclick = () => {
                alertDiv.remove();
                overlay.remove();
            };
            
            document.body.appendChild(overlay);
            document.body.appendChild(alertDiv);
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            getUserLocation();
        });
    </script>
</body>
</html>

