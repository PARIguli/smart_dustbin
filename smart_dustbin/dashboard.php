<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "smart_dustbin";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) die("Connection failed: " . mysqli_connect_error());
?>

<!DOCTYPE html>
<html>
<head>
    <title>Smart Dustbin Dashboard</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .alert { background: #ffcccc; padding: 10px; margin: 10px 0; }
        .normal { background: #ccffcc; padding: 10px; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h1>🚮 Smart Dustbin Database Dashboard</h1>
    
    <?php
    // Get latest status
    $result = $conn->query("SELECT * FROM dustbin_logs ORDER BY timestamp DESC LIMIT 1");
    if ($row = $result->fetch_assoc()) {
        $status_class = ($row['status'] == 'CRITICAL') ? 'alert' : 'normal';
        echo "<div class='$status_class'>
                <h3>Current Status: {$row['status']}</h3>
                <p>Fill Level: {$row['fill_level']}%</p>
                <p>Last Updated: {$row['timestamp']}</p>
              </div>";
    }
    ?>
    
    <h2>📊 Recent Data Logs</h2>
    <table>
        <tr><th>ID</th><th>Fill Level</th><th>Status</th><th>Timestamp</th></tr>
        <?php
        $result = $conn->query("SELECT * FROM dustbin_logs ORDER BY timestamp DESC LIMIT 10");
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['fill_level']}%</td>
                    <td>{$row['status']}</td>
                    <td>{$row['timestamp']}</td>
                  </tr>";
        }
        ?>
    </table>
    
    <h2>🚨 Test Alerts</h2>
    <p>
        <a href="send_sms.php?level=95" target="_blank">📱 Test SMS Alert</a><br>
        <a href="insert.php?distance=8" target="_blank">🧪 Test Full Dustbin (8cm)</a><br>
        <a href="insert.php?distance=25" target="_blank">🧪 Test Empty Dustbin (25cm)</a>
    </p>
</body>
</html>
<?php mysqli_close($conn); ?>