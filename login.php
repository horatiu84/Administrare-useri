<?php
require './classes/Users.php';
require './classes/Database.php';

session_start();
// in case of sending the form, with the post method, we'll move to manipulate the data in db
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn=new Database();
    $db=$conn->getConnection();

    $errors = '';

    if(Users::authenticate($db,$_POST['username'],$_POST['password'])){
        session_regenerate_id(true);
        $_SESSION['is_logged_in'] = true;
        header("Location: index.php");
    } else {
        $errors = "Date incorecte! Incearca din nou!";
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