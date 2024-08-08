<?php
namespace App;

use App\Library\SvedenParser;
use App\Library\Database;
use GuzzleHttp\Client;

$dbconfig = [
    "host" => "localhost",
    "dbname" => "opendata",
    "user" => "alexander",
    "password" => "Aa123456!"
];

$client = new Client();
$response = $client->get('https://marsu.ru/sveden/education/eduChislen.php');
$html = $response->getBody()->getContents();

$parser = new SvedenParser($html, '//tr[@itemprop="eduChislen"]//');
$data = $parser->getDataTable();

$db = new Database(
    "mysql:host={$dbconfig['host']};dbname={$dbconfig['dbname']}", 
    $dbconfig['user'],
    $dbconfig['password']
);

// print_r($data);

// $db->insert('sveden_table_education', $data);
$data = $db->select('sveden_table_education');

print_r($data);