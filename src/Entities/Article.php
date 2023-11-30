<?php

namespace App\Entities;

class Article {
    private $id;
    private $title;
    private $chapo;
    private $content;
    private $author_id;
    private $slug;
    private $last_modified;

    public function __construct(array $data = []) {
        $this->hydrate($data);
    }

    public function hydrate(array $data) {
        foreach ($data as $key => $value) {
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Getters
    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getChapo() { return $this->chapo; }
    public function getContent() { return $this->content; }
    public function getAuthor_id() { return $this->author_id; }
    public function getSlug() { return $this->slug; }
    public function getLastModified() { return $this->last_modified; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setTitle($title) { $this->title = $title; }
    public function setChapo($chapo) { $this->chapo = $chapo; }
    public function setContent($content) { $this->content = $content; }
    public function setAuthor_id($author_id) { $this->author_id = $author_id; }
    public function setSlug($slug) { $this->slug = $slug; }
    public function setLastModified($last_modified) { $this->last_modified = $last_modified; }
}