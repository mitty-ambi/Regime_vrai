<?php

namespace App\Controllers;

use App\Models\SanteModel;

class Dashboard extends BaseController
{
    protected $santeModel;
    protected $utilisateurModel;

    public function __construct()
    {
        $this->santeModel = new \App\Models\SanteModel();
        $this->utilisateurModel = new \App\Models\UtilisateurModel();
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
            $utilisateurComplet = array_merge($utilisateur, $sante);
            // Mettre à jour la session avec les données complètes
            session()->set('utilisateur', $utilisateurComplet);
            $data['utilisateur'] = $utilisateurComplet;
        } else {
            $data['utilisateur'] = $utilisateur;
        }

        return view('dashboard/index', $data);
    }

    /**
     * Mettre à jour le poids de l'utilisateur
     */
    public function updatePoids()
    {
        // Vérifier si l'utilisateur est connecté
        if (!session()->has('utilisateur')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Utilisateur non connecté'
            ]);
        }

        $utilisateur = session()->get('utilisateur');
        $nouveauPoids = $this->request->getPost('poids');

        // Validation
        if (!$nouveauPoids || !is_numeric($nouveauPoids)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Poids invalide'
            ]);
        }

        $poids = floatval($nouveauPoids);
        if ($poids < 30 || $poids > 300) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Le poids doit être entre 30 et 300 kg'
            ]);
        }

        // Vérifier que l'utilisateur a une taille
        if (!isset($utilisateur['taille']) || !$utilisateur['taille']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Taille non définie. Veuillez compléter votre profil.'
            ]);
        }

        try {
            // Mettre à jour le poids dans la table santé
            $this->santeModel->updatePoids($utilisateur['id'], $poids);

            // Mettre à jour la session avec le nouveau poids
            $sessionData = session()->get('utilisateur');
            $sessionData['poids'] = $poids;
            session()->set('utilisateur', $sessionData);

            // Calculer le nouvel IMC
            $nouvelIMC = round($poids / pow($utilisateur['taille'] / 100, 2), 1);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Poids mis à jour avec succès',
                'poids' => $poids,
                'imc' => $nouvelIMC,
                'objectifAtteint' => false
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ]);
        }
    }

    public function updatePhoto()
    {
        if (!session()->has('utilisateur')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Utilisateur non connecté'
            ]);
        }

        $utilisateur = session()->get('utilisateur');
        $photoData = $this->request->getJSON()->photo_profil;

        if (!$photoData) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Aucune photo fournie'
            ]);
        }

        try {
            // Mettre à jour la photo de profil dans la base de données
            $this->utilisateurModel->update($utilisateur['id'], ['photo_profil' => $photoData]);

            // Mettre à jour la session
            $sessionData = session()->get('utilisateur');
            $sessionData['photo_profil'] = $photoData;
            session()->set('utilisateur', $sessionData);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Photo de profil mise à jour avec succès'
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de la photo'
            ]);
        }
    }
}
