<?php
function getUserData() {
    if (!isset($_SESSION['token'])) {
        header('Location: login.php');
        exit();
    }

    // URL API yang membutuhkan otentikasi
    $api_url = 'http://143.198.218.9:8000/api/me'; // Sesuaikan dengan URL API Anda

    // Menggunakan cURL untuk mengirim data dengan Bearer Token
    $curl = curl_init($api_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $_SESSION['token']
    ));

    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        return array('error' => 'Request Error:' . curl_error($curl));
    } else {
        $response_data = json_decode($response, true);
        curl_close($curl);
        return $response_data;
    }

    function logError($message) {
        $logFile = 'log.txt';
        $current = file_get_contents($logFile);
        $current .= date('Y-m-d H:i:s') . " - " . $message . "\n";
        file_put_contents($logFile, $current);
    }
}
?>