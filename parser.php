<?php
require 'vendor/autoload.php';
require_once 'Specialization.php';
require_once 'Size.php';

use GuzzleHttp\Client;

const TEMPLATE = '//tr[@itemprop="eduChislen"]//';

$fields = [
    'eduCode' => 'td',
    'eduName' => 'td',
    'eduLevel' => 'td',
    'eduForm' => 'td',
    'numberBF' => 'th',
    'numberBFF' => 'th',
    'numberBR' => 'th',
    'numberBRF' => 'th',
    'numberBM' => 'th',
    'numberBMF' => 'th',
    'numberP' => 'th',
    'numberPF' => 'th',
    'numberAll' => 'th',
];
$data = [];

$client = new Client();
$response = $client->get('https://marsu.ru/sveden/education/eduChislen.php');
$html = $response->getBody()->getContents();
libxml_use_internal_errors(true);

$dom = new DOMDocument();
$dom->loadHTML($html);
$xpath = new DOMXPath($dom);

foreach ($fields as $field => $tag) {
    $data[$field] = $xpath->query(TEMPLATE . $tag . "[@itemprop=\"$field\"]");
}

// echo "<pre>";
// print_r($data);
// echo "</pre>";

$specialization = new Specialization();
$sizeFederalBudget = new Size();
$sizeRussianBudget = new Size();
$sizeLocalBudget = new Size();
$sizeIndividualsOrLegalEntitiesBudget = new Size();
$records = array();
$size = array();

for ($i = 0; $i < $data['numberAll']->length; $i++) {

    $sizeFederalBudget->update(
        $data['numberBF']->item($i)->textContent,
        $data['numberBFF']->item($i)->textContent
    );
    $size['бюджетных ассигнований федерального бюджета'] = $sizeFederalBudget->getData();
    
    $sizeRussianBudget->update(
        $data['numberBR']->item($i)->textContent,
        $data['numberBRF']->item($i)->textContent
    );
    $size['бюджетов субъектов Российской Федерации'] = $sizeRussianBudget->getData();

    $sizeLocalBudget->update(
        $data['numberBM']->item($i)->textContent,
        $data['numberBMF']->item($i)->textContent
    );
    $size['местных бюджетов'] = $sizeLocalBudget->getData();

    $sizeIndividualsOrLegalEntitiesBudget->update(
        $data['numberP']->item($i)->textContent,
        $data['numberPF']->item($i)->textContent
    );
    $size['средств физических  и (или) юридических лиц'] = $sizeIndividualsOrLegalEntitiesBudget->getData();

    $size['Общая численность обучающихся'] = (int)$data['numbersAll']->textContent;
    $specialization->update(
        $data['eduCode']->item($i)->textContent,
        $data['eduName']->item($i)->textContent,
        $data['eduLevel']->item($i)->textContent,
        $data['eduForm']->item($i)->textContent,
        $size
    );
    $records[] = $specialization->getData();
    $size = [];
}

// var_dump($specialization);
echo "<pre>";
print_r($records);
echo "</pre>";