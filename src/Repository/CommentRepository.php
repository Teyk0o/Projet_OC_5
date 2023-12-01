<?php

namespace App\Repository;

use App\Entities\Comment;
use App\Resources\DatabaseConnection;
use Error;

class CommentRepository {

    public function postComment($comment, $postId, $authorId) {
        $query = "INSERT INTO comments (content, post_id, author_id) VALUES (?, ?, ?)";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $result = $stmt->execute([$comment, $postId, $authorId]);

        if (!$result) {
            throw new Error('Une erreur est survenue lors de l\'ajout du commentaire.');
        }

        return true;
    }

    public function fetchCommentsForArticle($articleId) {
        $query = "SELECT * FROM comments WHERE post_id = ? AND approved = 1";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $stmt->execute([$articleId]);
        $commentsData = $stmt->fetchAll();
    
        $comments = [];
        foreach ($commentsData as $data) {
            $comments[] = new Comment($data);
        }
    
        return $comments;
    }

    public function getUnappovedComments() {
        $query = "SELECT * FROM comments WHERE approved = 0";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $stmt->execute();
        $commentsData = $stmt->fetchAll();
    
        $comments = [];
        foreach ($commentsData as $data) {
            $comments[] = new Comment($data);
        }
    
        return $comments;
    }

    public function approveComment($commentId) {
        $query = "UPDATE comments SET approved = 1 WHERE id = ?";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $result = $stmt->execute([$commentId]);

        if (!$result) {
            throw new Error('Une erreur est survenue lors de l\'approbation du commentaire.');
        }

        return true;
    }

    public function disapproveComment($commentId) {
        $query = "UPDATE comments SET approved = 0 WHERE id = ?";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $result = $stmt->execute([$commentId]);

        if (!$result) {
            throw new Error('Une erreur est survenue lors de la désapprobation du commentaire.');
        }

        return true;
    }

}
