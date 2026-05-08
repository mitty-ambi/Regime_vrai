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
        return view('auth/inscription');
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

        $santeData = [
            'taille' => $this->request->getPost('taille'),
            'poids' => $this->request->getPost('poids')
        ];

        // Debug : afficher les données reçues
        log_message('debug', 'Données inscription: ' . json_encode($inscriptionData));
        log_message('debug', 'Données santé: ' . json_encode($santeData));

        $result = $this->authModel->register($inscriptionData, $santeData);

        // Debug : afficher le résultat
        log_message('debug', 'Résultat inscription: ' . json_encode($result));

        if ($result['success']) {
            return redirect()->to('/auth/login')->with('success', $result['message']);
        } else {
            $errors = $result['errors'] ?? [$result['message'] ?? 'Erreur lors de l\'inscription'];
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
