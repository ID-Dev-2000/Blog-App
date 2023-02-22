<?php
    session_start();
    
    include('header.php');
    include('postClass.php');
    $postClass = new Post($connection);

    // URL handling for search functionality, allow searching with post tag selected
    if(isset($_GET['postTag'])) {
        $urlGetTag = $_GET['postTag'];
    } elseif (!isset($_GET['postTag'])) {
        $urlGetTag = '';
    }

    // handle pagination
    $numberOfPosts = 0;
    foreach($postClass->checkNumberOfPostsInTable() as $item) {
        $numberOfPosts++;
    }

    // 10 posts per page, must update here as well as in the pagination methods to modify pagination values
    if($numberOfPosts >= 10 && !isset($_GET['page']) && !isset($_GET['postSearch']) && !isset($_GET['postTag'])) {
        header('location: index.php?page=1');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Home</title>
    <link rel="stylesheet" href="css/mainStyles.css"></link>
</head>
<body>
    <div class="mainHomePageParent">
        <div class="centeredColumn" id="mainPostsParent">
            <h1 style="margin-bottom: 0;">Home</h1>

            <!-- search functionality -->
            <form action="" method="GET">
                <input type="hidden" name="postTag" value="<?php echo $urlGetTag ?>"> <?php // hidden for tag functionality ?>
                <input type="text" placeholder="Search posts . . ." id="postSearch" name="postSearch" style="margin-top: 10px;">
                <input type="submit">
            </form>
            
            <!-- tag handler -->
            <?php if($postClass->checkNumRowsFromGetPost() !== 0) { ?>
            <div class="tagSection">
                <div class="tagMainParent">
                    <h3>TAGS: </h3>
                    <div class="tagItemParent">
                        <a href="index.php" class="tagItem">all</a>
                    </div>
                    <?php foreach($postClass->getTagsFromDB() as $tags) { ?>
                    <div class="tagItemParent">
                        <a href="index.php?postTag=<?php echo $tags['tag'] ?>" class="tagItem"
                        <?php // background color to tag if selected 
                            if(isset($_GET['postTag']) && $_GET['postTag'] != '') {
                                if(str_contains($tags['tag'], $_GET['postTag'])) { ?>
                                    style="background-color: gainsboro;"
                             <?php }
                            }
                        ?>>
                        <?php echo $tags['tag'] ?>
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>

                <!-- pagination -->
                <?php $numberOfPages = $postClass->checkNumRowsFromGetPost() / 10; ?>
                    <div class="paginationDiv">
                        <p style="margin: 0 5px 0 0;">All Pages: </p>
                        <?php 
                        for($i = 0; $i < $numberOfPages; $i++) {
                        $pageButton = $i + 1;    
                        ?>
                            <a href="index.php?page=<?php echo $pageButton; ?>" class="pageLink" 
                            <?php
                            // color page button
                            if(isset($_GET['page'])) {
                                if($pageButton == $_GET['page']) {
                                    echo 'style="background-color: darkgrey;"';
                                }
                            } ?>
                            ><?php echo $pageButton; ?></a>
                        <?php } ?>
                    </div>


            <?php 
            // Check if zero posts
            if($postClass->checkNumRowsFromGetPost() == 0) {
                echo '<br>';
                echo "No posts!";
            }
            ?>

            <?php
            // show posts from tags if tags in URL
            if(isset($_GET['postTag'])) {
                if(mysqli_fetch_array($postClass->getPostBasedOnTagFromGet($_GET['postTag'])) == '') {
                    echo "No posts!";
                }

                // get posts if search included, works if tags selected or not
                if(isset($_GET['postSearch'])) {
                    if(mysqli_num_rows($postClass->verifySearch($_GET['postSearch'])) == 0) { ?>
                        <p>No posts match your search.</p>
                    <?php } else {
                    // gets all posts based on tag, then filters all remaining posts based on search
                    foreach($postClass->getPostBasedOnTagFromGet($_GET['postTag']) as $post) {
                            if(str_contains($post['title'], trim($_GET['postSearch']))) {?>
                                <!-- POST BEGIN -->
                                <div class="postParent">
                                    <div class="postHeader">
                                        <div class="postTitle">
                                            <h3 class="postTitleHeaderContent" id="postTitle">Title: <?php echo sliceLongTitle($post['title'])?></h3>
                                                <h5 class="postTitleHeaderContent">
                                                <?php if($post['author'] == 'admin') {?>
                                                Author: <?php echo "<p style='display: inline; color: crimson;'>" . $post['author'] . "</p>"?>
                                                <?php } elseif (isset($_SESSION['username']) && $post['author'] == $_SESSION['username']) {?>
                                                Author: <?php echo "<p style='display: inline; color: limegreen;'>" . $post['author'] . "</p>"?>
                                                <?php } else {?>
                                                Author: <?php echo "<p style='display: inline;'>" . $post['author'] . "</p>"?>
                                                <?php } ?>
                                                    --- 
                                                    Date Uploaded: <?php echo $post['created_at'] ?>
                                                </h5>
                                        </div>
                                        <div>
                                            <a href="viewPost.php?slug=<?php echo $post['slug'] ?>"><button class="viewPostButton"><b>View Full Post</b></button></a>  
                                        </div>
                                    </div>
                                    <div class="postContentParent">
                                        <div class="postContent">
                                            <?php echo strip_tags($post['maincontent'])?>
                                        </div>
                                    </div>
                                </div>
                                <hr style="width: 100px;">
                                <!-- POST END -->
                    <?php } } } } ?>

                <?php if(!isset($_GET['postSearch'])) {
                    // get posts based solely on tag, no search
                    foreach($postClass->getPostBasedOnTagFromGet($_GET['postTag']) as $post) { ?>
                    <!-- POST BEGIN -->
                    <div class="postParent">
                        <div class="postHeader">
                            <div class="postTitle">
                                <h3 class="postTitleHeaderContent" id="postTitle">Title: <?php echo sliceLongTitle($post['title'])?></h3>
                                    <h5 class="postTitleHeaderContent">
                                        <?php if($post['author'] == 'admin') {?>
                                        Author: <?php echo "<p style='display: inline; color: crimson;'>" . $post['author'] . "</p>"?>
                                        <?php } elseif (isset($_SESSION['username']) && $post['author'] == $_SESSION['username']) {?>
                                        Author: <?php echo "<p style='display: inline; color: limegreen;'>" . $post['author'] . "</p>"?>
                                        <?php } else {?>
                                        Author: <?php echo "<p style='display: inline;'>" . $post['author'] . "</p>"?>
                                        <?php } ?>
                                        --- 
                                        Date Uploaded: <?php echo $post['created_at'] ?>
                                    </h5>
                            </div>
                            <div>
                                <a href="viewPost.php?slug=<?php echo $post['slug'] ?>"><button class="viewPostButton"><b>View Full Post</b></button></a>      
                            </div>
                        </div>
                        <div class="postContentParent">
                            <div class="postContent">
                                <?php echo strip_tags($post['maincontent'])?>
                            </div>
                        </div>
                    </div>
                    <hr style="width: 100px;">
                    <!-- POST END -->
                <?php } } } ?>
                

            <?php
            // Show all posts, no tags
            if(!isset($_GET['postTag'])) {
                // if less than 10 posts
                if(!isset($_GET['page'])) {
                foreach($postClass->getPosts() as $post) { ?>
                <!-- POST BEGIN -->
                    <div class="postParent">
                        <div class="postHeader">
                            <div class="postTitle">
                                <h3 class="postTitleHeaderContent" id="postTitle">Title: <?php echo sliceLongTitle($post['title'])?></h3>
                                    <h5 class="postTitleHeaderContent">
                                        <?php if($post['author'] == 'admin') {?>
                                        Author: <?php echo "<p style='display: inline; color: crimson;'>" . $post['author'] . "</p>"?>
                                        <?php } elseif (isset($_SESSION['username']) && $post['author'] == $_SESSION['username']) {?>
                                        Author: <?php echo "<p style='display: inline; color: limegreen;'>" . $post['author'] . "</p>"?>
                                        <?php } else {?>
                                        Author: <?php echo "<p style='display: inline;'>" . $post['author'] . "</p>"?>
                                        <?php } ?>
                                        --- 
                                        Date Uploaded: <?php echo $post['created_at'] ?>
                                    </h5>
                            </div>
                            <div>
                                <a href="viewPost.php?slug=<?php echo $post['slug'] ?>"><button class="viewPostButton"><b>View Full Post</b></button></a>      
                            </div>
                        </div>
                        <div class="postContentParent">
                            <div class="postContent">
                                <?php echo strip_tags($post['maincontent'])?>
                            </div>
                        </div>
                    </div>
                <hr style="width: 100px;">
                <!-- POST END -->
                <?php // view paginated posts below if conditions are met
                } } elseif(isset($_GET['page']))  {
                    foreach($postClass->postsPaginated($_GET['page']) as $post) { ?>
                <!-- POST BEGIN -->
                    <div class="postParent">
                        <div class="postHeader">
                            <div class="postTitle">
                                <h3 class="postTitleHeaderContent" id="postTitle">Title: <?php echo sliceLongTitle($post['title'])?></h3>
                                    <h5 class="postTitleHeaderContent">
                                        <?php if($post['author'] == 'admin') {?>
                                        Author: <?php echo "<p style='display: inline; color: crimson;'>" . $post['author'] . "</p>"?>
                                        <?php } elseif (isset($_SESSION['username']) && $post['author'] == $_SESSION['username']) {?>
                                        Author: <?php echo "<p style='display: inline; color: limegreen;'>" . $post['author'] . "</p>"?>
                                        <?php } else {?>
                                        Author: <?php echo "<p style='display: inline;'>" . $post['author'] . "</p>"?>
                                        <?php } ?>
                                        --- 
                                        Date Uploaded: <?php echo $post['created_at'] ?>
                                    </h5>
                            </div>
                            <div>
                                <a href="viewPost.php?slug=<?php echo $post['slug'] ?>"><button class="viewPostButton"><b>View Full Post</b></button></a>      
                            </div>
                        </div>
                        <div class="postContentParent">
                            <div class="postContent">
                                <?php echo strip_tags($post['maincontent'])?>
                            </div>
                        </div>
                    </div>
                <hr style="width: 100px;">
                <!-- POST END -->
                <?php } } } ?>
                
                <!-- pagination -->
                <?php $numberOfPages = $postClass->checkNumRowsFromGetPost() / 10; ?>
                    <div class="paginationDiv">
                        <p style="margin: 0 5px 0 0;">All Pages: </p>
                        <?php 
                        for($i = 0; $i < $numberOfPages; $i++) {
                        $pageButton = $i + 1;    
                        ?>
                            <a href="index.php?page=<?php echo $pageButton; ?>" class="pageLink" 
                            <?php
                            // color page button
                            if(isset($_GET['page'])) {
                                if($pageButton == $_GET['page']) {
                                    echo 'style="background-color: darkgrey;"';
                                }
                            } ?>
                            ><?php echo $pageButton; ?></a>
                        <?php } ?>
                    </div>
        </div>
    </div>
</body>
</html>
