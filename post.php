<?php
use Functions\Validation;

require_once('functions/db.php');
require_once('functions/helpers.php');

$page_title = "Post";

require_once('inc/header.php');

$id = $_GET['id'];
if(!is_numeric($id)){
   redirect('index.php');
}
$post = dbSelect('posts', '*', 'WHERE id = :id', ['id' => $id]);
if(!isset($post[0])){
   redirect('index.php');
}

$title = $post[0]['title'];
$content = $post[0]['content'];
$cat = $post[0]['category_id'];
?>

<div class="container-fluid post-page">
   <div class="row">
<div class="card col-8 m-auto" style="width: 18rem;">
  <img src="https://picsum.photos/200/300?random=<?= $id ?>" class="card-img-top img-fluid" alt="Post Image">
  <div class="card-body">
    <h5 class="card-title"><?= $title ?></h5>
    <p class="card-text"><?= $content ?></p>
  </div>
</div>
</div>
</div>

<?php require_once('inc/footer.php'); ?>