<?php
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
    // Численность обучающихся
    private array $size;
    

    public function __construct() {}

    public function update(
        string $eduCode,
        string $eduName,
        string $eduLevel,
        string $eduForm,
        array $size
    ) : void {
        $this->eduCode = $eduCode;
        $this->eduName = $eduName;
        $this->eduLevel = $eduLevel;
        $this->eduForm = $eduForm;
        $this->size = $size;
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
            "Формы обучения"=> $this->eduForm,
            "Численность обучающихся/ из них иностранных 
            граждан за счет (количество человек):" => $this->size
        ];
    }
}