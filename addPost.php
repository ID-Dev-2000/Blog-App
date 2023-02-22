<?php
    session_start();
    include('header.php');
    include('postClass.php');

    $postClass = new Post($connection);

    // allows selection of tags in php code
    $uniqueTagValue = 0;

    if(isset($_POST['buttonSubmit'])) {
        $author = $_SESSION['username'];
        $title = strip_tags($_POST['title']);
        $mainContent = $_POST['mainContent'];
        $slug = createSlug($title);
        $tag = ['0']; // '0' string value in case no tags are selected, hacky
        
        foreach($_POST['tagArray'] as $tempTags) {
            array_push($tag, ' ' . $tempTags);
        }
        $tag = implode(',', $tag);

        $createdAt = date('D, M d, Y');

        $postClass->addPost($author, $title, $mainContent, $createdAt, $slug, $tag);

        header('location: index.php');
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Post</title>
    <link rel="stylesheet" href="css/mainStyles.css"></link>
</head>
<body>
    <div class="centeredColumn">
        <h1>Add Post</h1>
        <form class="addPostForm" method="POST">
            <div class="inputForm">
                <label for="title">Title</label>
                <input type="text" name="title" maxlength="100" required>
                <br>
            </div>
            <div class="addPostForm">
                <label for="mainContent">Comment</label>
                <textarea name="mainContent" rows="10" cols="30" maxlength="4000" required></textarea>
            </div>
            <div class="addTagParent">
                <div class="addTagSelect">
                    <h3 style="margin-right: 5px;">Tags: </h3>
                    <?php foreach($postClass->getTagsFromDB() as $tags) { ?>
                    <?php 
                    $uniqueTagValue++;
                    ?>
                    <input type="checkbox" id="postTag<?php echo $uniqueTagValue ?>" name="tagArray[]" value="<?php echo $tags['tag'] ?>">
                    <label for="postTag<?php echo $uniqueTagValue ?>" class="addTagLabel"><?php echo ucfirst($tags['tag']) ?></label>
                    <?php } ?>
                </div>
            </div>
            <button type="submit" name="buttonSubmit">ADD</button>
        </form>
    </div>
</body>
</html>
