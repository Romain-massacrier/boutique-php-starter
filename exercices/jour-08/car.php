<?php
declare(strict_types=1);

class Car
{
    public string $brand;
    public string $model;
    public int $year;

    public function __construct(string $brand, string $model, int $year)
    {
        $this->brand = $brand;
        $this->model = $model;
        $this->year = $year;
    }

    public function getAge(): int
    {
        return (int) date("Y") - $this->year;
    }

    public function display(): string
    {
        return $this->brand . " " . $this->model . " (" . $this->getAge() . " ans)";
    }
}



$car1 = new Car("Toyota", "Corolla", 2018);
$car2 = new Car("Tesla", "Model 3", 2022);
$car3 = new Car("Renault", "Clio", 2010);

$cars = [$car1, $car2, $car3];


foreach ($cars as $car) {
    echo "<li>" . $car->display() . "</li>";
}

