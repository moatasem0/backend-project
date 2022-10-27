<?php
require_once('functions/db.php');
require_once('functions/helpers.php');

$page_title = "Home";

require_once('inc/header.php');
?>

<div class="container mt-5">
  <?php
  $posts = dbSelect('posts');
  if (!is_array($posts) || count($posts) === 0) {
    echo "<h3>No Posts</h3>";
  } else {
  ?>
    <div class="row">
      <?php foreach ($posts as $post) { ?>
        <div class="col-4 col-md-6 col-sm-12">
          <div class="card">
            <img src="https://picsum.photos/200/300?random=<?= $post['id'] ?>" class="card-img-top img-thumbnail" alt="Post Image">
            <div class="card-body">
              <h5 class="card-title"><?= $post['title'] ?></h5>
              <p class="card-text"><?php if(strlen($post['content']) > 150){ echo substr($post['content'], 0, 150) . '...'; }else{ echo $post['content']; } ?></p>
              <a href="post.php?id=<?= $post['id'] ?>" class="btn btn-primary">View Post</a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  <?php } ?>
</div>

<?php require_once('inc/footer.php'); ?>