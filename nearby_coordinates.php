<?php

// Kullanıcının konumunu al
$latitude = $_GET['latitude'];
$longitude = $_GET['longitude'];

// Veritabanındaki tüm kayıtları al
$query = "SELECT * FROM locations";
$result = mysqli_query($conn, $query);

// En yakın kaydı bul
$closest_distance = 999999999999;
$closest_location = null;
while ($row = mysqli_fetch_assoc($result)) {
    $distance = haversine_distance($latitude, $longitude, $row['latitude'], $row['longitude']);
    if ($distance < $closest_distance) {
        $closest_distance = $distance;
        $closest_location = $row;
    }
}

// En yakın kaydı döndür
echo json_encode($closest_location);

// Haversine formülü fonksiyonu
function haversine_distance($lat1, $lon1, $lat2, $lon2) {
    $radius = 6371;

    $lat1 = deg2rad($lat1);
    $lon1 = deg2rad($lon1);
    $lat2 = deg2rad($lat2);
    $lon2 = deg2rad($lon2);

    $delta_lat = $lat2 - $lat1;
    $delta_lon = $lon2 - $lon1;

    $a = sin($delta_lat/2) * sin($delta_lat/2) + cos($lat1) * cos($lat2) * sin($delta_lon/2) * sin($delta_lon/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));

    $distance = $radius * $c;

    return $distance;
}

?>
