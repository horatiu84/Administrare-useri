<?php
require './classes/Database.php';
require  './classes/Users.php';
require './classes/Profile.php';


// we must call the method for db connection from the Database class
$conn = new Database();
$db = $conn->getConnection();
// we check if there exist a user with the provided id
if (isset($_GET['id'])) {

    $user = Users::getById($db,$_GET['id']);
    if ($user) {
        $id = $user->id;
    } else {
        die("User not found");
    }
} else {
    die("Id not supplied, user not found");
}

// in case of sending the form, with the post method, we'll move to manipulate the data in db
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $profile=Profile::getById($db,$id);

    if ($user->deleteUser($db) && $profile->deleteProfile($db)){
        header("Location: logout.php");
        exit;}

}

?>

<?php require './includes/header.php' ?>
<div class="container">
    <div class="text">
        Stergere user
    </div>

    <form method="post">
        
        <p class="delete">Esti sigur ca doresti stergerea userului : <strong> <?= $user->username ?></strong> ?</p>
        <div class="form-row submit-btn links">
            <div class="input-data">
                <div class="inner"></div>
                <input type="submit" value="Sterge">
            </div>
            <div class="input-data links">
                <div class="inner"></div>

                <a href="profile.php?id=<?= $user->id ?>">Anuleaza</a>
            </div>
        </div>
    </form>
</div>
<?php require_once './includes/footer.php'; ?>