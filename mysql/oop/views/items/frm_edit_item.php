<?php
require_once '../../models/Item.php';
$i = new Item();
$item = $i->getById($_GET['id']);
?>
<form action="save_item.php" method="post">
    <input type="hidden" name="id" value="<?php echo $item['id'];?>" />
    <input type="text" name="name" value="<?php echo $item['name'];?>" />
    <input type="text" name="price" value="<?php echo $item['price'];?>"/>
    <button>Save</button>
</form>