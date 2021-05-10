<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $employee_id = isset($_POST['employee_id']) && !empty($_POST['employee_id']) && $_POST['employee_id'] != 'auto' ? $_POST['employee_id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $position_code = isset($_POST['position_code']) ? $_POST['position_code'] : '';
    $department_code = isset($_POST['department_code']) ? $_POST['department_code'] : '';
    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : date('Y-m-d');
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    // Insert new record into the employees table
    $stmt = $pdo->prepare('INSERT INTO employees VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$employee_id, $name, $position_code, $department_code, $end_date]);
    // Output message
    $msg = 'Post Successfully!';
}
?>
<?=template_header('Offboard')?>

<div class="content update">
	<h2>Offboard employee</h2>
    <form action="offboard.php" method="post">
        <label for="employee_id">Employee Id</label>
        <label for="name">Name</label>
        <input type="text" name="employee_id" placeholder="8" value="auto" id="employee_id">
        <input type="text" name="name" placeholder="John Doe" id="name">
        <label for="position_code">Position:</label>
        <input type="text" name="position_code" placeholder="ENG" id="position_code">
        <label for="department_code">Department:</label>
        <input type="text" name="department_code" placeholder="IT" id="department_code">
        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" value="<?=date('Y-m-d')?>" id="end_date">
        <input type="submit" value="Offboard">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>