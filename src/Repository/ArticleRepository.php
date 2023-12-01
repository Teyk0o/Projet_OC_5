<?php

namespace App\Repository;

use App\Entities\Article;
use App\Resources\DatabaseConnection;

class ArticleRepository {

    public function addArticle($title, $chapo, $content, $slug, $authorId) {
        $query = "INSERT INTO posts (title, chapo, content, slug, author_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $result = $stmt->execute([$title, $chapo, $content, $slug, $authorId]);

        if (!$result) {
            throw new \Exception("Error while creating article");
        }

        return true;
    }

    public function modifyArticle(Article $article) {
        $query = "UPDATE posts SET title = ?, chapo = ?, content = ? WHERE id = ?";
        $stmt = DatabaseConnection::getPDO()->prepare($query);
        $result = $stmt->execute([$article->getTitle(), $article->getChapo(), $article->getContent(), $article->getId()]);

        if (!$result) {
            throw new \Exception("Error while modifying article");
        }

        return true;
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
        $result = $stmt->execute([$articleId]);

        if (!$result) {
            throw new \Exception("Error while deleting article");
        }

        return true;
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

    public function generateSlug($title) {
        $slug = strtolower($title);
        $slug = str_replace(' ', '-', $slug);
        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', $slug);
        $slug = preg_replace('/-+/', '-', $slug);

        return $slug;
    }
}