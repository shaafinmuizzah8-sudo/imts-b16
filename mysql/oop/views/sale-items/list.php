<?php
require_once '../../models/SaleItem.php';
require_once '../../models/Sale.php';
require_once '../../models/Customer.php';
//
$s = new Sale();
$sale = $s->getDetailById($_GET['sale_id']);
//
$si = new SaleItem();
$si->saleId = $_GET['sale_id'];
$saleItems = $si->getAll();
?>

<a href="frm_new_sales_item.php?sale_id=<?php echo $_GET['sale_id'];?>">Add new sale items</a><br><br>

<table border="1">
    <tr>
        <td>Date</td>
        <td><?php echo $sale['sales_date'];?></td>
    </tr>
    <tr>
        <td>Customer</td>
        <td><?php echo $sale['customer_name'];?></td>
    </tr>
    <tr>
        <td>Total</td>
        <td><?php echo $sale['total'];?></td>
    </tr>
</table>
<br/>
<br/>
<br/>
<table border="1">
    <tr>
        <th>Item</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Action</th>
    </tr>
    <?php
    foreach($saleItems as $si)
    {
        ?>
        <tr>
            <td><?php echo $si['item_name'];?></td>
            <td><?php echo $si['price'];?></td>
            <td><?php echo $si['qty'];?></td>
            <td>
                <a href="frm_edit_sales_item.php?id=<?php echo $si['id'];?>&sale_id=<?php echo $_GET['sale_id'];?>">Edit</a> | 
                <a href="delete.php?id=<?php echo $si['id'];?>">Delete</a>
            </td>
        </tr>
        <?php
    }
    ?>
</table>