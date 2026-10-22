<?php

require_once '../../models/SaleItem.php';
require_once '../../models/Item.php';
//
$i = new Item();
$item = $i->getById($_POST['item_id']);
//
$si = new SaleItem();
$si->id = $_POST['id'] ?? '';
$si->saleId = $_POST['sale_id'];
$si->itemId = $_POST['item_id'];
$si->price = $item['price'];
$si->qty = is_numeric($_POST['qty']) ? $_POST['qty'] : 0;
$result = $si->save();

if ($result != -1) {
    //
    $s = new Sale();
    $s->id = $_POST['sale_id'];
    $s->updateTotal();
    //
    if(!isset($_POST['id']))
    {
        header('location: frm_new_sales_item.php?sale_id=' . $_POST['sale_id']);
    }
    else
    {
        header('location: list.php?sale_id=' . $_POST['sale_id']);
    }
}
