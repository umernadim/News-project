<?php
include 'config.php';

if (isset($_FILES['fileToUpload'])) {
    $errors = array();

    $file_name = $_FILES['fileToUpload']['name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $file_tmp  = $_FILES['fileToUpload']['tmp_name'];
    $file_type = $_FILES['fileToUpload']['type'];

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

session_start();

$title       = mysqli_real_escape_string($connect, $_POST['post_title']);
$description = mysqli_real_escape_string($connect, $_POST['post_desc']);
$category    = mysqli_real_escape_string($connect, $_POST['category']);
$date        = date("d M, Y");
$author      = $_SESSION['user_id'];

// multi query sahi syntax ke saath
$sql  = "INSERT INTO post (title, description, category, post_date, author, post_img)
         VALUES ('{$title}', '{$description}', {$category}, '{$date}', {$author}, '{$file_name}');";
$sql .= "UPDATE category SET post = post + 1 WHERE category_id = {$category}";

$result = mysqli_multi_query($connect, $sql);

if ($result) {
    header("Location: post.php");
} else {
    echo "<div class='alert alert-danger'>Query Failed</div>";
}
?>