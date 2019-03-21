<?php
 

class Price {

 

    // テーブル名の定義

    protected $table = "price";

 

    public function insertData($condition) {

        try {

            $db = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = " INSERT INTO ".$this->table."(target_date, hotel_id, min_price, max_price) VALUES (?, ?, ?, ?); ";

            $parameter = [$condition["target_date"], $condition["hotel_id"], $condition["min_price"], $condition["max_price"]];

            $statement = $db->prepare($sql);

            $statement->execute($parameter);

        } catch (PDOException $e) {

            var_dump($e);

            exit;

        } 

    }

}
?>
