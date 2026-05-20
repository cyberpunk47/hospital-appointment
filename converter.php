<?php

$json = file_get_contents('cities.json');
$data = json_decode($json, true);

$result = [];

foreach ($data as $item) {

    $state = $item['state'];
    $city  = $item['name'] ?? $item['city'];

    if (!isset($result[$state])) {
        $result[$state] = [];
    }

    if (!in_array($city, $result[$state])) {
        $result[$state][] = $city;
    }
}

$output = "<?php\n";
$output .= "// config/indian_cities.php\n\n";
$output .= "return [\n";

foreach ($result as $state => $cities) {

    $output .= '    "' . addslashes($state) . '" => [';

    $cityStrings = [];

    foreach ($cities as $city) {
        $cityStrings[] = '"' . addslashes($city) . '"';
    }

    $output .= implode(', ', $cityStrings);

    $output .= "],\n";
}

$output .= "];";

file_put_contents('indian_cities.php', $output);

echo "Done!";