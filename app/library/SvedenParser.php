<?php
namespace App\Library;

use App\Library\Specialization;

class SvedenParser
{
    private \DOMXPath $xpath;
    private string $template;
    private const FIELDS = [
        "eduCode" => "td",
        "eduName" => "td",
        "eduLevel" => "td",
        "eduForm" => "td",
        "numberBF" => "th",
        "numberBFF" => "th",
        "numberBR" => "th",
        "numberBRF" => "th",
        "numberBM" => "th",
        "numberBMF" => "th",
        "numberP" => "th",
        "numberPF" => "th",
        "numberAll" => "th"
    ];

    public function __construct(string $html, string $template)
    {
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHTML($html);
        $this->xpath = new \DOMXPath($dom);
        $this->template = $template;
    }

    private function parse(): array
    {
        $data = array();
        foreach (self::FIELDS as $field => $tag) {
            $data[$field] = $this->xpath->query($this->template . $tag . "[@itemprop=\"$field\"]");
        }
        return $data;
    }

    public function getDataTable() : array
    {
        $data = $this->parse();
        $spec = new Specialization();
        $records = array();

        for ($i = 0; $i < $data['numberAll']->length; $i++) { 
            $spec->update(
                $data['eduCode']->item($i)->textContent,
                $data['eduName']->item($i)->textContent,
                $data['eduLevel']->item($i)->textContent,
                $data['eduForm']->item($i)->textContent,
                (int)$data['numberAll']->item($i)->textContent
            );
            $records[] = $spec->getData();
        }
        return $records;
    }
}