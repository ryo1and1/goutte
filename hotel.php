<?php
 

class Hotel {

 

    // テーブル名の定義

    protected $table = "hotel";

 

    public function insertData($condition) {

        try {

            $db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = " INSERT INTO ".$this->table."(name, link, area, place) VALUES (?, ?, ?, ?); ";

            $statement = $db->prepare($sql);

            $parameter = [$condition["name"], $condition["link"], $condition["area"], $condition["place"]];

            $statement->execute($parameter);

            return $db->lastInsertId();

        } catch (PDOException $e) {

            var_dump($e);

            exit;

        } 

    }

}
?>
