<?php

class Person
{
    public string $name = 'muizzah';       // Accessible from anywhere
    protected int $age = 17;             // Accessible in this class and subclasses
    private string $password = 'secret'; // Accessible only in this class

    public function introduce(): string
    {
        return "Hi, I'm {$this->name}, age {$this->age}.";
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}

class Employee extends Person
{
    public function getAge(): int
    {
        return $this->age; // Protected members are available to subclasses
    }
}

$person = new Person();
echo $person->name . "<br>";
echo $person->introduce() . "<br>";
// echo $person->age;      // Error: protected
// echo $person->password; // Error: private

$employee = new Employee();
echo $employee->getAge() . "<br>";
