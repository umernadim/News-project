<?php include 'header.php'; ?>
<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    <div class="post-content single-post">
                        <?php
                        include 'admin/config.php';

                        // URL se post id lena
                        if (isset($_GET['id'])) {
                            $post_id = $_GET['id'];

                            $sql = "SELECT p.post_id, p.title, p.description, p.post_date, 
                                           c.category_name, p.post_img, p.category, 
                                           u.username, u.user_id
                                    FROM post AS p
                                    INNER JOIN category AS c ON p.category = c.category_id
                                    INNER JOIN user AS u ON p.author = u.user_id
                                    WHERE p.post_id = {$post_id}";

                            $result = mysqli_query($connect, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                    <h3><?php echo $row['title']; ?></h3>
                                    <div class="post-information">
                                        <span>
                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                             <a href='category.php?cid=<?php echo $row['category'] ?>'><?php echo $row['category_name'] ?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            <a href='author.php?aid=<?php echo $row['user_id']; ?>'>
                                                <?php echo $row['username']; ?>
                                            </a>
                                        </span>
                                        <span>
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            <?php echo $row['post_date']; ?>
                                        </span>
                                    </div>
                                    <img class="single-feature-image" src="admin/upload/<?php echo $row['post_img']; ?>" alt="" />
                                    <p class="description">
                                        <?php echo $row['description']; ?>
                                    </p>
                        <?php
                                }
                            } else {
                                echo "<h2>No Post Found.</h2>";
                            }
                        } else {
                            echo "<h2>Invalid Request.</h2>";
                        }
                        ?>
                    </div>
                </div>
                <!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>