<?php 

include 'config.php';

if ($_SESSION['role'] == '0') {
    header('Location:post.php');
}

$userid = $_GET['id'];

$sql = "DELETE FROM user WHERE user_id = {$userid}";
$result = mysqli_query($connect, $sql);
if($result){
    header('Location: users.php');
}

mysqli_close($connect);

?>