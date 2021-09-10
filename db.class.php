<?php

class DB
{
    

    public function __construct(
        private ?string $host = "mariadb",
        private ?string $root = "root",
        private ?string $root_password = "root",
        private ?string $db_name = "odev",
        private ?bool $connect = null
    ) {

        //bağlantıyı paylaş
        $this->ConnectDB();

        if (!$this->connect) {
            $pdo = new PDO("mysql:host=$host", $root, $root_password);
            try {
                $pdo->exec("CREATE DATABASE IF NOT EXISTS $this->db_name;
                CREATE TABLE odev.posts ( post_id INT NOT NULL AUTO_INCREMENT , post_title TEXT NOT NULL , post_content TEXT NOT NULL , PRIMARY KEY (post_id));")
                    or die(print_r($pdo->errorInfo(), true));
            } catch (PDOException $e) {
                echo "Tablo var!";
            }
        }
    }



    private function ConnectDB()
    {
        //database connection
        $SQL = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
        try {
            $this->pdo = new \PDO($SQL, $this->root, $this->root_password);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->connect = $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("PDO ile veritabanına ulaşılamadı<hr>" . $e->getMessage());
        }
    }








    public function __destruct()
    {
        //bağlantıyı kapat
        $this->pdo = null;
    }
}
