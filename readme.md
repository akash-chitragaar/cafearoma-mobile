# Cafe Adora Mobile - Location Selector

A mobile-optimized location selector page for Cafe Adora that displays nearby locations sorted by distance from the user.

## Features

- **Location-Based Sorting**: Uses browser Geolocation API to get user's location
- **Distance Calculation**: Calculates distances using Haversine formula (no external API required)
- **Auto-Sort**: Automatically sorts locations from closest to farthest
- **Mobile-First Design**: Optimized for mobile devices with clean, card-based layout
- **Bootstrap 5**: Responsive design using Bootstrap framework
- **JSON Data Source**: Location data stored in `locations.json` for easy updates

## Files

- `index.php` - Main location selector page
- `locations.json` - Location data (addresses, coordinates, hours, etc.)
- `assets/` - Images and other static resources

## Location Data Structure

Each location in `locations.json` contains:
- `id` - Unique identifier
- `name` - Location name
- `address` - Short address for display
- `full_address` - Complete address with city and zip
- `phone` - Contact number
- `hours` - Operating hours
- `lat` - Latitude coordinate
- `lng` - Longitude coordinate
- `image` - Image path (optional)
- `order_url` - Link to ordering system
- `status` - "open" or "future"

## How It Works

1. Page loads with all locations shown
2. Browser requests user's location permission
3. If granted, calculates distance to each location
4. Sorts locations by distance (closest first)
5. Updates distance display (feet or miles)
6. User can click any location to proceed to ordering

## Distance Calculation

Uses the Haversine formula to calculate "as the crow flies" distance between two GPS coordinates:
- Accurate for short distances
- No external API calls needed
- Fast calculation
- Works offline

## Fallback Behavior

If location access is denied or unavailable:
- Shows locations in default order
- Displays warning banner with instructions
- All functionality remains intact
- User can retry location access

## Browser Compatibility

- Chrome/Edge: Full support
- Safari: Full support  
- Firefox: Full support
- Requires HTTPS for geolocation in production

## Setup

1. Ensure PHP is installed and running
2. Place files in web server directory
3. Access via `index.php`
4. Grant location permission when prompted

## Customization

### Update Locations
Edit `locations.json` to add/remove/modify locations

### Change Colors
Primary color: `#6f4e37` (brown)
Accent color: `#28a745` (green)

### Add Images
Place location images in `assets/images/` and update JSON file

## Future Enhancements

- Google Maps Distance Matrix API integration for driving distances
- Real-time availability status
- Location photos
- Turn-by-turn directions
- Estimated travel time
- Operating hours status (open/closed)

