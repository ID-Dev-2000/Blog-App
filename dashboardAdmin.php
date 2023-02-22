<?php
    session_start();
    include('header.php');
    include('postClass.php');

    $postClass = new Post($connection);

    $allPosts = $postClass->getPosts();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/mainStyles.css"></link>
    <link rel="stylesheet" href="css/tableStyles.css"></link>
</head>
<body>
    <div class="centeredColumn">
        <table class="mainTable">
        <h1>All posts - ADMIN VIEW</h1>
            <tr>
                <th>Post Title</th>
                <th>Post Author</th>
                <th>Post Content</th>
                <th>Post Date</th>
                <th>Post Tag(s)</th>
                <th class="actionColumn">Actions</th>
            </tr>
            <?php foreach($allPosts as $post) { ?>
            <tr>
                <td><?php echo sliceLongStringMobile($post['title']);?></td> <!-- title -->
                <?php $author = $post['author'];
                // below if statement to color admin posts in table
                if($author == 'admin') { ?>
                    <td style="background-color: black; color: crimson;"><b><?php echo sliceLongString($post['author']);?></b></td> <!-- author -->
                <?php } else { ?>
                    <td><?php echo sliceLongString($post['author']);?></td>
                <?php } ?>
                <td><?php echo sliceLongStringMobile($post['maincontent']);?></td> <!-- content -->
                <td><?php echo sliceLongString($post['created_at']);?></td> <!-- date -->
                <td> <!-- tag(s) -->
                    <?php
                        if($post['tag'] == '0') {
                            echo 'No tags.';
                        } else {
                            echo sliceLongString(substr($post['tag'], 3));
                        }
                    ?>
                </td>
                <td class="actionColumnItems">
                    <a href="viewPost.php?slug=<?php echo $post['slug'] ;?>">VIEW</a> -
                    <a href="editPost.php?slug=<?php echo $post['slug'] ;?>">EDIT</a> - 
                    <a href="deletePost.php?slug=<?php echo $post['slug'] ;?>">DELETE</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
