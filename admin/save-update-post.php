<?php 
include 'config.php';
if(empty($_FILES['new-image']['name'])){
    $image = $_POST['old_image'];
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

$sql = "UPDATE post SET title = '{$_POST["post_title"]}', description = '{$_POST["postdesc"]}', category={$_POST["category"]},post_img = '{$file_name}'
WHERE post_id = {$_POST["post_id"]}";

$result = mysqli_query($connect, $sql);
if($result){
    header("Location: post.php");
}

?>