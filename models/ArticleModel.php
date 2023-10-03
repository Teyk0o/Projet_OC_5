<?php

namespace Models;

use Resources\DatabaseConnection;

class ArticleModel {

    private $db;

    public function __construct() {
        $this->db = new DatabaseConnection();
    }

    public function addArticle($title, $chapo, $content) {
        $query = "INSERT INTO posts (title, chapo, content) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$title, $chapo, $content]);
    }

    public function modifyArticle($title, $chapo, $content, $articleId) {
        $query = "UPDATE posts SET title = ?, chapo = ?, content = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$title, $chapo, $content, $articleId]);
    }

    public function fetchArticle($articleId) {
        $query = "SELECT * FROM posts WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$articleId]);
        return $stmt->fetch();
    }

    public function deleteArticle($articleId) {
        $query = "DELETE FROM posts WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$articleId]);
    }

    public function getAllArticles() {
        $query = "SELECT * FROM posts";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}