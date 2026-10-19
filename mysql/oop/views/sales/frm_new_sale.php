<?php
require_once '../../models/Customer.php';
$c = new Customer();
$customers = $c->getAll();
?>

<form action="save_sale.php" method="post">
    <span>Date: </span>
    <input type="date" name="sales_date">
    <span>Customer: </span>
    <select name="customer_id">
        <option></option>
        <?php
        foreach($customers as $c)
        {
            ?>
            <option value="<?php echo $c['id']?>"><?php echo $c['name'];?></option>
            <?php
        }
        ?>
    </select>
    <button>Save</button>
</form>