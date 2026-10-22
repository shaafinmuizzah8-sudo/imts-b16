<?php
require_once '../../models/Item.php';
require_once '../../models/SaleItem.php';
$i = new Item();
$items = $i->getAll();
//
$si = new SaleItem();
$saleItem = $si->getById($_GET['id']);
?>

<form action="save_sales_item.php" method="post">
    <input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
    <input type="hidden" name="sale_id" value="<?php echo $_GET['sale_id'];?>" />
    <span>Item: </span>
    <select name="item_id">
        <option></option>
        <?php
        foreach($items as $i)
        {
            ?>
            <option value="<?php echo $i['id'];?>" <?php if($i['id'] == $saleItem['item_id']) echo "selected";?>><?php echo $i['name'] . " - " . $i['price']."Rs";?></option>
            <?php
        }
        ?>
    </select>
    <span>Qty: </span>
    <input type="text" name="qty" value="<?php echo $saleItem['qty'];?>">
    <button>Save</button>
</form>

<a href="list.php?sale_id=<?php echo $_GET['sale_id'];?>">Done</a>