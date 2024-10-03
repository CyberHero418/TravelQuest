<?php

session_start();
include 'config.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// WeatherAPI.com or OpenWeatherMap API key
$apiKey = 'YOUR_API_KEY'; // Replace with your API key
$location = isset($_GET['location']) ? $_GET['location'] : '';

// Initialize the map with default location if no location is provided yet
$latitude = 23.6850; // Default Latitude (London)
$longitude = 90.3563; // Default Longitude (London)
$weatherData = null;
$weatherError = '';

if ($location) {
    // Fetch weather data for the input location using WeatherAPI or OpenWeatherMap
    $weatherApiUrl = "http://api.weatherapi.com/v1/current.json?key={$apiKey}&q={$location}&aqi=no";
    
    // Initialize cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $weatherApiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        $weatherError = "Could not retrieve weather data. Please try again later.";
    } else {
        $weatherData = json_decode($response, true);
        if ($weatherData && isset($weatherData['location'])) {
            $latitude = $weatherData['location']['lat'];
            $longitude = $weatherData['location']['lon'];
        } else {
            $weatherError = "Could not retrieve weather data for the specified location.";
        }
    }
    
    curl_close($ch);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Forecast Map</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap');
        
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 100vh;
        }

        header {
            background-color: #356698;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            color: #fff;
            font-size: 36px;
            letter-spacing: 2px;
            margin: 0;
        }

        header nav ul {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        header nav ul li a {
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            background-color: #1abc9c;
            border-radius: 50px;
            transition: background-color 0.3s;
            font-weight: 600;
        }

        header nav ul li a:hover {
            background-color: #16a085;
        }

        .map-container {
            width: 100%;
            height: 600px;
            margin: 40px auto;
        }

        .weather-info {
            text-align: center;
            margin: 20px;
            font-size: 18px;
        }

        .weather-info p {
            margin: 10px 0;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #57a3ba;
            color: white;
            font-size: 16px;
            box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <!-- jQuery (for prompt) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>

    <header>
        <h1>TravelQuest</h1>
        <nav>
            <ul>
                <li><a href="./user_dashboard.php">Home</a></li>
                <li><a href="./">Accommodations</a></li>
                <li><a href="./transport.php">Transport</a></li>
                <li><a href="./review&enquiry.php">Reviews and Enquiry</a></li>
                <li><a href="#bookings">Bookings</a></li>
                <li><a href="./weather.php">Weather</a></li>
            </ul>
        </nav>
    </header>

    <div class="weather-info">
        <h2>Weather Forecast for <?php echo htmlspecialchars($location ? $location : 'Unknown Location'); ?></h2>
        <?php if ($weatherData): ?>
            <p><strong>Temperature:</strong> <?php echo htmlspecialchars($weatherData['current']['temp_c']); ?> °C</p>
            <p><strong>Weather:</strong> <?php echo htmlspecialchars($weatherData['current']['condition']['text']); ?></p>
            <p><strong>Humidity:</strong> <?php echo htmlspecialchars($weatherData['current']['humidity']); ?>%</p>
            <p><strong>Wind Speed:</strong> <?php echo htmlspecialchars($weatherData['current']['wind_kph']); ?> kph</p>
        <?php elseif ($weatherError): ?>
            <p class="weather-error"><?php echo $weatherError; ?></p>
        <?php else: ?>
            <p>No weather data available yet. Please select a location.</p>
        <?php endif; ?>
    </div>

    <!-- Map container -->
    <div class="map-container" id="map"></div>

    <footer>
        <p>&copy; 2024 Tourism Management System</p>
    </footer>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        $(document).ready(function() {
            // Ask user for location if it's not provided
            if (!"<?php echo $location; ?>") {
                var userLocation = prompt("Where do you want to visit?");
                if (userLocation) {
                    window.location.href = "weather.php?location=" + encodeURIComponent(userLocation);
                }
            }
        });

        // Initialize the map at the selected location (from PHP variables)
        var latitude = <?php echo $latitude; ?>;
        var longitude = <?php echo $longitude; ?>;
        var map = L.map('map').setView([latitude, longitude], 10);

        // Add the OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Add a marker at the location
        L.marker([latitude, longitude]).addTo(map)
            .bindPopup('Weather Forecast for <?php echo htmlspecialchars($location); ?>')
            .openPopup();
    </script>

</body>
</html>
