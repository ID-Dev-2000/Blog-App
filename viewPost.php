<?php
    session_start();
    include('header.php');
    include('postClass.php');

    $postClass = new Post($connection);
    $arrayOfSlug = $postClass->getPostFromSlug($_GET['slug']);

    $linkSlug = $_GET['slug'];

    if(isset($_GET['delete'])) {
        $postClass->deleteComment($_GET['delete']);
        header('location: viewPost.php?slug=' . $_GET['slug']);
        }

    if(isset($_POST['addComment'])) {
        if($_POST['commentContent'] == '') {
            header('location: viewPost.php?slug=' . $_GET['slug']);
        } else {
            $author = $_SESSION['username'];
            $slug = $_GET['slug'];
            $comment = $_POST['commentContent'];
            $createdAt = date('D, M d, Y');
        }

        $postClass->createComment($author, $slug, $comment, $createdAt);
        header('location: viewPost.php?slug=' . $_GET['slug']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $arrayOfSlug['title'];?></title>
    <link rel="stylesheet" href="css/viewPost.css"></link>
</head>
<body>
    <div class="displayPostMain">
            <!-- POST BEGIN -->
            <div class="postMain">
                <div class="postHeader">
                    <p class="handleOverflow"><b>Title:</b><?php echo $arrayOfSlug['title'];?></p>
                    <p><b>Author:</b><?php echo $arrayOfSlug['author']?></p>
                    <p><b>Upload Date:</b><?php echo $arrayOfSlug['created_at'];?></p>
                    <p><b>Tag:</b><?php
                    if ($arrayOfSlug['tag'] == '0') {
                        echo 'No tags.';
                    } else {
                        echo substr($arrayOfSlug['tag'], 3);
                    }
                    ?></p>
                    <?php if($_SESSION == true) {
                        if($arrayOfSlug['author'] == $_SESSION['username']) {?>
                    <div class="centered">
                        <p><a href="editPost.php?slug=<?php echo $_GET['slug'] ?>"><b>EDIT</b></a></p>
                        <p><a href="deletePost.php?slug=<?php echo $_GET['slug'] ?>" id="deletePostID"><b>DELETE</b></a></p> 
                    </div>
                    <?php } } ?>
                </div>
                <div class="postContent">
                    <p style="margin: 16px;"><b>Post: </b><?php echo $arrayOfSlug['maincontent'];?></p>
                </div>
                <hr style="width: 100px;">
                <h3 style="margin-bottom: 3px;">COMMENTS</h3>

                <?php if(isset($_SESSION['username'])) {?>
                    <div style="margin-bottom: 3px;">
                        <form method="POST">
                            <input type="text" name="commentContent" placeholder="Leave Comment" maxlength="500"></input>
                            <button type="submit" class="commentButton" name="addComment">Comment</button>
                        </form>
                    </div>
                <?php } else { ?>
                    <p style="margin: 0px 0px 3px 0px;">You must be logged in to leave a comment!</p>
                <?php } ?>

                <div class="entireCommentSection">
                    <div class="commentParent">
                    <?php if(mysqli_num_rows($postClass->receiveComments($_GET['slug'])) > 0) { ?>
                        <?php foreach($postClass-> receiveComments($_GET['slug']) as $comment) { ?>
                        <div class="commentContent">
                            <p>
                                <div>
                                    <b>AUTHOR:</b> <?php echo $comment['author'] ; ?>
                                    <b>UPLOADED:</b> <?php echo $comment['created_at'] ; ?>
                                    <?php if(isset($_SESSION['username'])) {
                                            if($_SESSION['username'] == $comment['author']) {
                                                // slug defined on line 9
                                                $commentId = $comment['id'];
                                                ?>
                                                
                                            <form action="viewPost.php" method="GET" style="display: inline;">
                                                <input type="hidden" name="slug" value="<?php echo $linkSlug ?>">
                                                <input type="hidden" name="delete" value="<?php echo $commentId ?>">
                                                <input type="submit" value="DELETE" style="margin-left: 5px;">
                                            </form>
                                        <?php } } ?>
                                </div>
                                <p><?php echo $comment['comment']; ?></p>
                            </p>
                        </div>
                        <?php } ?>
                <?php } else {?>
                        <div style="display: flex; align-items: center; justify-content: center;">
                        <p>No comments!</p>
                        </div>
                <?php } ?>

                    </div>
                </div>
            </div>
            <!-- POST END -->
    </div>
</body>
</html>
