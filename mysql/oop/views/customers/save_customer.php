<?php
require_once '../../models/Customer.php';
//
$customer = new Customer();
$customer->id = $_POST['id'] ?? '';
$customer->name = $_POST['name'];
$customer->mobile = $_POST['mobile'];
$result = $customer->save();
if ($result != -1) {
    header('location: list.php');
}
