<?php
require_once '../../models/Customer.php';
$customerModel = new Customer();
$customers = $customerModel->getAll();
?>

<a href="../../index.php">Home</a> |
<a href="frm_new_customer.php">Add new customer</a><br><br>

<table border="1">
    <tr>
        <th>Name</th>
        <th>Mobile</th>
        <th>Action</th>
    </tr>
    <?php foreach ($customers as $customer): ?>
        <tr>
            <td><?php echo htmlspecialchars($customer['name']); ?></td>
            <td><?php echo htmlspecialchars($customer['mobile']); ?></td>
            <td>
                <a href="frm_edit_customer.php?id=<?php echo (int)$customer['id']; ?>">Edit</a> |
                <a href="delete.php?id=<?php echo (int)$customer['id']; ?>"
                    onclick="return confirm('Delete this customer?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>