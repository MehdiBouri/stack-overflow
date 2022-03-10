<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Model\UserModel;

class UserController extends AbstractController
{
    #Fonction pour se connecter
    public function login()
    {

        if(isset($_POST['email']))
        {
            #Récupération des données du formulaire
            $email = $_POST['email'];
            $password = $_POST['password'];

            #Instanciation de mon objet user
            $user = new UserModel();

            #Vérification de l'existence de l'utilisateur en BDD
            $result = $user->login($email, $password);

            $result = $result[0];

            #S'il y a un resultat, alors on stocke dans $_SESSION
            if($result){
                
                $_SESSION["id"] = $result->getId();
                
                #Redirection vers l'index
                header('location:?page=index');
            }
            else{
                echo "Votre mot de passe ou email est invalide.";
            }
        }
        
        $this->render('login/connection.php');
    }

    #Fonction pour se déconnecter
    public function logout()
    {   
        #On supprime la session
        session_destroy();

        #Redirection vers l'index
        header('location:?page=index');
    }

}