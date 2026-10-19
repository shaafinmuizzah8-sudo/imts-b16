<?php

require_once '../../models/Sale.php';
$s = new Sale();
$s->deleteRec($_GET['id']);

?>