<?php

require_once '../../models/Customer.php';
$c = new Customer();
$result = $c->deleteRec($_GET['id']);
if($result != -1)
{
    header('location: list.php');
}
?>