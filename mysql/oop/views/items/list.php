<?php
require_once '../../models/Item.php';
$i = new Item();
$items = $i->getAll();
?>

<a href="../../index.php">Home</a> |
<a href="frm_new_item.php">Add new item</a><br><br>

<table border="1">
    <tr>
        <th>Name</th>
        <th>Price</th>
        <th>Action</th>
    </tr>
    <?php
    foreach($items as $i)
    {
        ?>
        <tr>
            <td><?php echo $i['name'];?></td>
            <td><?php echo $i['price'];?></td>
            <td>
                <a href="frm_edit_item.php?id=<?php echo $i['id'];?>">Edit</a> | 
                <a href="delete.php?id=<?php echo $i['id'];?>">Delete</a> 
            </td>
        </tr>
        <?php
    }
    ?>
</table>