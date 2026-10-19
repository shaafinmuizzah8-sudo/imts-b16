<?php
require '../../models/Customer.php';
require '../../models/Sale.php';
//
$c = new Customer();
$customers = $c->getAll();
//
$s = new Sale();
$sale = $s->getById($_GET['id']);
?>

<form action="save_sale.php" method="post">
    <input type="hidden" name="id" value="<?php echo $sale['id'];?>" />
    <span>Date: </span>
    <input type="date" name="sales_date" value="<?php echo $sale['sales_date'];?>">
    <span>Customer: </span>
    <select name="customer_id">
        <option></option>
        <?php
        foreach($customers as $c)
        {
            ?>
            <option value="<?php echo $c['id']?>" <?php if($c['id'] == $sale['customer_id']) echo "selected";?>><?php echo $c['name'];?></option>
            <?php
        }
        ?>
    </select>
    <button>Save</button>
</form>