<?php 
require_once '../../conn/conn.php';

$query = $pdo->prepare("SELECT COUNT(id) FROM submissions WHERE YEAR(created_at) = ? AND MONTH(created_at) = ?");
$year = $_POST['year'];

$data = [];

for($m=1;$m<=12;$m++){
    $query->execute([$year,$m]);
    $data[] = $query->fetch()[0];
}

echo json_encode($data);
?>