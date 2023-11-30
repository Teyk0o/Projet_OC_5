<?php

namespace App\Controllers;

use App\Repository\CommentRepository;
use Error;

class CommentController {

    private $commentRepository;

    public function __construct() {
        $this->commentRepository = new CommentRepository();
    }

    public function postComment() {
        if (isset($_POST['comment-message'], $_POST['post-id'])) {
            $comment = $this->secureInput($_POST['comment-message']);
            $postId = $this->secureInput($_POST['post-id']);

            $this->commentRepository->postComment($comment, $postId);
        } else {
            echo 'Une erreur est survenue, veuillez réessayer.';
        }
    }

    public function deleteComment($commentId) {
        $this->commentRepository->deleteComment($commentId);
        echo 'Commentaire supprimé avec succès.';
    }

    private function secureInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}