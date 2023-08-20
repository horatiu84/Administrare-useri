<?php require './classes/Database.php';
    require './classes/Profile.php';


// we must call the function for db connection
$conn = new Database();
$db = $conn->getConnection();
// we check if there exist a profile with the provided id
if (isset($_GET['id'])) {

    $profil = Profile::getById($db,$_GET['id']);

    if ($profil) {
        $user_id = $profil->user_id;
        $fullname = $profil->full_name;
        $email = $profil->email;
        $age = $profil->age;
        $bio = $profil->bio;
    } else {
        die("Profilul nu a fost gasit");
    }
} else {
    die("Id inexistent, Profilul nu a fost gasit");
}
// in case of sending the form, with the post method, we'll move to manipulate the data in db
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $profil->full_name = $_POST['fullname'];
    $profil->email = $_POST['email'];
    $profil->age = $_POST['age'];
    $profil->bio = $_POST['bio'];

    if($profil->update($db)) {
            header("Location: profile.php?id=$user_id");
            exit;
    }
}

?>

<?php include_once "./includes/header.php"; ?>

<div class="container">
    <div class="text">
        Editeaza profil user :
    </div>

    <form method="post">
        <div class="form-row">
            <div class="input-data">
                <input type="text" name="fullname" id="fullname" required value="<?= htmlspecialchars($fullname) ?>">
                <div class="underline"></div>
                <label for="fullname">Nume complet:</label>
            </div>
            <div class="input-data">
                <input type="text" name="age" id="age" required value="<?= htmlspecialchars($age) ?>">
                <div class="underline"></div>
                <label for="age">Varsta:</label>
            </div>
        </div>
        <div class="form-row">
            <div class="input-data">
                <input type="email" name="email" id="email" required value="<?= htmlspecialchars($email) ?>">
                <div class="underline"></div>
                <label for="email">Adresa email:</label>
            </div>
        </div>
        <div class="form-row">
            <div class="input-data textarea">
                <textarea name="bio" id="bio" required cols="8" rows="80"><?= htmlspecialchars($bio) ?></textarea>
                <br />
                <div class="underline"></div>
                <label for="bio">Biografie:</label>
            </div>
        </div>
        <div class="form-row submit-btn ">
            <div class="input-data">
                <div class="inner"></div>
                <input type="submit" value="Salveaza">
            </div>
            <div class="input-data links">
                <div class="inner"></div>
                <a href="profile.php?id=<?=$user_id?>">Anuleaza</a>
            </div>
        </div>
        
    </form>

</div>
<?php include_once './includes/footer.php'; ?>