<?php
    session_start();
    include('header.php');
    include('accountClass.php');

    $accountClass = new accountHandler($connection);

    $username = $_SESSION['username'];

    $allUserPosts = $accountClass->getAccountDashboard($username);
    
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
        <h1 style="display: flex;">Your posts -&nbsp<?php echo '<p style="color: limegreen; margin: 0px;">' . $username . '</p>';?></h1>
        <?php if($accountClass->checkAccountPosts($username) == true) { ?>
            <?php if($username != 'guest') {?>
                <div style="display: flex;">
                    <p style="margin-top: 0px; margin-bottom: 3px;"><a href="deleteAccount.php"><b>DELETE ACCOUNT</b></a></p>
                </div>
            <?php } ?>
        <!-- CONTENT BEGIN -->
            <tr>
                <th>Post Title</th>
                <th>Post Content</th>
                <th>Post Date</th>
                <th>Post Tag(s)</th>
                <th class="actionColumn">Actions</th>
            </tr>
            <?php foreach($allUserPosts as $post) { ?>
            <tr>
                <td  class="columnWidth"><?php echo sliceLongStringMobile($post['title']);?></td> <!-- title -->
                <td  class="columnWidth"><?php echo sliceLongStringMobile($post['maincontent']);?></td> <!-- content -->
                <td ><?php echo sliceLongString($post['created_at']);?></td> <!-- date -->
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
                    <a href="deletePost.php?slug=<?php echo $post['slug'] ;?>">DELETE</a href="tempPage.php">
                </td>
            </tr>
            <?php } } else { ?>
                <div style='display: flex;'>
                    <p style='margin-top: 0px; margin-bottom: 10px;'>
                    <a href='deleteAccount.php'><b>DELETE ACCOUNT</b></a>
                </p>
                </div>
                <?php echo 'No posts from account: ' . $_SESSION['username']; ?> 
                <?php } ?>
        </table>
    </div>
</body>
</html>
