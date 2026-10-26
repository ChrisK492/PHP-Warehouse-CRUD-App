<?php

class productmanager
{
    public static function getAllProducts(): array
    {
        global $con;
        $stmt = $con->prepare("SELECT * FROM product");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function deleteById($productId): void
    {
        global $con;

        // foto ophalen
        $stmt1 = $con->prepare("SELECT photo from product WHERE id = ?");
        $stmt1->bindValue(1, $productId);
        $stmt1->execute();
        $product = $stmt1->fetch(PDO::FETCH_OBJ);


        // foto verwijderen uit systeem
        if ($product && !empty($product->photo)) {
            if (file_exists($product->photo)) {
                unlink($product->photo);
            }
        }

        // stock change verwijderen
        $stmt2 = $con->prepare("DELETE FROM stock_change WHERE product_id = ?");
        $stmt2->bindValue(1, $productId);
        $stmt2->execute();



        // product verwijderen
        $stmt3 = $con->prepare("DELETE FROM product WHERE id = ?");
        $stmt3->bindValue(1, $productId);
        $stmt3->execute();
    }

    public static function addProduct($name, $price, $amount_in_storage, $minimum_in_storage, $photo, $category_id): void
    {
        global $con;
        $stmt = $con->prepare("INSERT INTO product (name, price, amount_in_storage, minimum_in_storage, photo, category_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $price);
        $stmt->bindValue(3, $amount_in_storage);
        $stmt->bindValue(4, $minimum_in_storage);
        $stmt->bindValue(5, $photo);
        $stmt->bindValue(6, $category_id);
        $stmt->execute();
    }

    public static function getProductById($id): object
    {
        global $con;
        $stmt = $con->prepare("SELECT product.*, category.name as category FROM product JOIN category on product.category_id = category.id WHERE product.id = ?");
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    public static function updateProductById($name, $price, $amount_in_storage, $minimum_in_storage, $photo, $category_id, $id)
    {
        global $con;
        $stmt = $con->prepare("UPDATE product SET name = ?, price = ?, amount_in_storage = ?, minimum_in_storage = ?, photo = ?, category_id = ? WHERE id = ?");
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $price);
        $stmt->bindValue(3, $amount_in_storage);
        $stmt->bindValue(4, $minimum_in_storage);
        $stmt->bindValue(5, $photo);
        $stmt->bindValue(6, $category_id);
        $stmt->bindValue(7, $id);
        $stmt->execute();
    }

    public static function updateAmountInStorageById($amount_in_storage, $id) : void
    {
        global $con;
        $stmt = $con->prepare("UPDATE product SET amount_in_storage = ? WHERE id = ?");
        $stmt->bindValue(1, $amount_in_storage);
        $stmt->bindValue(2, $id);
        $stmt->execute();
    }
}
