<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Model\QuestionModel;
use App\Model\AnswerModel;
use App\Model\UserModel;

class QuestionController extends AbstractController
{
    #Afficher toutes les questions
    public function index()
    {

        $questionModel = new QuestionModel();
        $userModel = new UserModel();
        
        $questions = $questionModel->findAll();
        $users = $userModel->findAll();

        $this->render('questions/allQuestions.php', [
            'questions' => $questions,
            'users' => $users
        ]);

    }

    #Afficher une question
    public function showQuestion()
    {
        $id = $_GET['id'];
        
        if (isset($_GET['p']))
        {
            $page = $_GET['p'];
        }
        else
        {
            $page = 1;
        }
        
        $questionModel = new QuestionModel();
        $answerModel = new AnswerModel();
        $userModel = new UserModel();
        
        $question = $questionModel->findById($id);
        $answers = $answerModel->findByQuestion($id, $page);
        $pageTotal = $answerModel->countPage($id);
        $users = $userModel->findAll();


        $this->render('questions/oneQuestion.php', [
            'question' => $question,
            'answers' => $answers,
            'users' => $users,
            'page' => $page,
            'pageTotal' => $pageTotal
        ]);

    }


    #Créer une question
    public function create()
    {
        if (isset($_POST['title']) && isset($_SESSION['id']))
        {
            $title = $_POST['title'];
            if (isset($_POST['content'])) {
                $content = $_POST['content'];
            }
            else {
                $content = '';
            }

            if (isset($_POST['technology'])) {
                $technology = $_POST['technology'];
            }
            else {
                $technology = '';
            }
            
            $userId = (int) $_SESSION['id'];

            // Si les champs titre et contenu ne sont pas vides
            if ($title && $content)
            {
                $questionModel = new QuestionModel();
                $questionId = $questionModel->create($title, $content, $technology, $userId);

                // Redirection sur la page de la nouvelle question
                header('location:?page=question&id='.$questionId);
            }
        }

        $this->render('questions/ask.php', [
            'title' => $title,
            'content' => $content
        ]);
    }

}