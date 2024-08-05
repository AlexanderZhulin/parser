<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;

const MAX_COUNT_PARAMETERS = 13;

$client = new Client();
$response = $client->get('https://marsu.ru/sveden/education/eduChislen.php');
$html = $response->getBody()->getContents();
libxml_use_internal_errors(true);

$dom = new \DOMDocument();
$dom->loadHTML($html);
$xpath = new DOMXPath($dom);

// $rows = $xpath->evaluate('//tr[@itemprop="eduChislen"]');
$rows = $xpath->evaluate('//tr[@itemprop="eduChislen"]//th|//tr[@itemprop="eduChislen"]//td');

$countParameters = 0;
$record = array();
$records = array();

foreach ($rows as $row) {
    if ($countParameters >= MAX_COUNT_PARAMETERS) {
        $countParameters = 0;
        $record = [];
        echo '<br>';
    }
    $record[] = $row->textContent;
    echo $row->textContent . '|';
    $countParameters++;
}

var_dump($records);