<?php

require_once 'base/BaseModel.php';
require_once 'SaleItem.php';

class Sale extends BaseModel
{
    public $salesDate;
    public $customerId;
    public $total;

    protected function getTableName()
    {
        return "Sales";
    }

    public function getAll()
    {
        return $this->pm->run("SELECT s.id, s.sales_date, s.total, c.name as customer_name FROM Sales s, Customers c where s.customer_id = c.id");
    }

    public function getDetailById($id)
    {
        $param = array(':sale_id' => $id);
        return $this->pm->run("SELECT s.id, s.sales_date, s.total, c.name as customer_name FROM Sales s, Customers c where s.customer_id = c.id and s.id = :sale_id", $param, true);
    }

    protected function addNewRec()
    {
        $param = array(':sales_date' => $this->salesDate, ':customer_id' => $this->customerId);
        return $this->pm->run("INSERT INTO Sales(sales_date, customer_id) values(:sales_date, :customer_id)", $param);
    }

    protected function updateRec()
    {
        $param = array(':sales_date' => $this->salesDate, ':customer_id' => $this->customerId, ':id' => $this->id);
        return $this->pm->run("UPDATE Sales SET sales_date = :sales_date, customer_id = :customer_id WHERE id = :id", $param);
    }

    public function deleteRec($id)
    {
        $saleItem = new SaleItem();
        $saleItem->deleteAllBySaleId($id);
        //
        $result = parent::deleteRec($id);
        if ($result != -1) {
            header('location: list.php');
        }
    }

    public function updateTotal()
    {
        $param = array(':sale_id' => $this->id, ':id' => $this->id);
        $this->pm->run("UPDATE Sales set total = (SELECT SUM(price * qty) FROM Sales_Items where sale_id = :sale_id) where id = :id", $param);
    }
}
