<?php


// we make a function so we can get the profile from the db, based on the id
function getProfile($db, $id, $column = '*')
{
    $sql = "SELECT $column 
            FROM profiles
            WHERE user_id = ?";

    $stmt = mysqli_prepare($db, $sql);
    if ($stmt === false) {
        echo mysqli_error($db);
    } else {
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            return mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
    }
};

// we make a function so we can get the user from the db, based on the id
function getUser($db, $id, $column = '*')
{
    $sql = "SELECT $column 
            FROM users
            WHERE id = ?";

    $stmt = mysqli_prepare($db, $sql);
    if ($stmt === false) {
        echo mysqli_error($db);
    } else {
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            return mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
    }
};


// we make a function so we can validate the user, at register form 
function validateUser($username,$password,$fullname,$email) {
    $errors = [];
 
     if ($username == '') {
         $errors[] = 'Username is required';
     }
 
     if ($password === '') {
         $errors[] = 'Password is required';
     }
     
     if ($fullname == '') {
        $errors[] = 'Fullname is required';
    }

     if ($email == '') {
        $errors[] = 'Email is required';
    }
    
     return $errors;
     
 }
 
 // we make a function so we can validate the profile, at register form 
 function validateProfil($fullname,$email) {
    $errors = [];
     if ($fullname == '') {
        $errors[] = 'Fullname is required';
    }

     if ($email == '') {
        $errors[] = 'Email is required';
    }
    
     return $errors;
     
 }
 



 