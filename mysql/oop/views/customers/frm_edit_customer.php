<?php
require_once '../../models/Customer.php';
$c = new Customer();
$customer = $c->getById($_GET['id']);
?>
<form action="save_customer.php" method="post">
    <input type="hidden" name="id" value="<?php echo $customer['id'];?>" />
    <input type="text" name="name" value="<?php echo $customer['name'];?>" />
    <input type="text" name="mobile" value="<?php echo $customer['mobile'];?>"/>
    <button>Save</button>
</form>