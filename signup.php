<?php
use Functions\Validation;

require_once('functions/db.php');
require_once('functions/helpers.php');

if (isLoggedIn()) {
    redirect('index.php');
}

$page_title = "Signup";

require_once('inc/header.php');

$name = $email = $errors = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once('functions/validation.php');

    $validation = new Validation();
    $validation->inputs = $_POST;
    $validation->rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'password' => 'required|min:6'
    ];
    $validation->validate();
    $errors =  $validation->errors;

    $name = sanitizeInput($_POST['name']);
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if(!is_array($errors) || count($errors) === 0){
        $emailExists = dbSelect('users', 'id', 'WHERE email = :email', ['email' => $email]);
        if(isset($emailExists[0]['id'])){
            $errors[] = 'Email already exists';
        }else{
            $id = dbInsert('users', 'name, email, password', ':name, :email, :password', ['name' => $name, 'email' => $email, 'password' => $password]);
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $id;

            redirect('index.php');
        }
    }
}
?>

<div class="container mb-5">
    <div class="row">
        <div class="col-6 offset-3">
            <h2 class="text-center">Signup</h2>
            <form method="post">
                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name); ?>">
                </div>
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
                    <input type="submit" class="btn btn-primary" value="Signup">
                </div>
            </form>
            <p>Do you have an account? <a href="login.php">Login now</a>.</p>
        </div>
    </div>
</div>
<?php require_once('inc/footer.php'); ?>