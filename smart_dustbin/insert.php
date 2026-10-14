<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "smart_dustbin";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get distance from NodeMCU
$distance = $_GET['distance'] ?? 0;
$dustbin_id = "DUSTBIN_01";

// Convert distance to fill level
$fill_level = calculateFillLevel($distance);

// Determine status
if ($fill_level >= 90) $status = 'CRITICAL';
elseif ($fill_level >= 70) $status = 'FULL';
elseif ($fill_level >= 40) $status = 'MEDIUM';
else $status = 'EMPTY';

// Insert into database
$sql = "INSERT INTO dustbin_logs (dustbin_id, fill_level, status) VALUES ('$dustbin_id', $fill_level, '$status')";

if (mysqli_query($conn, $sql)) {
    $response = "Data inserted! Distance: " . $distance . "cm | Level: " . $fill_level . "% | Status: " . $status;
    
    // If critical, trigger SMS
    if ($status == 'CRITICAL') {
        triggerSMS($fill_level, $distance);
        $response .= " | SMS Alert Sent!";
    }
    
    echo $response;
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);

function calculateFillLevel($distance) {
    $empty_distance = 30;
    $full_distance = 5;
    
    if ($distance <= $full_distance) return 100;
    if ($distance >= $empty_distance) return 0;
    
    $level = (($empty_distance - $distance) / ($empty_distance - $full_distance)) * 100;
    return intval($level);
}

function triggerSMS($level, $distance) {
    $sms_url = "http://localhost/smart_dustbin/send_sms.php?level=" . $level . "&distance=" . $distance;
    @file_get_contents($sms_url);
}
?>