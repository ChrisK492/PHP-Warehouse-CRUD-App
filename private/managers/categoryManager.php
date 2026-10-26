<?php

class categoryManager{
    public static function getAllCategories() : array{
        global $con;
        $stmt = $con->prepare("SELECT * FROM category");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}


?>