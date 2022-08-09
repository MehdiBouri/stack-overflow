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
        if (isset($_GET['title'])) {
            $title = $_GET['title'];
        }
        else {
            $title = '';
        }

        if (isset($_GET['order'])) {
            $order = $_GET['order'];
        }
        else {
            $order = 'DESC';
        }
        
        $questionModel = new QuestionModel();
        $userModel = new UserModel();
        $questions = $questionModel->findAll($title, $order);
        $users = $userModel->findAll();

        $this->render('questions/allQuestions.php', [
            'questions' => $questions,
            'users' => $users,
            'order' => $order,
            'title' => $title
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
        ]);
    }


    #Clôturer une question
    public function close()
    {
        if (isset($_GET['id'])) {
            $questionModel = new QuestionModel();
            $questionModel->close($_GET['id']);

            // Redirection sur la page d'accueil'
            header('location:?page=admin');
        }
    }

    #Réouvrir une question
    public function publish()
    {
        if (isset($_GET['id'])) {
            $questionModel = new QuestionModel();
            $questionModel->publish($_GET['id']);

            // Redirection sur la page d'accueil'
            header('location:?page=admin');
        }
    }

    #Modérer une question
    public function moderate()
    {
        if (isset($_GET['id'])) {
            $questionModel = new QuestionModel();
            $questionModel->moderate($_GET['id']);

            // Redirection sur la page d'accueil'
            header('location:?page=admin');
        }
    }
}