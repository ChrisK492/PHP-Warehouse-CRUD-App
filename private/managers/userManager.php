<?php

class userManager
{

    public static function GetAllUsers(): array
    {
        global $con;
        $stmt = $con->prepare("SELECT * FROM user");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public static function GetUserByName($userName): object|false
    {
        global $con;
        $stmt = $con->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->bindValue(1, $userName);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    public static function getUserByID($id) : object{
        global $con;
        $stmt = $con->prepare("SELECT * FROM user WHERE id = ?");
        $stmt->bindValue(1, $id);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    public static function InsertUser($username, $email, $is_admin, $profile_picture, $password): void
    {
        global $con;
        $stmt = $con->prepare("INSERT INTO user (username, email, is_admin, profile_picture, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bindValue(1, $username);
        $stmt->bindValue(2, $email);
        $stmt->bindValue(3, $is_admin);
        $stmt->bindValue(4, $profile_picture);
        $stmt->bindValue(5, $password);
        $stmt->execute();
    }


    public static function deleteUserById($id) : void{
        global $con;
        $stmt = $con->prepare('DELETE FROM user WHERE id = ?');
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }

    public static function UpdateUserById($username, $email, $is_admin, $profile_picture, $password, $id) : void{
        global $con;
        $stmt = $con->prepare("UPDATE user SET username = ?, email = ?, is_admin = ?, profile_picture = ?, password = ? WHERE id = ?");
        $stmt->bindValue(1, $username);
        $stmt->bindValue(2, $email);
        $stmt->bindValue(3, $is_admin);
        $stmt->bindValue(4, $profile_picture);
        $stmt->bindValue(5, $password);
        $stmt->bindValue(6, $id);
        $stmt->execute();
    }
}
