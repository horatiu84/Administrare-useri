<?php require './classes/Database.php';
    require './classes/Users.php';
    require './classes/Profile.php';

session_start();

$user = new Users();
$profile = new Profile();


$errors = [];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new Database();
    $db = $conn->getConnection();
    $user->username = $_POST['username'];
    $user->password = $_POST['password'] ? md5($_POST['password']) : '';
    $profile->full_name = $_POST['fullname'];
    $profile->email = $_POST['email'];
    $profile->age = $_POST['age'];
    $profile->bio = $_POST['bio'];


    // check if the username is already in the db, if yes add this to the error array

    $sqlCheckUser = "SELECT * FROM users
                     WHERE username = :username";

    $stmt = $db->prepare($sqlCheckUser);
    $stmt->bindValue(':username',$_POST['username'], PDO::PARAM_STR);
    $stmt->setFetchMode(PDO::FETCH_CLASS,'Users');
    if ($stmt->execute() ){
        $result = $stmt->fetch();
        if ($result){
            $errors[] = "Username exista in baza de date, alege altul!";
    }
};

    if (empty($errors)) {


        // after we register, we'll be logged in
        if ($user->createUser($db)) {
            $profile->user_id = $db->lastInsertId();
            if($profile->createProfile($db)) {
            $_SESSION['is_logged_in'] = true;
            header("Location: profile.php?id=$profile->user_id");
            exit;
        }
    }
    }
}
?>


<?php include_once "./includes/header.php" ?>
<div class="container">
    <div class="text">
        Inregistrare user nou
    </div>

    <?php if (!empty($errors)) : ?>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li class="error" ><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post">
        <div class="form-row">
            <div class="input-data">
                <input required type="text" name="username" id="username">
                <div class="underline"></div>
                <label for="">Username:</label>
            </div>
            <div class="input-data">
                <input type="password" required name="password" id="password">
                <div class="underline"></div>
                <label for="password">Parola:</label>
            </div>
        </div>
        <div class="form-row">
            <div class="input-data">
                <input required type="text" name="fullname" id="fullname">
                <div class="underline"></div>
                <label for="fullname">Nume complet:</label>
            </div>
            <div class="input-data">
                <input required type="text" required name="age" id="age">
                <div class="underline"></div>
                <label for="age">Varsta:</label>
            </div>
        </div>
        <div class="form-row">
            <div class="input-data">
                <input required type="email" name="email" id="email">
                <div class="underline"></div>
                <label for="email">Adresa de email:</label>
            </div>
        </div>
        <div class="form-row">
            <div class="input-data textarea">
                <textarea name="bio" id="bio" required cols="8" rows="80"></textarea>
                <br />
                <div class="underline"></div>
                <label for="bio">Biografie:</label>
            </div>
        </div>
        <div class="form-row submit-btn">
            <div class="input-data">
                <div class="inner"></div>
                <input type="submit" value="Salveaza">
            </div>
        </div>
    </form>
</div>



<?php include_once './includes/footer.php'; ?>