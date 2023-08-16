<?php include_once './includes/db.php'; ?>

<?php
$db = dbConnect();
$id = $_GET['id'];
$sql = "SELECT * FROM profiles
        WHERE user_id = ?";

$stmt = mysqli_prepare($db, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$profil = mysqli_fetch_array($result, MYSQLI_ASSOC);

?>

<?php include_once './includes/header.php'; ?>
<div class="container">
    <div class="text">

        <h3>Profil user </h3>
    </div>

    <div class="profil">
        <p><strong>Nume :</strong> <?= $profil['full_name'] ?></p>
        <p><strong>Email :</strong> <?= $profil['email'] ?></p>
        <p><strong>Varsta :</strong> <?= $profil['age'] ?></p>
        <p><strong>Bio : </strong><?= $profil['bio'] ?></p>
    </div>
    <div class="form-row submit-btn links ">
        <div class="input-data links">
            <div class="inner"></div>
            <a href="edit.php?id=<?= $profil['user_id'] ?>">Editeaza profil</a>
        </div>
        <div class="input-data links">
            <div class="inner"></div>
            <a href="delete.php?id=<?= $profil['user_id'] ?>">Sterge user</a>
        </div>
        <div class="input-data links">
            <div class="inner"></div>
            <a href="index.php">Inapoi</a>
        </div>
    </div>
   
</div>

<?php include_once './includes/footer.php'; ?>