<?php

require_once '../../models/Sale.php';
//
$sale = new Sale();
$sale->id = $_POST['id'] ?? '';
$sale->salesDate = $_POST['sales_date'];
$sale->customerId = $_POST['customer_id'];
$result = $sale->save();
if($result != -1)
{
    header('location: list.php');
}
?>