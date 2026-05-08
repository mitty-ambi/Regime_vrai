<?php

namespace App\Controllers;

use App\Models\SanteModel;

class Sante extends BaseController
{
    protected $santeModel;

    public function __construct()
    {
        $this->santeModel = new SanteModel();
    }

    public function info()
    {
        if (!session()->has('temp_user_id') && !session()->has('utilisateur')) {
            return redirect()->to('/auth/login')->with('error', 'Veuillez vous connecter d\'abord');
        }
        return view('sante/info');
    }

    public function save()
    {
        $santeData = [
            'taille' => $this->request->getPost('taille'),
            'poids' => $this->request->getPost('poids')
        ];

        if (session()->has('temp_user_id')) {
            $santeData['utilisateur_id'] = session()->get('temp_user_id');

            if ($this->santeModel->insert($santeData)) {
                session()->remove('temp_user_id');
                return redirect()->to('/auth/login')->with('success', 'Informations santé enregistrées ! Vous pouvez maintenant vous connecter.');
            } else {
                return redirect()->back()->with('errors', $this->santeModel->errors())->withInput();
            }
        } elseif (session()->has('utilisateur')) {
            $utilisateur = session()->get('utilisateur');
            $santeData['utilisateur_id'] = $utilisateur['id'];

            $existing = $this->santeModel->getSanteByUtilisateurId($utilisateur['id']);

            if ($existing) {
                if ($this->santeModel->update($existing['id'], $santeData)) {
                    return redirect()->to('/dashboard')->with('success', 'Informations santé mises à jour !');
                }
            } else {
                if ($this->santeModel->insert($santeData)) {
                    return redirect()->to('/dashboard')->with('success', 'Informations santé enregistrées !');
                }
            }

            return redirect()->back()->with('errors', $this->santeModel->errors())->withInput();
        }

        return redirect()->to('/auth/login')->with('error', 'Session expirée');
    }
}