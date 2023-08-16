<?php include_once './includes/db.php';
include_once './includes/functions.php';

session_start();

$errors = [];
$username = '';
$password = '';
$fullname = '';
$email = '';
$age = '';
$bio = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = dbConnect();
    $username = $_POST['username'];
    $password = $_POST['password'] ? md5($_POST['password']) : '';
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $bio = $_POST['bio'];


    $errors = validateUser($username, $password, $fullname, $email);

    // check if the user name is already in the db, if yes add this to the error array

    $sqlCheckUser = "SELECT * FROM users
                     WHERE username = ?";
    $stmtUserCheck = mysqli_prepare($db, $sqlCheckUser);
    mysqli_stmt_bind_param($stmtUserCheck, "s", $username);
    if (mysqli_stmt_execute($stmtUserCheck) && !empty($username)) {
        $reslults = mysqli_stmt_get_result($stmtUserCheck);
        $nameUser = mysqli_fetch_array($reslults, MYSQLI_ASSOC);
        if ($nameUser) {
            $errors[] = "Username exista in baza de date, alege altul!";
        }
    }

    if (empty($errors)) {


        //  METHOD TO AVOID SQL INJECTIONS
        //1.Write sql that contains placeholders for values
        $sqlUser = "INSERT INTO users (username,password)
            VALUES (?,?)";
        // 2. prepare the statement
        $stmtUser = mysqli_prepare($db, $sqlUser);
        // 3.Bind the parameters to the placeholders
        mysqli_stmt_bind_param($stmtUser, "ss", $username, $password);
        // 4. we execute the statement, if return true is success
        mysqli_stmt_execute($stmtUser);
        $id = mysqli_insert_id($db);

        // We repeat the process for the profiles table
        $sqlProfil = "INSERT INTO profiles (user_id,full_name,email,age,bio)
            VALUES (?,?,?,?,?)";
        $stmtProfil = mysqli_prepare($db, $sqlProfil);
        mysqli_stmt_bind_param($stmtProfil, "issis", $id, $fullname, $email, $age, $bio);

        // after we register, we'll be logged in 
        if (mysqli_stmt_execute($stmtProfil)) {
            $_SESSION['is_logged_in'] = true;
            header("Location: profile.php?id=$id");
            exit;
        } else {
            echo mysqli_stmt_error($stmtProfil);
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