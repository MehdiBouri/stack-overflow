<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Model\AnswerModel;
use DateTime;

class AnswerController extends AbstractController
{

    #Créer un commentaire
    public function create()
    {
        // je récupère mes info 
        // soumis en javascript
        if (isset($_SESSION['id']))
        {
            $answerContent = $_POST['answerContent'];
            $questionId = $_POST['questionId'];
            $userId = $_SESSION['id'];

            // Je crée une réponse
            $answerModel = new AnswerModel();
            $newContent = $answerModel->create($answerContent, $userId, $questionId);

            // je renvoie l'id de la liste en json
            $this->sendJson([
                'content' => $newContent
            ]);
        }
    }

}