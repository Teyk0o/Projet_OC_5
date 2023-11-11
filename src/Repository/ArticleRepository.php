<?php

namespace App\Repository;

use App\Entities\Article;
use App\Resources\DatabaseConnection;

class ArticleRepository {

    public function addArticle($title, $chapo, $content) {
        $query = "INSERT INTO posts (title, chapo, content) VALUES (?, ?, ?)";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $stmt->execute([$title, $chapo, $content]);
    }

    public function modifyArticle(Article $article) {
        $query = "UPDATE posts SET title = ?, chapo = ?, content = ? WHERE id = ?";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $stmt->execute([$article->getTitle(), $article->getChapo(), $article->getContent(), $article->getId()]);
    }

    public function fetchArticle($articleId): Article {
        $query = "SELECT * FROM posts WHERE id = ?";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $stmt->execute([$articleId]);
        $articleData = $stmt->fetch();
    
        if (!$articleData) {
            throw new \Exception("Article not found");
        }
    
        return new Article($articleData);
    }

    public function deleteArticle($articleId) {
        $query = "DELETE FROM posts WHERE id = ?";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $stmt->execute([$articleId]);
    }

    public function getAllArticles(): array {
        $output = [];
        $query = "SELECT * FROM posts";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $stmt->execute();
        $array = $stmt->fetchAll();
        foreach ($array as $article) {
            $output[] = new Article($article);
        }

        return $output;
    }
}