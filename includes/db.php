<?php

// we do a function to make the connection with the db

function dbConnect() {

    $host = 'localhost';
    $user = 'root';
    $password = '';
    $dbName = 'administrare_useri';
    
    $db = mysqli_connect($host,$user,$password,$dbName);

    if(mysqli_connect_error()) {
        echo mysqli_connect_error();
        exit;
    };

    return $db;
}
