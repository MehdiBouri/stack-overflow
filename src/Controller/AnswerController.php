<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Model\AnswerModel;
use App\Model\QuestionModel;
use DateTime;

class AnswerController extends AbstractController
{

    // Ajouter une réponse
    public function create()
    {
        // Si l'utilisateur est connecté
        if (isset($_SESSION['id']))
        {
            // Récupération des données
            $answerContent = $_POST['answerContent'];
            $questionId = $_GET['questionId'];
            $userId = $_SESSION['id'];

            // Récupère la question
            $questionModel = new QuestionModel();
            $question = $questionModel->findById($questionId);

            // Vérifie que la question n'est pas clôturée
            if ($question->getStatus() == 'published') {
                // Ajout de la réponse
                $answerModel = new AnswerModel();
                $answerModel->create($answerContent, $userId, $questionId);
            }
        }

        // Redirection vers la nouvelle question
        header('location:?page=question&id='.$questionId);
    }

}