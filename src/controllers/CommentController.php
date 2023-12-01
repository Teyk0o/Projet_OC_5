<?php

namespace App\Controllers;

use App\Repository\CommentRepository;

class CommentController {

    private $commentRepository;

    public function __construct() {
        $this->commentRepository = new CommentRepository();
    }

    public function postComment($data) {
        if (isset($data['comment-message'], $data['post-id'])) {
            $comment = $this->secureInput($data['comment-message']);
            $postId = $this->secureInput($data['post-id']);
            $authorId = $this->secureInput($_SESSION['id']);

            $query = $this->commentRepository->postComment($comment, $postId, $authorId);

            if ($query) {
                echo json_encode(['success' => true, 'message' => 'Votre commentaire a bien été ajouté.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Une erreur est survenue, veuillez réessayer.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Veuillez remplir tous les champs.']);
        }
    }

    public function approveComment($data) {
        if (isset($data['option'])) {
            $commentId = $this->secureInput($data['option']);

            $query = $this->commentRepository->approveComment($commentId);

            if ($query) {
                echo json_encode(['success' => true, 'message' => 'Commentaire approuvé avec succès.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'approbation du commentaire.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Veuillez remplir tous les champs.']);
        }
    }

    public function disapproveComment($data) {
        if (isset($data['option'])) {
            $commentId = $this->secureInput($data['option']);

            $query = $this->commentRepository->disapproveComment($commentId);

            if ($query) {
                echo json_encode(['success' => true, 'message' => 'Commentaire désapprouvé avec succès.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors de la désapprobation du commentaire.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Veuillez remplir tous les champs.']);
        }
    }

    private function secureInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}