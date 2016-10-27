<?php
$routes = [
    'getAccessToken',
    'getBusinesses',
    'getSingleBusiness',
    'getBusinessesByPhoneNumber',
    'getBusinessesByTransaction',
    'getBusinessReviews',
    'getAutocomplete',
    'metadata'
];
foreach($routes as $file) {
    require __DIR__ . '/../src/routes/'.$file.'.php';
}

