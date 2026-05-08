<?php

namespace App\Controllers;

use App\Models\SanteModel;

class Dashboard extends BaseController
{
    protected $santeModel;

    public function __construct()
    {
        $this->santeModel = new SanteModel();
    }

    public function index()
    {
        if (!session()->has('utilisateur')) {
            return redirect()->to('/auth/login')->with('error', 'Veuillez vous connecter d\'abord');
        }

        $utilisateur = session()->get('utilisateur');
        
        // Récupérer les données de santé
        $sante = $this->santeModel->getSanteByUtilisateurId($utilisateur['id']);
        
        // Fusionner les données
        if ($sante) {
            $data['utilisateur'] = array_merge($utilisateur, $sante);
        } else {
            $data['utilisateur'] = $utilisateur;
        }
        
        return view('dashboard/index', $data);
    }
}
