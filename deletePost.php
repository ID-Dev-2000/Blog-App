<?php
    session_start();
    
    include('header.php');
    include('postClass.php');

    $postClass = new Post($connection); 

    $postFromSlug = $postClass->getPostFromSlug($_GET['slug']);

    if(isset($_GET['del']) && $_GET['del'] == 'true') {
        $postClass->deletePost($_GET['slug']);
        header('location: index.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Post</title>
    <link rel="stylesheet" href="css/mainStyles.css"></link>
</head>
<body>
    <div class="centeredColumn">
        <h1>DELETE POST</h1>
        <div class="centeredColumn">
            <p>Are you sure you want to delete post title: <b><?php echo $postFromSlug['title'] ?></b> ?</p>
            <div>
                <a href="deletePost.php?slug=<?php echo $postFromSlug['slug'] ?>&del=true" style="margin-right: 10px;"><button style="cursor: pointer; width: 50px;">YES</button></a>
                <a href="viewPost.php?slug=<?php echo $postFromSlug['slug']; ?>"><button style="cursor: pointer; width: 50px;">NO</button></a>
            </div>
        </div>
    </div>
</body>
</html>
