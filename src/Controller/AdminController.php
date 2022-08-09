<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Model\QuestionModel;
use App\Model\AnswerModel;
use App\Model\UserModel;

class AdminController extends AbstractController
{
    #Tableau de bord d'administration
    public function index()
    {

        $questionModel = new QuestionModel();
        $userModel = new UserModel();
        $questions = $questionModel->findAll(null, null, true);
        $users = $userModel->findAll();

        $this->render('admin/index.php', [
            'questions' => $questions,
            'users' => $users,
        ]);
    }

    
}