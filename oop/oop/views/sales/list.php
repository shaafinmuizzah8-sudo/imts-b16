<?php
require_once '../../models/Sale.php';
$s = new Sale();
$sales = $s->getAll();
?>

<a href="../../index.php">Home</a> |
<a href="frm_new_sale.php">Add new sale</a><br><br>

<table border="1">
    <tr>
        <th>Sales Date</th>
        <th>Customer</th>
        <th>Total</th>
        <th>Action</th>
    </tr>
    <?php
    foreach($sales as $s)
    {
        ?>
        <tr>
            <td><?php echo $s['sales_date'];?></td>
            <td><?php echo $s['customer_name'];?></td>
            <td><?php echo $s['total'];?></td>
            <td>
                <a href="frm_edit_sale.php?id=<?php echo $s['id'];?>">Edit</a> | 
                <a href="delete.php?id=<?php echo $s['id'];?>">Delete</a> |
                <a href="../sale-items/list.php?sale_id=<?php echo $s['id'];?>">Detail</a> 
            </td>
        </tr>
        <?php
    }
    ?>
</table>