<?php require './classes/Database.php';
      require  './classes/Profile.php';

$conn = new Database();
$db = $conn->getConnection();
$id = $_GET['id'];
if (isset($_GET['id'])) {
    $profil = Profile::getById($db,$_GET['id']);
} else {
    $profil = null;
}


?>

<?php include_once './includes/header.php'; ?>
<div class="container">
    <div class="text">
        <h3>Profil user </h3>
    </div>

    <div class="profil">
        <p><strong>Nume :</strong> <?= $profil->full_name; ?></p>
        <p><strong>Email :</strong> <?= $profil->email; ?></p>
        <p><strong>Varsta :</strong> <?= $profil->age; ?></p>
        <p><strong>Bio : </strong><?= $profil->bio; ?></p>
    </div>
    <div class="form-row submit-btn links ">
        <div class="input-data links">
            <div class="inner"></div>
            <a href="edit.php?id=<?= $profil->user_id; ?>">Editeaza profil</a>
        </div>
        <div class="input-data links">
            <div class="inner"></div>
            <a href="delete.php?id=<?= $profil->user_id; ?>">Sterge user</a>
        </div>
        <div class="input-data links">
            <div class="inner"></div>
            <a href="index.php">Inapoi</a>
        </div>
    </div>
   
</div>

<?php include_once './includes/footer.php'; ?>