<?php

class Profile
{
    public $id;
    public $user_id;
    public $full_name;
    public $email;
    public $age;
    public $bio;

    /**
     * Get the profile record based on the ID
     *
     * @param $db -connection to the database
     * @param $id integer id of the user
     *
     * @return mixed An object containing the article with that ID, or null if not found
     */
    public static function getById($db, $id)
    {
        $sql = "SELECT * 
            FROM profiles
            WHERE id = :id";

        $stmt = $db->prepare($sql);
        // var_dump($stmt);

        $stmt->bindValue(':id',$id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS,'Profile');
        if ($stmt->execute()) {
            return $stmt->fetch();
        }

    }

    /**
     * Delete the current profile
     *
     * @param $db -connection to the database
     * @return boolean True if delete was successful, false otherwise
     */
    public function deleteProfile($db){
        $sql = "DELETE FROM profiles 
                WHERE id = :id";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Update the article with its current prop values
     *
     * @param object $db -connection to the database
     * @return boolean true if the update was succesful, false if not
     */
    public  function update($db): bool
    {
            $sql = "UPDATE profiles 
                SET full_name = :full_name,
                    email = :email,
                    age = :age,
                    bio = :bio
                WHERE id = :id";

            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
            $stmt->bindValue(':full_name', $this->full_name, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':age', $this->age, PDO::PARAM_INT);
            $stmt->bindValue(':bio', $this->bio, PDO::PARAM_STR);

            return $stmt->execute();

    }

    public function createProfile($db)
    {
        $sql = "INSERT INTO profiles (user_id,full_name,email,age,bio)
                VALUES (:user_id, :full_name, :email, :age, :bio)";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $this->user_id, PDO::PARAM_INT);
        $stmt->bindValue(':full_name', $this->full_name, PDO::PARAM_STR);
        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindValue(':age', $this->age, PDO::PARAM_INT);
        $stmt->bindValue(':bio', $this->bio, PDO::PARAM_STR);

        if ($stmt->execute()){
            $this->id=$db->lastInsertId();
            return true;
        };
    }

}