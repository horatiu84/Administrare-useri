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

    /**
     * Get all existing users in the database
     *
     * @param object $db -connection to the database
     * @return array -associative array for all the users records
     */
public static function getAllUsers($db){
    $sql = "SELECT * FROM users
        ORDER BY id";
    $results = $db->query($sql);

    return $results->fetchAll(PDO::FETCH_ASSOC);
}

    public static function getById($db, $id)
    {
        $sql = "SELECT * 
            FROM users
            WHERE id = :id";

        $stmt = $db->prepare($sql);


        $stmt->bindValue(':id',$id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS,'Users');
        if ($stmt->execute()) {
            return $stmt->fetch();
        }

    }

    /**
     * Authenticate a user by username and password
     *
     * @param object $db -connection to the database
     * @param string $username Username
     * @param string $password Password
     *
     * @return bool true if the credentials are correct, null if not
     */

public static function authenticate($db,$username,$password){
// first we'll check if there is a user with the name that was typed in input in the db
    $sql = "SELECT * FROM users
            WHERE username= :username";

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':username',$username, PDO::PARAM_STR);
    $stmt->setFetchMode(PDO::FETCH_CLASS,'Users');
    $stmt->execute();

    if ($user = $stmt->fetch()) {
        // if the user exist we'll check if the password is a match also
//        return $user->password == $password;


        return md5($password) == $user->password;
    }
    // if the password won't match or the user is not in the db, this method will return null
}

    /**
     * Delete the current user
     *
     * @param $db -connection to the database
     * @return boolean True if delete was successful, false otherwise
     */
    public function deleteUser($db){
        $sql = "DELETE FROM users 
                WHERE id = :id";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Insert a new user in the database
     *
     * @param $db -connection to the database
     * @return boolean True if the insert was successful, false otherwise
     */
    public function createUser($db)
    {
            $sql = "INSERT INTO users (username,password) 
                VALUES (:username, :password)";

            $stmt = $db->prepare($sql);
            $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
            $stmt->bindValue(':password', $this->password, PDO::PARAM_STR);


            if ($stmt->execute()){
                $this->id=$db->lastInsertId();
                return true;
            };
    }
};