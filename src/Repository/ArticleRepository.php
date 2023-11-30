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

    public function fetchArticleWithSlug($slug): Article {
        $query = "SELECT * FROM posts WHERE slug = ?";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $stmt->execute([$slug]);
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

    public function getMostCommentedArticles() {
        $output = [];
        $query = "SELECT posts.id, posts.title, posts.chapo, posts.content, posts.author_id, posts.slug, posts.last_modified, COUNT(comments.id) AS comment_count FROM posts LEFT JOIN comments ON posts.id = comments.post_id GROUP BY posts.id ORDER BY comment_count DESC LIMIT 5";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $stmt->execute();
        $array = $stmt->fetchAll();
        foreach ($array as $article) {
            $output[] = new Article($article);
        }

        return $output;
    }

    public function getFooterArticle() {
        $output = [];
        $query = "SELECT * FROM posts ORDER BY id DESC LIMIT 2";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $stmt->execute();
        $array = $stmt->fetchAll();
        foreach ($array as $article) {
            $output[] = new Article($article);
        }

        return $output;
    }

    public function getRandomArticles($number) {
        $output = [];
        $query = "SELECT * FROM posts ORDER BY RAND() LIMIT $number";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $stmt->execute();
        $array = $stmt->fetchAll();
        foreach ($array as $article) {
            $output[] = new Article($article);
        }

        return $output;
    }

    public function getLastArticles() {
        $output = [];
        $query = "SELECT * FROM posts ORDER BY id DESC LIMIT 5";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $stmt->execute();
        $array = $stmt->fetchAll();
        foreach ($array as $article) {
            $output[] = new Article($article);
        }

        return $output;
    }
}