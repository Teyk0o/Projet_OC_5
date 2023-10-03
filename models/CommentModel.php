<?php

namespace Models;

class CommentModel {

    private $db;

    public function __construct() {
        // Vous devrez initialiser la connexion à la base de données ici.
        // $this->db = new DatabaseConnection();
    }

    public function postComment($comment, $postId) {
        $query = "INSERT INTO comments (content, post_id) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$comment, $postId]);
    }

    public function fetchCommentsForArticle($articleId) {
        $query = "SELECT * FROM comments WHERE post_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$articleId]);
        return $stmt->fetchAll();
    }

    public function deleteComment($commentId) {
        $query = "DELETE FROM comments WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$commentId]);
    }
}
