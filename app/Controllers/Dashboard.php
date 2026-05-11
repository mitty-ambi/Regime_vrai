<?php

namespace App\Controllers;
error_reporting(E_ALL);
ini_set('display_errors', 1);


use App\Models\SanteModel;
use App\Models\Regime;
use App\Models\Activites;
use App\Models\Code;
use App\Models\Parametre;

class Dashboard extends BaseController
{
    protected $santeModel;
    protected $utilisateurModel;
    protected $regimeModel;
    protected $activiteModel;
    protected $codeModel;
    protected $parametreModel;

    public function __construct()
    {
        $this->santeModel = new \App\Models\SanteModel();
        $this->utilisateurModel = new \App\Models\UtilisateurModel();
        $this->regimeModel = new Regime();
        $this->activiteModel = new Activites();
        $this->codeModel = new Code();
        $this->parametreModel = new Parametre();
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

    public function updatePoids()
    {
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

    /**
     * Activer le membership GOLD - débit 29.99€ et mise à jour is_gold
     */
    public function activateGold()
    {
        if (!session()->has('utilisateur')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Utilisateur non connecté'
            ]);
        }

        $utilisateur = session()->get('utilisateur');

        // Récupérer les paramètres GOLD depuis la DB
        $params = $this->parametreModel->getGoldParams();
        $goldPrix = $params['prix_gold'] ?? 29.99;

        try {
            // Vérifier si l'utilisateur est déjà gold
            if ($utilisateur['is_gold']) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Vous êtes déjà membre GOLD'
                ]);
            }

            // Vérifier le solde
            if ($utilisateur['solde'] < $goldPrix) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Solde insuffisant. Vous avez ' . number_format($utilisateur['solde'], 2) . '€ mais il vous en faut ' . number_format($goldPrix, 2) . '€'
                ]);
            }

            // Mettre à jour is_gold et solde
            $newSolde = $utilisateur['solde'] - $goldPrix;
            $this->utilisateurModel->update($utilisateur['id'], [
                'is_gold' => 1,
                'solde' => $newSolde
            ]);

            // Mettre à jour la session
            $sessionData = session()->get('utilisateur');
            $sessionData['is_gold'] = 1;
            $sessionData['solde'] = $newSolde;
            session()->set('utilisateur', $sessionData);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Félicitations! Vous êtes maintenant membre GOLD',
                'newSolde' => $newSolde,
                'is_gold' => 1
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de l\'activation: ' . $e->getMessage()
            ]);
        }
    }
}
