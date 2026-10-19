<?php

require_once '../../models/SaleItem.php';
//
$i = new SaleItem();
$saleItem = $i->getById($_GET['id']);
//
$result = $i->deleteRec($_GET['id']);
if($result != -1)
{
    $s = new Sale();
    $s->id = $saleItem['sale_id'];
    $s->updateTotal();
    //
    header('location: list.php?sale_id=' . $saleItem['sale_id']);
}
