<?php 
   class DB {
        private $db_host = "localhost";
        private $db_user = "root";
        private $db_password = "";
        private $db_name = "test";
        private $conn = null;
        public $err = null;
        
        public function __construct(?string $db_name = "test",
                                    ?string $db_host = "localhost", 
                                    ?string $db_user = "root",
                                    ?string $db_password = "") {  
            $this->db_host = $db_host;
            $this->db_user = $db_user;
            $this->db_password = $db_password;
            $this->db_name = $db_name;

            $this->try_db_connection();
        } 

        private function try_db_connection() {
            try {
                $this->conn = mysqli_connect($this->db_host, 
                                             $this->db_user, 
                                             $this->db_password, 
                                             $this->db_name);
                $this->create_users_db($this->conn);
                $this->err = null;
            } catch (Exception $e) {
                $this->err = $e->getMessage();
            }
        }

        private function create_users_db(mysqli &$connection) {
            $create_table_query = "CREATE TABLE IF NOT EXISTS `$this->db_name`.`users`(
                `id` INT NOT NULL AUTO_INCREMENT,
                `username` VARCHAR(20) NOT NULL,
                `password` VARCHAR(255) NOT NULL,
                `reg_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                UNIQUE (`username`)
            )
            ENGINE = InnoDB;
            ";

            $connection->query($create_table_query);
        }

        public function insert_user(string $username, string $password){
            $password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (username, password)
            VALUES ('$username', '$password');
            ";

            try {
                mysqli_query($this->conn, $query);
                $this->err = null;
            } catch (Exception $e) {
                $this->err = $e->getMessage();
            }
            mysqli_close($this->conn);
        }

        public function get_users() : array|null {
            $query = "SELECT * FROM users
            ORDER BY `id` DESC;";

            $result = array();
            $rows = mysqli_query($this->conn, $query);

            if (mysqli_num_rows($rows) < 1) {
                return null;
            }

            while ($row = mysqli_fetch_array($rows)) {
                array_push($result, $row);
            }

            return $result;
        }

        public function get_user(int $id) : array|null {
            $query = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($this->conn, $query);

            if (mysqli_num_rows($result) > 0) {
                return mysqli_fetch_assoc($result);
            }

            return null;
        }
    }