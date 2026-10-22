<?php
// Represents a car and stores its make, model, and year.
class Car
{
    // Properties
    public $make;
    public $model;
    public $year;

    // methods
    public function getCarInfo()
    {
        echo "{$this->year} | {$this->make} | {$this->model}";
    }

    public function setCarInfo($make, $model, $year)
    {
        $this->make = $make;
        $this->model = $model;
        $this->year = $year;
    }
}

// Represents a fruit and stores its name, color, and taste.
class Fruit
{
    // Properties
    public $name;
    public $color;
    public $taste;

    // methods
    public function getFruitInfo()
    {
        echo "{$this->name} | {$this->color} | {$this->taste}";
    }

    public function setFruitInfo($name, $color, $taste = "Spicy")
    {
        $this->name = $name;
        $this->color = $color;
        $this->taste = $taste;
    }
}

// Represents a vegetable and initializes its name, color, and taste.
class Vegetable
{
    // Properties
    public $name;
    public $color;
    public $taste;

    public function __construct($name, $color, $taste = "Bitter")
    {
        $this->name = $name;
        $this->color = $color;
        $this->taste = $taste;
    }

    // methods
    public function getVegetableInfo()
    {
        echo "{$this->name} | {$this->color} | {$this->taste}";
    }
}

// Represents an animal and displays its details when destroyed.
class  Animal
{
    // Properties
    public $name;
    public $species;
    public $sound;

    public function __construct($name, $species, $sound = "Roar")
    {
        $this->name = $name;
        $this->species = $species;
        $this->sound = $sound;
    }

    public function __destruct()
    {
        echo "<h2>Animal Class</h2>";
        echo "{$this->name} | {$this->species} | {$this->sound}";
    }
}

$cat = new Animal('Cat', 'Feline', 'Meow');


echo "<br>";
echo "<h2>Vegetable Class</h2>";

$carrot = new Vegetable('Carrot', 'Orange');
$carrot->getVegetableInfo(); // Output: Carrot | Orange | Bitter


$broccoli = new Vegetable('Broccoli', 'Green', 'Sour');
$broccoli->getVegetableInfo(); // Output: Broccoli | Green | Sour

echo "<br>";

$spinach = new Vegetable('Spinach', 'Green');
$spinach->getVegetableInfo(); // Output: Spinach | Green | Sweet

echo "<br>";

echo "<h2>Fruit Class</h2>";

$apple = new Fruit();
$apple->setFruitInfo("Apple", "Red");

$apple->getFruitInfo(); // Output: Apple | Red | Spicy
echo "<br>";

$banana = new Fruit();
$banana->setFruitInfo("Banana", "Yellow", "Sweet");
$banana->getFruitInfo(); // Output: Banana | Yellow | Sweet

echo "<br>";
echo "<h2>Car Class</h2>";

$benz = new Car();
$benz->setCarInfo("Mercedes-Benz", "C-Class", 2022);
$benz->getCarInfo(); // Output: 2022 | Mercedes-Benz | C-Class

echo "<br>";

$bmw = new Car();
$bmw->setCarInfo("BMW", "3 Series", 2021);
$bmw->getCarInfo(); // Output: 2021 | BMW | 3 Series

echo "<br><br>";
echo "<h2>Instance of</h2>";

if ($apple instanceof Fruit) {
    echo "<br>Apple is an instance of Fruit class";
}

if ($benz instanceof Car) {
    echo "<br>BenZ is an instance of Car class";
}

echo "<br><br><br> Here is the list of all classes in this file: <br><br><br>";

//