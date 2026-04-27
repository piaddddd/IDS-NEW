<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $motion = $_POST['motion'];
    
    // Save motion status in a file (or database)
    file_put_contents("motion_status.txt", $motion);
    
    echo "Motion status updated: " . $motion;
}
?>
