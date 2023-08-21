<?php

/**
 * Database
 *
 * A connection to the database
 */
class Database
{
    /**
     * Get the database connection
     *
     * @return PDO object Connection to the database server
     */
    public function getConnection(){
        $host = 'localhost';
        $user = 'root';
        $password = '';
        $dbName = 'administrare_useri';

        $dsn = 'mysql:host=' . $host . ';dbname=' .$dbName . ';charset=utf8';

        try {
            $db =  new PDO($dsn,$user,$password);
            $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }
}