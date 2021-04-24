<?php

namespace App;

class Comments {

    private $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function find($id) {
        $req = $this->pdo->prepare('SELECT * FROM comments WHERE id = ?');
        $req->execute([$id]);
        $comment = $req->fetch();

        if ($comment === false) {
            throw new \Exception("Ce commentaire n'existe pas");
        }
        return $comment;
    }

    public function findAllById($post_id) {
        $req = $this->pdo->prepare('SELECT * FROM comments WHERE post_id = ?');
        $req->execute([$post_id]);
        $comments = $req->fetchAll();
        $comments_by_id = [];
        foreach ($comments as $comment) {
            $comments_by_id[$comment->id] = $comment;
        }
        return $comments_by_id;
    }

    public function findAllWithChildren($post_id, $unset_children = true) {
        $comments = $comments_by_id = $this->findAllById($post_id);
        foreach ($comments as $id => $comment) {
            if ($comment->parent_id != 0) {
                $comments_by_id[$comment->parent_id]->children[] = $comment;
                if ($unset_children) {
                    unset($comments[$id]);
                }
            }
        }
        return $comments;
    }

    public function delete($id) {
        $comment = $this->find($id);
        $this->pdo->prepare('DELETE FROM comments WHERE id = ?')->execute([$id]);
        $this->pdo->prepare('UPDATE comments SET parent_id = ?, depth = depth - 1 WHERE parent_id = ?')->execute([$comment->parent_id, $comment->id]);
    }

    public function deleteWithChildren($id) {
        $comment = $this->find($id);
        $comments = $this->findAllWithChildren($comment->post_id, false);
        $ids = $this->getChildrenIds($comments[$comment->id]);
        $ids[] = $comment->id;

        return $this->pdo->exec('DELETE FROM comments WHERE id IN (' . implode(',', $ids) . ')');
    }

    private function getChildrenIds($comment) {
        $ids = [];
        foreach ($comment->children as $child) {
            $ids[] = $child->id;
            if (isset($child->children)) {
                $ids = array_merge($ids, $this->getChildrenIds($child));
            }
        }
        return $ids;
    }


}