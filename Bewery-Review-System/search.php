<?php
if (isset($_GET['search-type']) && isset($_GET['query'])) {
    $searchType = $_GET['search-type'];
    $query = urlencode($_GET['query']);

    switch ($searchType) {
        case 'by_name':
            $apiUrl = "https://api.openbrewerydb.org/breweries?by_name=$query";
            break;
        case 'by_city':
            $apiUrl = "https://api.openbrewerydb.org/breweries?by_city=$query";
            break;
        case 'by_type':
            $apiUrl = "https://api.openbrewerydb.org/breweries?by_type=$query";
            break;
        default:
            echo json_encode([]);
            exit;
    }

    $response = file_get_contents($apiUrl);
    if ($response !== FALSE) {
        $breweries = json_decode($response, true);
        echo json_encode($breweries);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>
