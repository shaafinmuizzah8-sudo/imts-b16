<?php

require_once '../../models/Item.php';
$i = new Item();
$result = $i->deleteRec($_GET['id']);
if($result != -1)
{
    header('location: list.php');
}
?>