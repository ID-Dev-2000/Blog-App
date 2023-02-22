<?php
    include('header.php');
    include('postClass.php');

    $postClass = new Post($connection); 
    
    $userPostValues = $postClass->getPostFromSlug($_GET['slug']);
    
    // allows selection of tags in php code
    $uniqueTagValue = 0;

    if(isset($_POST['buttonSubmit'])) {
        $postClass->clearPostTags($userPostValues['slug']);

        $newSlug = createSlug($_POST['title']);
        $title = $_POST['title'];
        $content = $_POST['mainContent'];
        $createdAt = date('D, M d, Y');
        $oldSlug = $_GET['slug'];
        $tag = ['0'];

        foreach($_POST['tagArray'] as $tempTags) {
            array_push($tag, ' ' . $tempTags);
        }
        $tag = implode(',', $tag);

        $postClass->updatePost($newSlug, $title, $content, $createdAt, $tag, $oldSlug);

        header('location: viewPost.php?slug=' . $newSlug);

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="css/mainStyles.css"></link>
</head>
<body>
    <div class="centeredColumn">
        <h1>Edit Post</h1>
        <form class="addPostForm" method="POST">
            <div class="inputForm">
                <label for="title">Title</label>
                <input type="text" name="title" value="<?php echo $userPostValues['title']; ?>" required>
                <br>
            </div>
            <div class="addPostForm">
                <label for="mainContent">Comment</label>
                <textarea name="mainContent" rows="10" cols="30" required><?php echo $userPostValues['maincontent']; ?></textarea>
            </div>
            <div class="addTagParent">
                <div class="addTagSelect">
                    <h3 style="margin-right: 5px;">Tags: </h3>
                    <?php foreach($postClass->getTagsFromDB() as $tags) { ?>
                        <?php 
                        $uniqueTagValue++;
                        ?>
                        
                        <!-- ticks tags of post if any are set -->
                        <input
                            type="checkbox"
                            id="postTag<?php echo $uniqueTagValue ?>"
                            name="tagArray[]"
                            value="<?php echo $tags['tag'] ?>" 
                            <?php 
                                // check input box if tag is true for post
                                // if tag value is within the tag string in the database for the post, it outputs "checked" and marks the box as such
                                if(str_contains($userPostValues['tag'], $tags['tag'])) {
                                    echo "checked";
                                }
                            ?>
                        >
                        <label for="postTag<?php echo $uniqueTagValue ?>" class="addTagLabel"><?php echo ucfirst($tags['tag']) ?></label>
                    <?php } ?>
                </div>
            </div>
            <button type="submit" name="buttonSubmit" style="cursor: pointer;">EDIT</button> 
            <button style="margin-top: 10px;" style="cursor: pointer;"><a href="viewPost.php?slug=<?php echo $_GET['slug'] ?>" style="text-decoration: none; color: black;">CANCEL</a></button>
        </form>
    </div>
</body>
</html>
