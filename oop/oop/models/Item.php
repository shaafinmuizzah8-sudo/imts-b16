<?php

require_once 'base/BaseModel.php';

class Item extends BaseModel
{
    public $name;
    public $price;

    protected function getTableName()
    {
        return "Items";
    }

    protected function addNewRec()
    {
        $this->lm->log("saving item : ". $this->name);

        $param = array(':name' => $this->name, ':price' => $this->price);
        return $this->pm->run("INSERT INTO Items(name, price) values(:name, :price)", $param);
    }

    protected function updateRec()
    {
        $this->lm->log("updating item : ". $this->name);

        $param = array(':name' => $this->name, ':price' => $this->price, ':id' => $this->id);
        return $this->pm->run("UPDATE Items SET name = :name, price = :price WHERE id = :id", $param);
    }
}
