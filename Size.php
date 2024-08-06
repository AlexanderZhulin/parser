<?php
class Size
{
    private int $all;
    private int $foreigners;
    public function __construct() {}

    public function update(
        int|string $all,
        int|string $foreigners
    ): void {
        $this->all = (int)$all;
        $this->foreigners = (int)$foreigners;
    }

    public function getData(): array{
        return [
            "Всего" => $this->all,
            "Из них численность обучающихся, 
            являющихся иностранными гражданами" => $this->foreigners
        ];
    }
}