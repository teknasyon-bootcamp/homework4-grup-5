<?php
require_once  "db.class.php";

class Post extends DB
{
 
    private function myQuery($query, $params = null)
    {
        //diğer methodlardaki tekrarlı verileri bitirmek için kulllanılan method
        if (is_null($params)) {
            $this->stmt = $this->pdo->query($query);
        } else {
            $this->stmt = $this->pdo->prepare($query);
            $this->stmt->execute($params);
        }
        return $this->stmt;
    }



    public function getRows($query, $params = null)
    {
        //çoklu satır veri kullanımı için (tüm satır ve sütünlar)
        try {

            //Veritabanındaki birden çok satıra etki etmek için fetchAll() methodu kullanılır.
            return $this->myQuery($query, $params)->fetchAll();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    public function getRow($query, $params = null)
    {
        //tek satır kullanımı için
        try {

            //Veritabanındaki tekbir satıra etki etmek için fetch() methodu kullanılır.
            return $this->myQuery($query, $params)->fetch();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    public function getColumn($query, $params = null)
    {
        //tek bir sütündaki tek bir satır için (yani tek hücre gibi)
        try {

            //Veritabanındaki tek bir veriye etki etmek için fetchColumn() methodu kullanılır.
            return $this->myQuery($query, $params)->fetchColumn();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    public function Insert($query, $params = null)
    {
        //kayıt eklemek için
        try {
            $this->myQuery($query, $params);
            //lastInsertId() methodu en son eklenen verinin id'sini döndürür.
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    public function Update($query, $params = null)
    {
        //kayıt güncellemek için
        try {
            //rowCount() methodu kaç satırın etkilendiğini(güncellendiğini) döndürür.
            return $this->myQuery($query, $params)->rowCount();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    public function Delete($query, $params = null)
    {
        //kayıt silmek için

        //oluşturduğumuz delete() methodu update ile aynı, ancak silme ve güncelleme işlmeleri karışmaması için farklı isim verdik.
        return $this->Update($query, $params);
    }



}


