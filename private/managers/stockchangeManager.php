<?php

class stockchangeManager
{
    public static function getStockChangeById($productId): object | bool
    {
        global $con;
        $stmt = $con->prepare("SELECT * FROM warehouse_2026.stock_change LEFT JOIN product on stock_change.product_id = product.id WHERE product.id = ?");
        $stmt->bindValue(1, $productId);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    public static function insertStockChange($userId, $quantity_change, $old_stock, $new_stock, $ChangeDate, $productId) : void
    {
        global $con;
        $stmt = $con->prepare("INSERT into stock_change (user_id, quantity_change, old_stock, new_stock, ChangeDate, product_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bindValue(1, $userId);
        $stmt->bindValue(2, $quantity_change);
        $stmt->bindValue(3, $old_stock);
        $stmt->bindValue(4, $new_stock);
        $stmt->bindValue(5, $ChangeDate);
        $stmt->bindValue(6, $productId);
        $stmt->execute();
    }
}
