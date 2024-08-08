<?php
namespace App\Library;

use PDO;
use PDOException;

class Database extends PDO
{
    public function __construct($dsn, $username, $password)
    {
        try {
            parent::__construct(
                $dsn, 
                $username, 
                $password, 
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            echo "Подлючено успешно!\n";
        } catch (PDOException $e) {
            echo "Ошибка подключения:". $e->getMessage() . "\n";
        }
    }

    public function __destruct()
    {
        echo "Подключение прервано!\n";
    }
    
    public function insert(string $table, array $data) : void
    {
        $stmt = $this->prepare("
            INSERT INTO sveden_table_education
                (edu_code, edu_name, edu_form, edu_level, contingent)
            VALUES 
                (:edu_code, :edu_name, :edu_form, :edu_level, :contingent)"
        );
        foreach ($data as $row) {
            try {
                $stmt->bindParam(':edu_code', $row['eduCode']);
                $stmt->bindParam(':edu_name', $row['eduName']);
                $stmt->bindParam(':edu_form', $row['edoForms']);
                $stmt->bindParam(':edu_level', $row['eduLevel']);
                $stmt->bindParam(':contingent', $row['contingent']);

                $stmt->execute();
            } catch (PDOException $e) {    
                echo "Ошибка запроса: " . $e->getMessage() . "\n";    
            }
        }
    }

    public function select(string $table) : array
    {
        $stmt = $this->prepare("SELECT * FROM $table");
        try {
            $stmt->execute();
            $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Ошибка запроса: " . $e->getMessage() . "\n";  
        } finally {
            return $array;
        }
    }
}