<?php
require "./includes/db.php";
require "./includes/functions.php";



// we must call the function for db connection
$db = dbConnect();
// we check if there exist a user with the provided id
if (isset($_GET['id'])) {

    $user = getUser($db, $_GET['id']);
    if ($user) {
        $id = $user['id'];
    } else {
        die("User not found");
    }
} else {
    die("Id not supplied, user not found");
}

// in case of sending the form, with the post method, we'll move to manipulate the data in db
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // we delete the user
    $sqlUser = "DELETE FROM users 
            WHERE id = ?";
    $stmtUser = mysqli_prepare($db, $sqlUser);
    mysqli_stmt_bind_param($stmtUser, "i", $id);

    // we delete the profile of the user
    $sqlProfil = "DELETE FROM profiles 
            WHERE user_id = ?";
    $sqlProfil = mysqli_prepare($db, $sqlProfil);
    mysqli_stmt_bind_param($sqlProfil, "i", $id);


     // after deletion, we also log out the user
    if (mysqli_stmt_execute($stmtUser) && mysqli_stmt_execute($sqlProfil)) {

        header("Location: logout.php");
        exit;
    } else {
        echo mysqli_stmt_error($stmtUser);
        echo mysqli_stmt_error($sqlProfil);
    }
}

?>

<?php require './includes/header.php' ?>
<div class="container">
    <div class="text">
        Stergere user
    </div>

    <form method="post">
        
        <p class="delete">Esti sigur ca doresti stergerea userului : <strong> <?= $user['username'] ?></strong> ?</p>
        <div class="form-row submit-btn links">
            <div class="input-data">
                <div class="inner"></div>
                <input type="submit" value="Sterge">
            </div>
            <div class="input-data links">
                <div class="inner"></div>

                <a href="profile.php?id=<?= $user['id'] ?>">Anuleaza</a>
            </div>
        </div>
    </form>
</div>
<?php require_once './includes/footer.php'; ?>