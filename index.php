<?php include_once './includes/db.php';
session_start();
$db = dbConnect();
$sql = "SELECT * FROM users
        ORDER BY id";

$results = mysqli_query($db, $sql);

$users = mysqli_fetch_all($results, MYSQLI_ASSOC);
?>

<?php include_once './includes/header.php'; ?>
<div class="container">
    <div class="index">

        <?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) : ?>
            <p>Felicitari, esti logat! <a href="logout.php">Log Out</a></p>
            <h4>Useri in baza de date :</h4>

            <ul>
                <?php foreach ($users as $user) : ?>
                    <li class="users"> <a  href="profile.php?id=<?= $user['id'] ?>"> <?= $user['username'] ?></a></li>
                <?php endforeach ?>
            </ul>

        <?php else : ?>
            <p>Inca nu te-ai logat! Te poti loga de aici : <a href="login.php">Log in</a></p>
            <p>Sau fa-ti un cont aici : <a href="register.php">Inregistrare</a></p>
        <?php endif ?>
    </div>
</div>




<?php include_once './includes/footer.php'; ?>