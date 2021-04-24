<?php
$comments = new \App\Comments($app->pdo);
$comments->deleteWithChildren($id);
$app->flash('success', 'Le commntaire a bien été supprimé');
$app->response->redirect($app->urlFor('home'));