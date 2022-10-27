<?php
use Functions\Validation;

require_once('functions/db.php');
require_once('functions/helpers.php');

if (!isLoggedIn()) {
    redirect('login.php');
}

$page_title = "Edit Post";

require_once('inc/header.php');

$id = $_GET['id'];
if(!is_numeric($id)){
    redirect('posts.php');
}
$post = dbSelect('posts', '*', 'WHERE id = :id', ['id' => $id]);
if(!isset($post[0]) || $post[0]['user_id'] != $_SESSION['id']){
    redirect('posts.php');
}
$title = $post[0]['title'];
$content = $post[0]['content'];
$cat = $post[0]['category_id'];

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
    $cat = $_POST['category'];

    if(!is_array($errors) || count($errors) === 0){
        $success = dbUpdate('posts', 'title = :title, content = :content, category_id = :category', "WHERE id = :id", ['title' => $title, 'content' => $content, 'category' => $cat, 'id' => $id]);
    }
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-8 offset-2">
            <h2 class="text-center">Edit Post</h2>
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
                            <option value="<?= $category['id'] ?>" <?php if($cat == $category['id']){ echo 'selected = "selected"'; } ?>><?= $category['name'] ?></option>
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
                    echo "<p class='alert alert-success'>Post Updated successfully</p>";
                }
                ?>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" value="Update">
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