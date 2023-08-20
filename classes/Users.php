<?php
/**
 *A person who can log in the site or can create a profile
 */
class Users
{
    /**
     * @var int Unique identifier
     */
public $id;
    /**
     * @var string Unique username
     */
public $username;
    /**
     * @var string User's password
     */
public $password;

public static function getAllUsers($db){
    $sql = "SELECT * FROM users
        ORDER BY id";
    $results = $db->query($sql);

    return $results->fetchAll(PDO::FETCH_ASSOC);
}
};