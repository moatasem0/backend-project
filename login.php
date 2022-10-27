<?php
use Functions\Validation;

require_once('functions/db.php');
require_once('functions/helpers.php');

if (isLoggedIn()) {
    redirect('index.php');
}

$page_title = "Login";

require_once('inc/header.php');

$email = $errors = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once('functions/validation.php');

    $validation = new Validation();
    $validation->inputs = $_POST;
    $validation->rules = [
        'email' => 'required|email',
        'password' => 'required'
    ];
    $validation->validate();
    $errors =  $validation->errors;

    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!is_array($errors) || count($errors) === 0){
        $user = dbSelect('users', 'id, password', 'WHERE email = :email', ['email' => $email]);
        if(!isset($user[0]['password']) || !password_verify($password, $user[0]['password'])){
            $errors[] = 'Invalid email or password';
        }else{
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $user[0]['id'];

            redirect('index.php');
        }
    }
}
?>

<div class="container mb-5">
    <div class="row">
        <div class="col-6 offset-3">
            <h2 class="text-center">Login</h2>
            <form method="post">
                <div class="form-group">
                    <label>Email:</label>
                    <input type="text" name="email" class="form-control" value="<?= htmlspecialchars($email); ?>">
                </div>
                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <?php 
                if(isset($errors) && is_array($errors) && count($errors) > 0){
                    foreach ($errors as $error) {
                        echo "<p class='alert alert-danger'>$error</p>";
                    }
                }
                ?>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Login">
                </div>
            </form>
            <p>Don't have an account? <a href="signup.php">Sign up now</a>.</p>
        </div>
    </div>
</div>
<?php require_once('inc/footer.php'); ?>