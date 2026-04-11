<?php 
include 'config.php';

if(empty($_FILES['new-image']['name'])){
    $file_name = $_POST['old_image'];   // FIXED
}else{
    $errors = array();

    $file_name = $_FILES['new-image']['name'];
    $file_size = $_FILES['new-image']['size'];
    $file_tmp  = $_FILES['new-image']['tmp_name'];
    $file_type = $_FILES['new-image']['type'];

    $temp = explode('.', $file_name);
    $file_ext = strtolower(end($temp));

    $extensions = array("jpeg", "jpg", "png");

    if (in_array($file_ext, $extensions) === false) {
        $errors[] = "This extension file is not allowed.";
    }

    if ($file_size > 2097152) {
        $errors[] = "File size must be 2mb or lower";
    }

    if (empty($errors)) {
        $new_name = md5(time() . $file_name) . "." . $file_ext;
        $file_name = $new_name;

        move_uploaded_file($file_tmp, "upload/" . $file_name);
    } else {
        print_r($errors);
        exit();
    }
}

// Escape inputs
$title    = mysqli_real_escape_string($connect, $_POST["post_title"]);
$desc     = mysqli_real_escape_string($connect, $_POST["postdesc"]);
$category = (int)$_POST["category"];
$post_id  = (int)$_POST["post_id"];

$sql = "UPDATE post 
        SET title = '{$title}', description = '{$desc}', category = {$category}, post_img = '{$file_name}'
        WHERE post_id = {$post_id};";

if($_POST['old_category'] != $_POST['category']){
    $old_cat = (int)$_POST['old_category'];
    $sql .= "UPDATE category SET post = post - 1 WHERE category_id = {$old_cat};";
    $sql .= "UPDATE category SET post = post + 1 WHERE category_id = {$category};";
}

$result = mysqli_multi_query($connect, $sql);
if($result){
    header("Location: post.php");
}
?>
