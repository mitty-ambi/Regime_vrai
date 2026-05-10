<?php

namespace App\Controllers;
error_reporting(E_ALL);
ini_set('display_errors', 1);


use App\Models\SanteModel;
use App\Models\Regime;
use App\Models\Activites;
use App\Models\Code;

class Dashboard extends BaseController
{
    protected $santeModel;
    protected $utilisateurModel;
    protected $regimeModel;
    protected $activiteModel;
    protected $codeModel;

    public function __construct()
    {
        $this->santeModel = new \App\Models\SanteModel();
        $this->utilisateurModel = new \App\Models\UtilisateurModel();
        $this->regimeModel = new Regime();
        $this->activiteModel = new Activites();
        $this->codeModel = new Code();
    }
    
    public function stats()
    {
        $data['total_utilisateurs'] = $this->regimeModel->getStatsUtilisateurs();
        $data['regimes_actifs'] = $this->regimeModel->getRegimesActifs();
        $data['revenues_mois'] = $this->regimeModel->getRevenuesParMois();
        $data['codes_utilises'] = $this->regimeModel->getCodesUtilises();
        
        $data['top_regimes'] = $this->regimeModel->getTopRegimes(5);
        $data['types_regimes'] = $this->regimeModel->getTypesRegimes();
        $data['inscriptions'] = $this->regimeModel->getInscriptionsRecentes(7);
        $data['regimes_stats'] = $this->regimeModel->getRegimesWithStats();
        
        return view("dashboard/admin_dashboard", $data);
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
