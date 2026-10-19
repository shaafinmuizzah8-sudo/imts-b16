<?php

require_once '../../models/Item.php';
//
$item = new Item();
$item->id = $_POST['id'] ?? '';
$item->name = $_POST['name'];
$item->price = is_numeric($_POST['price']) ? $_POST['price'] : 0;
$result = $item->save();
if($result != -1)
{
    header('location: list.php');
}
?>