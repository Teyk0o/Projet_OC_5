<?php

namespace App\Entities;

class Comment {
    private $id;
    private $author_id;
    private $content;
    private $post_id;
    private $approved;

    public function __construct(array $data = []) {
        $this->hydrate($data);
    }

    public function hydrate(array $data) {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Getters
    public function getId() { return $this->id; }
    public function getAuthor_id() { return $this->author_id; }
    public function getContent() { return $this->content; }
    public function getPost_id() { return $this->post_id; }
    public function getApproved() { return $this->approved; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setAuthor_id($author_id) { $this->author_id = $author_id; }
    public function setContent($content) { $this->content = $content; }
    public function setPost_id($post_id) { $this->post_id = $post_id; }
    public function setApproved($approved) { $this->approved = $approved; }
}