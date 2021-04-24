<div class="panel panel-default" id="comment-<?= $comment->id; ?>">
    <div class="panel-body">
        <p><?= htmlentities($comment->content); ?></p>
        <?php if($comment->depth <= 1): ?>
        <p class="text-right">
            <a href="<?= $app->urlFor('comments.delete', ['id' => $comment->id]); ?>" class="btn btn-danger">Supprimer</a>
            <button class="btn btn-default reply" data-id="<?= $comment->id; ?>">Répondre</button>
        </p>
        <?php endif; ?>
    </div>
</div>

<div style="margin-left: 50px;">
    <?php if(isset($comment->children)): ?>
        <?php foreach($comment->children as $comment): ?>
            <?php require('comment.php'); ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>