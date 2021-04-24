<?php
if (isset($_POST['content']) && !empty($_POST['content'])) {
    $parent_id = isset($_POST['parent_id']) ? $_POST['parent_id'] : 0;
    $depth = 0;

    if ($parent_id != 0) {
        $req = $app->pdo->prepare('SELECT id, depth FROM comments WHERE id = ?');
        $req->execute([$parent_id]);
        $comment = $req->fetch();
        if ($comment == false) {
            throw new Exception('Ce parent n\'existe pas');
        }
        $depth = $comment->depth + 1;
    }

    if ($depth >= 3) {
        $app->flash('danger', 'Vous ne pouvez pas répondre à une réponse d\'une réponse :(');
    } else {
        $req = $app->pdo->prepare('INSERT INTO comments SET content = ?, parent_id = ?, post_id = ?, depth = ?');
        $req->execute([
            $_POST['content'],
            $parent_id,
            $_POST['post_id'],
            $depth
        ]);
        $app->flash('success', 'Merci pour votre commentaire :)');
    }



} else {
    $app->flash('danger', 'Vous n\'avez rien posté :(');
}

$app->response->redirect($app->urlFor('home'));