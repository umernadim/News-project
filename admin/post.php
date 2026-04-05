<?php include "header.php"; ?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Posts</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-post.php">add post</a>
            </div>
            <div class="col-md-12">
                <?php
                include 'config.php';
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    $page = 1;
                }
                $limit = 3;
                $offset = ($page - 1) * $limit;

                if ($_SESSION['role'] == '1') {
                    $sql = "SELECT p.post_id, p.title, p.description, p.post_date ,c.category_name, p.category, u.username FROM post AS p
                INNER JOIN category AS c ON p.category = c.category_id
                INNER JOIN user AS u ON p.author = u.user_id
                ORDER BY post_id DESC LIMIT {$offset}, {$limit}";
                } else if ($_SESSION['role'] == '0') {
                    $sql = "SELECT p.post_id, p.title, p.description, p.post_date ,c.category_name, p.category, u.username FROM post AS p
                INNER JOIN category AS c ON p.category = c.category_id
                INNER JOIN user AS u ON p.author = u.user_id
                WHERE p.author = {$_SESSION['user_id']}
                ORDER BY post_id DESC LIMIT {$offset}, {$limit}";
                }


                $result = mysqli_query($connect, $sql);
                if (mysqli_num_rows($result)) {

                ?>
                    <table class="content-table">
                        <thead>
                            <th>S.No.</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Author</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <tr>
                                    <td class='id'><?php echo $row['post_id']; ?></td>
                                    <td><?php echo $row['title']; ?></td>
                                    <td><?php echo $row['category_name']; ?></td>
                                    <td><?php echo $row['post_date']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td class='edit'><a href='update-post.php?id=<?php echo $row['post_id'] ?>'><i class='fa fa-edit'></i></a></td>
                                    <td class='delete'><a href='delete-post.php?postid=<?php echo $row['post_id'] ?>&catid=<?php echo $row['category'] ?>'><i class='fa fa-trash-o'></i></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php }
                $sql1 = "SELECT * FROM post";
                $result1 = mysqli_query($connect, $sql1);
                if (mysqli_num_rows($result1) > 0) {
                    $total_records = mysqli_num_rows($result1);
                    $total_page = ceil($total_records / $limit);

                    echo "<ul class='pagination admin-pagination'>";
                    if ($page > 1) {
                        echo '<li><a href="post.php?page=' . ($page - 1) . '">Prev</a></li>';
                    }
                    for ($i = 1; $i <= $total_page; $i++) {
                        if ($i == $page) {
                            $active = "active";
                        } else {
                            $active = "";
                        }
                        echo '<li class="' . $active . '"><a href="post.php?page=' . $i . '">' . $i . '</a></li>';
                    }
                    if ($total_page > $page) {
                        echo '<li><a href="post.php?page=' . ($page + 1) . '">Next</a></li>';
                    }
                    echo "</ul>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>