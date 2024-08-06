<?php
class Specialization
{
    private string $eduCode;
    private string $eduName;
    private string $eduLevel;
    private  string $eduForm;

    public function __construct() {}
    
    public function update(
        string $eduCode,
        string $eduName,
        string $eduLevel,
        string $eduForm
    ) : void {
        $this->eduCode = $eduCode;
        $this->eduName = $eduName;
        $this->eduLevel = $eduLevel;
        $this->eduForm = $eduForm;
    }

    public function getData() : array
    {
        return [
            "Код,шифр" => $this->eduCode,
            "Наименование профессии,
            специальности, направления 
            подготовки, наименование группы
            научных специальностей" => $this->eduName,
            "Уровень образования" => $this->eduLevel,
            "Формы обучения"=> $this->eduForm
        ];
    }
}