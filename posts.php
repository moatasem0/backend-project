<?php
use Functions\Validation;

require_once('functions/db.php');
require_once('functions/helpers.php');

if (!isLoggedIn()) {
    redirect('login.php');
}

$page_title = "Posts";

require_once('inc/header.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once('functions/validation.php');

    $validation = new Validation();
    $validation->inputs = $_POST;
    $validation->rules = [
        'id' => 'required|numeric'
    ];
    $validation->validate();
    $errors =  $validation->errors;

    $id = $_POST['id'];

    if(!is_array($errors) || count($errors) === 0){
        $authorId = dbSelect('posts', 'user_id', 'WHERE id = :id', ['id' => $id]);

        if(!isset($authorId[0]['user_id']) || $authorId[0]['user_id'] != $_SESSION['id']){
            echo '<p class="alert alert-danger">Post already deleted</p>';
        }else{
            dbDelete('posts', 'WHERE id = :id', ['id' => $id]);
            echo '<p class="alert alert-success">Post deleted successfully</p>';
        }
    }else{
        foreach ($errors as $error) {
            echo "<p class='alert alert-danger'>$error</p>";
        }
    }
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-10 offset-1 text-center">
            <?php $posts = dbSelect('posts', '*', 'WHERE user_id = :id', ['id' => $_SESSION['id']]); ?>
            <?php if(!is_array($posts) || count($posts) === 0){ 
                echo "<div class='alert alert-info'>You have no posts.</div>";
            } else {
            ?>
            <div class='table-responsive'>
                <table class='table table-bordered table-striped'>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>title</th>
                            <th>actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; ?>
                        <?php foreach($posts as $post){ ?>
                        <tr>
                            <td><?= $counter ?></td>
                            <td><?= $post['title'] ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="id" value="<?= $post["id"] ?>">
                                    <input class="btn btn-danger" type="submit" value="Delete">
                                    <a class="btn btn-success" href="edit-post.php?id=<?= $post['id'] ?>">Edit</a>
                                </form>
                            </td>
                        </tr>
                        <?php $counter++; ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="row">
        <div class="col-8 offset-2 text-center">
            <div class="mt-5">
                <a class="btn btn-primary" href="create-post.php">Create Post</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('inc/footer.php'); ?>