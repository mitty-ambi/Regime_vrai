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
        return view('auth/inscription_simple');
    }

    public function login()
    {
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

        // Debug : afficher les données reçues
        log_message('debug', 'Données inscription: ' . json_encode($inscriptionData));

        $utilisateurId = $this->authModel->registerUser($inscriptionData);

        // Debug : afficher le résultat
        log_message('debug', 'Résultat inscription: ' . json_encode($utilisateurId));

        if ($utilisateurId) {
            session()->set('temp_user_id', $utilisateurId);
            return redirect()->to('/sante/info')->with('success', 'Inscription réussie ! Veuillez compléter vos informations santé.');
        } else {
            $errors = $this->authModel->getErrors();
            return redirect()->back()->with('errors', $errors)->withInput();
        }
    }

    public function authenticate()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('mot_de_passe');

        $result = $this->authModel->login($email, $password);

        if ($result['success']) {
            session()->set('utilisateur', $result['utilisateur']);
            return redirect()->to('/dashboard')->with('success', $result['message']);
        } else {
            return redirect()->back()->with('error', $result['message'])->withInput();
        }
    }

    public function logout()
    {
        session()->remove('utilisateur');
        return redirect()->to('/auth/login')->with('success', 'Déconnexion réussie');
    }
}
