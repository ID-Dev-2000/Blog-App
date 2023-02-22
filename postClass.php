<?php
    include('db/dbConnection.php');
    include('functions.php');

    class Post {
        private $databaseConnection;

        public function __construct($databaseConnection) {
            $this->dbConn = $databaseConnection;
        }

        public function addPost($author, $title, $mainContent, $createdAt, $slug, $tag) {
            
            $slugInserted = createSlug($title);

            $sql = "INSERT INTO posts(author, title, maincontent, created_at, slug, tag) VALUES (?,?,?,?,?,?)";
            $preparedStatement = mysqli_prepare($this->dbConn, $sql);
            mysqli_stmt_bind_param($preparedStatement, 'ssssss',$author, $title, $mainContent, $createdAt, $slugInserted, $tag); // 'ssssss' denotes string values for each inserted item
            mysqli_stmt_execute($preparedStatement);
        }

        public function getPosts() {
            $sql = "SELECT * FROM posts ORDER BY id DESC";
            $result = mysqli_query($this->dbConn, $sql);
            return $result;
        }

        public function checkNumRowsFromGetPost() {
            // method may not need to exist
            $value = mysqli_num_rows($this->getPosts());
            return $value;
        }

        // create function to receive full post from db using slug
        public function getPostFromSlug($slug) {
            $sql = "SELECT * FROM posts WHERE slug=?";
            $preparedStatement = mysqli_prepare($this->dbConn, $sql);
            mysqli_stmt_bind_param($preparedStatement, 's', $slug);
            mysqli_stmt_execute($preparedStatement);
            $result = mysqli_stmt_get_result($preparedStatement);
            $row = mysqli_fetch_array($result);
            return $row;
        }

        public function getTagsFromDB() {
            $sql = "SELECT * FROM tags";
            $result = mysqli_query($this->dbConn, $sql);
            return $result;
        }

        // selects posts based on tag, tag value received from URL
        public function getPostBasedOnTagFromGet($getValue) {
            $receivedTag = '%' . $getValue . '%';
            $stmt = $this->dbConn->prepare("SELECT * FROM posts WHERE tag LIKE ? ORDER BY id DESC");
            $stmt->bind_param('s', $receivedTag);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }

        public function updatePost($newSlugValue, $title, $content, $uploadDate, $tagValue, $oldSlugValue) {
            $sql = "UPDATE posts SET slug=?, title=? , maincontent=? , created_at=?, tag=? WHERE slug=?";
            $preparedStatement = mysqli_prepare($this->dbConn, $sql);
            mysqli_stmt_bind_param($preparedStatement, 'ssssss', $newSlugValue, $title, $content, $uploadDate, $tagValue, $oldSlugValue);
            mysqli_stmt_execute($preparedStatement);
        }

        public function clearPostTags($postSlug) {
            $sql = "UPDATE posts SET tag='0' WHERE slug=?";
            $preparedStatement = mysqli_prepare($this->dbConn, $sql);
            mysqli_stmt_bind_param($preparedStatement, 's', $postSlug);
            mysqli_stmt_execute($preparedStatement);
        }

        public function deletePost($slugInserted) {
            $sql = "DELETE FROM posts WHERE slug=?";
            $preparedStatement = mysqli_prepare($this->dbConn, $sql);
            mysqli_stmt_bind_param($preparedStatement , 's', $slugInserted);
            mysqli_stmt_execute($preparedStatement);
        }

        // verify if search returns zero results
        public function verifySearch($searchValue) {
            $placeholder = '%' . $searchValue . '%';
            $stmt = $this->dbConn->prepare("SELECT * FROM posts WHERE title LIKE ?");
            $stmt->bind_param('s', $placeholder);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }

        // handle comments
        public function createComment($author, $slug, $comment, $createdAt) {
            $sql = "INSERT INTO comments(author, slug, comment, created_at) VALUES (?,?,?,?)";
            $preparedStatement = mysqli_prepare($this->dbConn, $sql);
            mysqli_stmt_bind_param($preparedStatement, 'ssss', $author, $slug, $comment, $createdAt);
            mysqli_stmt_execute($preparedStatement);
        }

        public function receiveComments($slug) {
            $sql = "SELECT * FROM comments WHERE slug=? ORDER BY id DESC";
            $preparedStatement = mysqli_prepare($this->dbConn, $sql);
            mysqli_stmt_bind_param($preparedStatement, 's', $slug);
            mysqli_stmt_execute($preparedStatement);
            $result = mysqli_stmt_get_result($preparedStatement);
            $row = mysqli_fetch_array($result);
            return $result;
        }

        public function deleteComment($commentId) {
            $sql = "DELETE FROM comments WHERE id=?";
            $preparedStatement = mysqli_prepare($this->dbConn, $sql);
            mysqli_stmt_bind_param($preparedStatement, 's', $commentId);
            mysqli_stmt_execute($preparedStatement);
        }

        // handle pagination
        public function checkNumberOfPostsInTable() {
            $sql = "SELECT * FROM posts";
            $result = mysqli_query($this->dbConn, $sql);
            return $result;
        }

        public function postsPaginated($page) {
            $paginationValue = ($page - 1) * 10;
            $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT ?,10";
            $preparedStatement = mysqli_prepare($this->dbConn, $sql);
            mysqli_stmt_bind_param($preparedStatement , 's', $paginationValue);
            mysqli_stmt_execute($preparedStatement);
            $result = mysqli_stmt_get_result($preparedStatement);
            return $result;
        }

    }

?>
