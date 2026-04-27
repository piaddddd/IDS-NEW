<?php
require 'conn.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="motion_logs.csv"');

$output = fopen("php://output", "w");

// Column headers
fputcsv($output, ['Location', 'Timestamp']);

// Get data
$result = $conn->query("SELECT location, timestamp FROM motion_alerts");

while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
exit();