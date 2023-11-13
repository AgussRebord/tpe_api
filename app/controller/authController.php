<?php
require_once './app/view/authView.php';
require_once './app/model/userModel.php';
require_once './app/helpers/authHelper.php';

class AuthController {
    private $view;
    private $model;

    function __construct() {
        $this->model = new userModel();
        $this->view = new authView();
    }

    public function showLogin() {
        $this->view->showLogin();
    }

    public function auth() {
        $userName = $_POST['userName'];
        $password = $_POST['password'];

        if (empty($userName) || empty($password)) {
            $this->view->showLogin('Faltan completar datos');
            return;
        }

        // busco el usuario
        $user = $this->model->getByuserName($userName);
        if ($user && password_verify($password, $user->password)) {
            // ACA LO AUTENTIQUE
            
            AuthHelper::login($user);
            
            header('Location: ' . BASE_URL . 'homeAdmin');
        } else {
            $this->view->showLogin('Usuario inválido');
        }
    }

    public function logout() {
        AuthHelper::logout();
        header('Location: ' . BASE_URL);    
    }
}
