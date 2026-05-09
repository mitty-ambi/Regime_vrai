<?php

namespace App\Controllers;

use App\Models\AuthModel;

class Auth extends BaseController
{
    protected $authModel;

    public function __construct()
    {
        $this->authModel = new AuthModel();
    }

    public function inscription()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/inscription_simple');
    }

    public function login()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function register()
    {
        $inscriptionData = [
            'nom' => $this->request->getPost('nom'),
            'email' => $this->request->getPost('email'),
            'mot_de_passe' => $this->request->getPost('mot_de_passe'),
            'genre' => $this->request->getPost('genre')
        ];

        $utilisateurId = $this->authModel->registerUser($inscriptionData);

        if ($utilisateurId) {
            session()->set('temp_user_id', $utilisateurId);
            return redirect()->to('/sante/info')->with('success', 'Inscription réussie !');
        } else {
            $errors = $this->authModel->getErrors();
            return redirect()->back()
                ->with('errors', $errors ?: ['Erreur lors de l\'inscription'])
                ->withInput();
        }
    }

    public function authenticate()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('mot_de_passe');

        $result = $this->authModel->login($email, $password);

        if ($result['success']) {
            $utilisateur = $result['utilisateur'];

            session()->set([
                'utilisateur' => $utilisateur,
                'is_logged_in' => true,
                'user_id' => $utilisateur['id'],
                'user_nom' => $utilisateur['nom'],
                'user_email' => $utilisateur['email']
            ]);

            return redirect()->to('/dashboard')->with('success', 'Connexion réussie');
        } else {
            return redirect()->back()->with('error', $result['message'])->withInput();
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'Déconnexion réussie');
    }
}