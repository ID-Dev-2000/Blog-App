<?php
    include('db/dbConnection.php');
    include('functions.php');

    class accountHandler {
        private $databaseConnection;

        public function __construct($databaseConnection) {
            $this->dbConn = $databaseConnection;
        }

        public function createAccount($username, $password) {
            $sql = "INSERT INTO users(accountname, accountpassword) VALUES (?, ?)";
            $preparedStatement = mysqli_prepare($this->dbConn, $sql);
            mysqli_stmt_bind_param($preparedStatement, 'ss', $username, $password);
            mysqli_execute($preparedStatement);
        }

        public function checkIfAccountExists($username) {
            $sql = "SELECT * FROM users WHERE accountname=?";
            $preparedStatement = mysqli_prepare($this->dbConn, $sql);
            mysqli_stmt_bind_param($preparedStatement, 's', $username);
            mysqli_execute($preparedStatement);
            $result = mysqli_stmt_get_result($preparedStatement);
            $row = mysqli_fetch_array($result);
            if(mysqli_num_rows($result) > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function authenticateAccount($username, $password) {
            $sql = "SELECT * FROM users WHERE accountname=? AND accountpassword=?";
            $preparedStatement = mysqli_prepare($this->dbConn, $sql);
            mysqli_stmt_bind_param($preparedStatement, 'ss', $username, $password); // password hashed in login page, may not be best practice
            mysqli_execute($preparedStatement);
            $result = mysqli_stmt_get_result($preparedStatement);
            $row = mysqli_fetch_array($result);
            if(mysqli_num_rows($result) > 0) {
                return true;
            } else {
                return false;
            }
        }
        
        public function loginToAccount($username, $password) {
            $sql = "SELECT * FROM users WHERE accountname=? AND accountpassword=?";
            $preparedStatement = mysqli_prepare($this->dbConn, $sql);
            mysqli_stmt_bind_param($preparedStatement, 'ss', $username, $password);
            mysqli_execute($preparedStatement);
            $result = mysqli_stmt_get_result($preparedStatement);
            $row = mysqli_fetch_array($result);
            return $row;
        }
        
        public function getAccountDashboard($username) {
            $sql = "SELECT * FROM posts WHERE author=?";
            $preparedStatement = mysqli_prepare($this->dbConn, $sql);
            mysqli_stmt_bind_param($preparedStatement, 's', $username);
            mysqli_execute($preparedStatement);
            $result = mysqli_stmt_get_result($preparedStatement);
            $row = mysqli_fetch_array($result);
            return $result;
        }

        public function checkAccountPosts($username) {
            $sql = "SELECT * FROM posts WHERE author=?";
            $preparedStatement = mysqli_prepare($this->dbConn, $sql);
            mysqli_stmt_bind_param($preparedStatement, 's', $username);
            mysqli_execute($preparedStatement);
            $result = mysqli_stmt_get_result($preparedStatement);
            $row = mysqli_fetch_array($result);
            if(mysqli_num_rows($result) > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function deleteAllPostsFromAccount($username) {
            $sql = "DELETE FROM posts WHERE author=?";
            $preparedStatement = mysqli_prepare($this->dbConn, $sql);
            mysqli_stmt_bind_param($preparedStatement , 's', $username);
            mysqli_stmt_execute($preparedStatement);
        }

        public function deleteAccount($username) {
            $sql = "DELETE FROM users WHERE accountname=?";
            $preparedStatement = mysqli_prepare($this->dbConn, $sql);
            mysqli_stmt_bind_param($preparedStatement , 's', $username);
            mysqli_stmt_execute($preparedStatement);
        }
    
    }
?>
