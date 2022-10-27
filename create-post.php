<?php
use Functions\Validation;

require_once('functions/db.php');
require_once('functions/helpers.php');

if (!isLoggedIn()) {
    redirect('login.php');
}

$page_title = "Create Post";

require_once('inc/header.php');

$title = $content = '';

$categories = dbSelect('categories');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('functions/validation.php');

    $validation = new Validation();
    $validation->inputs = $_POST;
    $validation->rules = [
        'title' => 'required|min:3',
        'content' => 'required|min:3',
        'category' => 'required|in_array:1,2',
    ];
    $validation->validate();
    $errors =  $validation->errors;

    $title = sanitizeInput($_POST['title']);
    $content = sanitizeInput($_POST['content']);
    $category = $_POST['category'];

    if(!is_array($errors) || count($errors) === 0){
        $success = dbInsert('posts', 'title, content, category_id, user_id', ':title, :content, :category_id, :user_id', ['title' => $title, 'content' => $content, 'category_id' => $category, 'user_id' => $_SESSION['id']]);
    }
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-8 offset-2">
            <h2 class="text-center">Create Post</h2>
            <form method="post">
                <div class="form-group ">
                    <label>Title:</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($title) ?>">
                </div>
                <div class="form-group ">
                    <label>Content:</label>
                    <textarea name="content" class="form-control"><?= htmlspecialchars($content) ?></textarea>
                </div>
                <div class="form-group ">
                    <label>Category:</label>
                    <select name="category" class="form-control">
                        <?php foreach ($categories as $category) { ?>
                            <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <?php 
                if(isset($errors) && is_array($errors) && count($errors) > 0){
                    foreach ($errors as $error) {
                        echo "<p class='alert alert-danger'>$error</p>";
                    }
                }
                if(isset($success)){
                    echo "<p class='alert alert-success'>Post added successfully</p>";
                }
                ?>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" value="Create">
                    <input type="reset" class="btn btn-danger" value="Reset">
                </div>
            </form>
        </div>
    </div>
    <div class="row mb-5 mt-3">
        <dic class="col-12 text-center">
            <a class="btn btn-primary" href="posts.php">My posts</a>
        </dic>
    </div>
</div>

<?php require_once('inc/footer.php'); ?>