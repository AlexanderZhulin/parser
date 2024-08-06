<?php
require 'vendor/autoload.php';
require_once 'Specialization.php';
require_once 'Size.php';

use GuzzleHttp\Client;

const MAX_COUNT_PARAMETERS = 13;
const TEMPLATE = '//tr[@itemprop="eduChislen"]//';

$client = new Client();
$response = $client->get('https://marsu.ru/sveden/education/eduChislen.php');
$html = $response->getBody()->getContents();
libxml_use_internal_errors(true);

$dom = new DOMDocument();
$dom->loadHTML($html);
$xpath = new DOMXPath($dom);

$eduCodes = $xpath->query(TEMPLATE . 'td[@itemprop="eduCode"]');
$eduNames = $xpath->query(TEMPLATE . 'td[@itemprop="eduName"]');
$eduLevels = $xpath->query(TEMPLATE . 'td[@itemprop="eduLevel"]');
$eduForms = $xpath->query(TEMPLATE . 'td[@itemprop="eduForm"]');
$numbersBF = $xpath->query(TEMPLATE . 'th[@itemprop="numberBF"]');
$numbersBFF = $xpath->query(TEMPLATE . 'th[@itemprop="numberBFF"]');
$numbersBR = $xpath->query(TEMPLATE . 'th[@itemprop="numberBR"]');
$numbersBRF = $xpath->query(TEMPLATE . 'th[@itemprop="numberBRF"]');
$numbersBM = $xpath->query(TEMPLATE . 'th[@itemprop="numberBM"]');
$numbersBMF = $xpath->query(TEMPLATE . 'th[@itemprop="numberBMF"]');
$numbersP = $xpath->query(TEMPLATE . 'th[@itemprop="numberP"]');
$numbersPF = $xpath->query(TEMPLATE . 'th[@itemprop="numberPF"]');
$numbersAll = $xpath->query(TEMPLATE . 'th[@itemprop="numberAll"]');

$specialization = new Specialization();
$sizeFederalBudget = new Size();
$sizeRussianBudget = new Size();
$sizeLocalBudget = new Size();
$sizeIndividualsOrLegalEntitiesBudget = new Size();
$records = array();
$size = array();

for ($i = 0; $i < $numbersAll->length; $i++) {
    $specialization->update(
        $eduCodes->item($i)->textContent,
        $eduNames->item($i)->textContent,
        $eduLevels->item($i)->textContent,
        $eduForms->item($i)->textContent
    );
    $record['Направление'] = $specialization->getData();

    $sizeFederalBudget->update(
        $numbersBF->item($i)->textContent,
        $numbersBFF->item($i)->textContent
    );
    $size['бюджетных ассигнований федерального бюджета'] = $sizeFederalBudget->getData();
    
    $sizeRussianBudget->update(
        $numbersBR->item($i)->textContent,
        $numbersBRF->item($i)->textContent
    );
    $size['бюджетов субъектов Российской Федерации'] = $sizeRussianBudget->getData();

    $sizeLocalBudget->update(
        $numbersBM->item($i)->textContent,
        $numbersBMF->item($i)->textContent
    );
    $size['местных бюджетов'] = $sizeLocalBudget->getData();

    $sizeIndividualsOrLegalEntitiesBudget->update(
        $numbersP->item($i)->textContent,
        $numbersPF->item($i)->textContent
    );
    $size['средств физических  и (или) юридических лиц'] = $sizeIndividualsOrLegalEntitiesBudget->getData();

    $size['Общая численность обучающихся'] = (int)$numbersAll->textContent;
    $record['Численность обучающихся/ из них иностранных 
        граждан за счет (количество человек):'] = $size;
    
    $records[] = $record;
    $record = [];
    $size = [];
}