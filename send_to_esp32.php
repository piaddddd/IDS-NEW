<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $ssid = $_POST["ssid"];
    $password = $_POST["password"];

    // CHANGE THIS TO YOUR ESP32 IP (AP MODE OR CURRENT IP)
    $esp32_ip = "192.168.1.19";

    $url = "http://$esp32_ip/wifi";

    $data = http_build_query([
        "ssid" => $ssid,
        "password" => $password
    ]);

    $options = [
        "http" => [
            "header"  => "Content-type: application/x-www-form-urlencoded",
            "method"  => "POST",
            "content" => $data,
            "timeout" => 5
        ]
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        echo "❌ Failed to connect to ESP32";
    } else {
        echo "✅ WiFi Sent to ESP32";
        echo "<br><pre>$result</pre>";
    }

}
?>