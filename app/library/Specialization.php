<?php
namespace App\Library;
// Специальность, направление подготовки
class Specialization
{
    // Код специальности
    private string $eduCode;
    // Название специальности, направления подготовки
    private string $eduName;
    //Уровень образования
    private string $eduLevel;
    //Формы обучения
    private  string $eduForm;
    // Общая численность обучающихся
    private int $contingent;

    public function __construct() {}
    
    public function update(
        string $eduCode,
        string $eduName,
        string $eduLevel,
        string $eduForm,
        int $contingent
    ) : void {
        $this->eduCode = $eduCode;
        $this->eduName = $eduName;
        $this->eduLevel = $eduLevel;
        $this->eduForm = $eduForm;
        $this->contingent = $contingent;
    }

    public function getData() : array
    {
        return [
            "eduCode" => $this->eduCode,
            "eduName" => $this->eduName,
            "eduLevel" => $this->eduLevel,
            "edoForms"=> $this->eduForm,
            "contingent" => $this->contingent
        ];
    }
}