<?php
$routes = [
    'getAccessToken',
    'getBusinesses',
    'getSingleBusiness',
    'getBusinessesByPhoneNumber',
    'getBusinessesByTransaction',
    'getBusinessReviews',
    'getAutocomplete',
    'getSingleEvent',
    'searchEvent',
    'getFeaturedEvent',
    'matchedBusinesses',
    'metadata'
];
foreach($routes as $file) {
    require __DIR__ . '/../src/routes/'.$file.'.php';
}

