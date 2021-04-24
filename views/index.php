<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Commentaires imbriqués</title>
    <link href="css/app.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Commentaires</a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        </div>
    </div>
</nav>

<div class="container">

    <!-- Messages flash -->
    <?php if(isset($_SESSION['slim.flash'])): ?>
        <?php foreach($_SESSION['slim.flash'] as $type => $message): ?>
            <div class="alert alert-<?= $type; ?>">
                <p><?= $message; ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php
    $comments = new App\Comments($app->pdo);
    ?>

    <?php foreach($comments->findAllWithChildren(1) as $comment): ?>
        <?php require('comment.php'); ?>
    <?php endforeach; ?>

    <form action="" id="form-comment" method="post">
        <input type="hidden" name="parent_id" value="0" id="parent_id">
        <input type="hidden" name="post_id" value="1" id="post_id">
        <h4>Poster un commentaire</h4>
        <div class="form-group">
            <textarea name="content" id="content" class="form-control" placeholder="Votre commentaire" required></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Commenter</button>
        </div>
    </form>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="js/app.js"></script>
</body>
</html>
