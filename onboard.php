<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
//$msg = '';
if (!empty($_POST)) {
    $employee_id = isset($_POST['employee_id']) && !empty($_POST['employee_id']) && $_POST['employee_id'] != 'auto' ? $_POST['employee_id'] : NULL;
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $salary = isset($_POST['salary']) ? $_POST['salary'] : '';
    $position_code = isset($_POST['position_code']) ? $_POST['position_code'] : '';
    $department_code = isset($_POST['department_code']) ? $_POST['department_code'] : '';
    $eq_code = isset($_POST['eq_code']) ? $_POST['eq_code'] : '';
    $office_code = isset($_POST['office_code']) ? $_POST['office_code'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $stmt = $pdo->prepare('call onboardproc(?,?,?,?,?,?,?,@status)');
    $stmt->bind_param("sssssss", $employee_id, $name, $salary, $position_code, $department_code, $eq_code, $office_code);
    if ($stmt->execute() === TRUE) {
        $sql = "SELECT @status as status";
    $result = $pdo->query($sql);
        $row = $result->fetch_assoc();
    if($row["status"] == "OK")
        echo "Onboarded Successfully!";
    else
        echo $row["status"];  
    } else {
        echo "Error: " . $sql . "<br>" . $pdo->error;}

    //$stmt->execute([$employee_id, $name, $salary, $position_code, $department_code, $eq_code, $office_code]);
    // Output message
    //$msg = 'Onboarded Successfully!';
}
?>
<?=template_header('Onboard')?>

<div class="content update">
	<h2>Onboard employee</h2>
    <form action="onboard.php" method="post">
        <label for="employee_id">Employee Id</label>
        <label for="name">Name</label>
        <input type="text" name="employee_id" placeholder="8" value="auto" id="employee_id">
        <input type="text" name="name" placeholder="John Doe" id="name">
        <label for="salary">Salary</label>
        <label for="position_code">Position</label>
        <input type="text" name="salary" placeholder="60000" id="salary">
        <input type="text" name="position_code" placeholder="ENG" id="position_code">
        <label for="department_code">Department</label>
        <label for="eq_code">Equipment</label>
        <input type="text" name="department_code" placeholder="IT" id="department_code">
        <input type="text" name="eq_code" placeholder="LAP" id="eq_code">
        <label for="office_code">Office:</label>
        <input type="text" name="office_code" placeholder="NYM" id="office_code">
        <input type="submit" value="Onboard">
    </form>
    
</div>

<?=template_footer()?>