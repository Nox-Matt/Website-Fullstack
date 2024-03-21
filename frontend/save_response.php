
<? if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = json_decode($_POST['response'], true);
    $jsonData = json_encode($response);

    // Save JSON data to a file
    $file = fopen('response.json', 'w');
    fwrite($file, $jsonData);
    fclose($file);
}
?>