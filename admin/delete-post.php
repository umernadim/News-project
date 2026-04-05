<?php
include 'config.php';
$post_id = $_GET['postid'];
$cat_id = $_GET['catid'];

$sql1 = "SELECT * FROM post WHERE post_id = {$post_id}";
$result1 = mysqli_query($connect, $sql1);
$row = mysqli_fetch_assoc($result1);

unlink("upload/".$row['post_img']);

$sql = "DELETE FROM post WHERE post_id = {$post_id};";
$sql .= "UPDATE category SET post = post - 1 WHERE category_id = {$cat_id}";
$result = mysqli_multi_query($connect, $sql);
if($result){
    header('Location:post.php');
}

?>