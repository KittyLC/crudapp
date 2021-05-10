<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    $code = isset($_POST['code']) && !empty($_POST['code']) && $_POST['code'] != 'auto' ? $_POST['code'] : NULL;
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $stmt = $pdo->prepare('INSERT INTO positions VALUES (?, ?)');
    $stmt->execute([$code, $name]);
    // Output message
    $msg = 'Created Successfully!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Department</h2>
    <form action="create.php" method="post">
        <label for="id">Code</label>
        <label for="name">Name</label>
        <input type="text" name="code" placeholder="Ex IT" value="Ex IT" id="code">
        <input type="text" name="name" placeholder="Information Technology" id="name">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>