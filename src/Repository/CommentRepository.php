<?php

namespace App\Repository;

use App\Resources\DatabaseConnection;

class CommentRepository {

    public function postComment($comment, $postId) {
        $query = "INSERT INTO comments (content, post_id) VALUES (?, ?)";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $stmt->execute([$comment, $postId]);
    }

    public function fetchCommentsForArticle($articleId) {
        $query = "SELECT * FROM comments WHERE post_id = ?";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $stmt->execute([$articleId]);
        return $stmt->fetchAll();
    }

    public function deleteComment($commentId) {
        $query = "DELETE FROM comments WHERE id = ?";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $stmt->execute([$commentId]);
    }
}
