<?php
include_once './includes/db.php';

session_start();
// in case of sending the form, with the post method, we'll move to manipulate the data in db
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = dbConnect();

    $errors = '';
    $username = $_POST['username'];
    $password = $_POST['password'];
// first we'll check if there is a user with the name that was typed in input in the db
    $sql = "SELECT * FROM users
            WHERE username = ?";

    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, 's', $username);
    if (mysqli_stmt_execute($stmt)) {
        $results = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_array($results, MYSQLI_ASSOC);
        if ($user) {
    // if the user exist we'll check if the password is a match also
            if (md5($password) == $user['password']) {
                $id = $user['id'];
                $_SESSION['is_logged_in'] = true;
                header("Location: profile.php?id=$id");
    // if the user or the password are not in the db, we'll post same error message, so 
    // the person trying to log in, won't have extra information, in case he's not so honest
    // and wants to hack our wonderful app ( I am so curios if you will read this Stefan :)) )             
            } else {
                $errors = "Date incorecte! Incearca din nou!";
            }
        } else {
            $errors = "Date incorecte! Incearca din nou!";
        }
    }
}


?>

<?php require 'includes/header.php' ?>
<div class="container">
    <div class="text">
        Logare user
    </div>

    <?php if (!empty($errors)) : ?>
        <p class="error"><?= $errors ?></p>
    <?php endif ?>
    <form method="post">
        <div class="form-row">
            <div class="input-data">
                <input type="text" id="username" name="username" required>
                <div class="underline"></div>
                <label for="username">Username</label>
            </div>
            <div class="input-data">
                <input type="password" id="password" name="password" required>
                <div class="underline"></div>
                <label for="password">Parola</label>
            </div>
        </div>
        <div class="form-row submit-btn">
            <div class="input-data">
                <div class="inner"></div>
                <input type="submit" value="Logeaza-te">
            </div>
        </div>
</div>

<?php require 'includes/footer.php' ?>