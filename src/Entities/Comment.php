<?php

namespace App\Entities;

class Comment {
    private $id;
    private $author_id;
    private $content;
    private $post_id;
    private $approved;
    private $created_at;
    private $username;

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
    public function getAuthorId() { return $this->author_id; }
    public function getContent() { return $this->content; }
    public function getPostId() { return $this->post_id; }
    public function getApproved() { return $this->approved; }
    public function getCreatedAt() { return $this->created_at; }
    public function getUsername() { return $this->username; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setAuthorId($author_id) { $this->author_id = $author_id; }
    public function setContent($content) { $this->content = $content; }
    public function setPostId($post_id) { $this->post_id = $post_id; }
    public function setApproved($approved) { $this->approved = $approved; }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }
    public function setUsername($username) { $this->username = $username; }

}