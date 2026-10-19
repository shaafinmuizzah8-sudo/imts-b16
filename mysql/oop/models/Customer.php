<?php

require_once 'base/BaseModel.php';

class Customer extends BaseModel
{
    public $name;
    public $mobile;

    protected function getTableName()
    {
        return "Customers";
    }

    protected function addNewRec()
    {
        $this->lm->log("saving customer : ". $this->name);
        //
        $param = array(':name' => $this->name, ':mobile' => $this->mobile);
        return $this->pm->run("INSERT INTO Customers(name, mobile) values(:name, :mobile)", $param);
    }

    protected function updateRec()
    {
        $this->lm->log("updating customer : ". $this->name);
        //
        $param = array(':name' => $this->name, ':mobile' => $this->mobile, ':id' => $this->id);
        return $this->pm->run("UPDATE Customers SET name = :name, mobile = :mobile WHERE id = :id", $param);
    }
}
