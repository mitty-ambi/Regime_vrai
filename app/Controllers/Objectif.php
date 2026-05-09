<?php

namespace App\Controllers;
error_reporting(E_ALL);
ini_set('display_errors', 1);


use App\Models\ObjectifModel;
use App\Models\UtilisateurObjectifModel;

class Objectif extends BaseController
{
    protected $objectifModel;
    protected $utilisateurObjectifModel;

    public function __construct()
    {
        $this->objectifModel = new ObjectifModel();
        $this->utilisateurObjectifModel = new UtilisateurObjectifModel();
    }

    // Page de choix des objectifs
    public function choix()
    {
        if (!session()->has('utilisateur')) {
            return redirect()->to('/auth/login')->with('error', 'Veuillez vous connecter d\'abord');
        }

        $utilisateur = session()->get('utilisateur');

        // Récupérer tous les objectifs disponibles
        $objectifs = $this->objectifModel->getAllObjectifs();

        // Récupérer les objectifs déjà choisis par l'utilisateur
        $userObjectifs = $this->utilisateurObjectifModel->getUserObjectifs($utilisateur['id']);

        $data = [
            'objectifs' => $objectifs,
            'userObjectifs' => $userObjectifs,
            'utilisateur' => $utilisateur
        ];

        return view('objectif/choix', $data);
    }

    // Sauvegarder les objectifs choisis
    public function sauvegarder()
    {
        if (!session()->has('utilisateur')) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Utilisateur non connecté'
            ]);
        }

        $utilisateur = session()->get('utilisateur');
        $jsonData = $this->request->getJSON();
        $objectifsChoisis = $jsonData->objectifs ?? null;

        if (!$objectifsChoisis || !is_array($objectifsChoisis)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Veuillez choisir au moins un objectif'
            ]);
        }

        try {
            // Supprimer les anciens objectifs actifs
            $this->utilisateurObjectifModel->where('utilisateur_id', $utilisateur['id'])
                ->where('statut', 'actif')
                ->delete();

            // Ajouter les nouveaux objectifs
            foreach ($objectifsChoisis as $objectifData) {
                $objectifId = $objectifData->id;
                $poidsObjectif = $objectifData->poids ?? null;

                // Calculer le poids cible si un poids est spécifié
                $poidsCible = null;
                if ($poidsObjectif && isset($utilisateur['poids'])) {
                    $poidsCible = $utilisateur['poids'];

                    // Récupérer le nom de l'objectif pour déterminer l'opération
                    $objectif = $this->objectifModel->find($objectifId);
                    if ($objectif) {
                        if (strpos($objectif['nom'], 'Augmenter') !== false) {
                            $poidsCible += $poidsObjectif;
                        } elseif (strpos($objectif['nom'], 'Réduire') !== false) {
                            $poidsCible -= $poidsObjectif;
                        }
                    }
                }

                $this->utilisateurObjectifModel->addObjectifToUser(
                    $utilisateur['id'],
                    $objectifId,
                    $utilisateur['poids'] ?? null,
                    $poidsCible
                );
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Objectifs enregistrés avec succès'
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de l\'enregistrement des objectifs'
            ]);
        }
    }

    // Page de suivi des objectifs
    public function suivi()
    {
        if (!session()->has('utilisateur')) {
            return redirect()->to('/auth/login')->with('error', 'Veuillez vous connecter d\'abord');
        }

        $utilisateur = session()->get('utilisateur');
        $userObjectifs = $this->utilisateurObjectifModel->getUserObjectifs($utilisateur['id']);

        $data = [
            'userObjectifs' => $userObjectifs,
            'utilisateur' => $utilisateur
        ];

        return view('objectif/suivi', $data);
    }
}
