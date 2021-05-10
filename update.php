<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the employee id exists, for example update.php?id=1 will get the employee with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $position = isset($_POST['position']) ? $_POST['position'] : '';
        $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
        // Update the record
        $stmt = $pdo->prepare('UPDATE employees SET id = ?, name = ?, email = ?, phone = ?, position = ?, created = ? WHERE id = ?');
        $stmt->execute([$id, $name, $email, $phone, $position, $created, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the employee from the employees table
    $stmt = $pdo->prepare('SELECT * FROM employees WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$employee) {
        exit('employee doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>
<?=template_header('Read')?>

<div class="content update">
	<h2>Update employee #<?=$employee['id']?></h2>
    <form action="update.php?id=<?=$employee['id']?>" method="post">
        <label for="id">ID</label>
        <label for="name">Name</label>
        <input type="text" name="id" placeholder="1" value="<?=$employee['id']?>" id="id">
        <input type="text" name="name" placeholder="John Doe" value="<?=$employee['name']?>" id="name">
        <label for="email">Email</label>
        <label for="phone">Phone</label>
        <input type="text" name="email" placeholder="johndoe@example.com" value="<?=$employee['email']?>" id="email">
        <input type="text" name="phone" placeholder="2025550143" value="<?=$employee['phone']?>" id="phone">
        <label for="position">position</label>
        <label for="created">Created</label>
        <input type="text" name="position" placeholder="Employee" value="<?=$employee['position']?>" id="position">
        <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i', strtotime($employee['created']))?>" id="created">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>