<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $utilisateurModel;
    protected $santeModel;

    public function __construct()
    {
        parent::__construct();
        $this->utilisateurModel = new UtilisateurModel();
        $this->santeModel = new SanteModel();
    }

    public function registerUser($inscriptionData)
    {
        // Hasher le mot de passe avant insertion
        $inscriptionData['mot_de_passe'] = password_hash($inscriptionData['mot_de_passe'], PASSWORD_DEFAULT);
        
        $utilisateurId = $this->utilisateurModel->insert($inscriptionData);
        
        if ($utilisateurId) {
            return $utilisateurId;
        } else {
            $this->errors = $this->utilisateurModel->errors();
            return false;
        }
    }

    public function register($inscriptionData, $santeData)
    {
        $db = \Config\Database::connect();
        
        try {
            $db->transStart();
            
            // Hasher le mot de passe avant insertion
            $inscriptionData['mot_de_passe'] = password_hash($inscriptionData['mot_de_passe'], PASSWORD_DEFAULT);
            
            $utilisateurId = $this->utilisateurModel->insert($inscriptionData);
            
            if (!$utilisateurId) {
                $db->transRollback();
                return [
                    'success' => false,
                    'errors' => $this->utilisateurModel->errors()
                ];
            }
            
            // Ajouter l'ID utilisateur aux données santé
            $santeData['utilisateur_id'] = $utilisateurId;
            $santeInsert = $this->santeModel->insert($santeData);
            
            if (!$santeInsert) {
                $db->transRollback();
                return [
                    'success' => false,
                    'errors' => $this->santeModel->errors()
                ];
            }
            
            $db->transComplete();
            
            if ($db->transStatus() === false) {
                return [
                    'success' => false,
                    'message' => 'Erreur lors de l\'inscription'
                ];
            }
            
            return [
                'success' => true,
                'utilisateur_id' => $utilisateurId,
                'message' => 'Inscription réussie'
            ];
            
        } catch (\Exception $e) {
            $db->transRollback();
            return [
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ];
        }
    }

    public function getErrors()
    {
        return $this->errors ?? [];
    }

    public function login($email, $password)
    {
        $utilisateur = $this->utilisateurModel->getUtilisateurByEmail($email);
        
        if (!$utilisateur) {
            return [
                'success' => false,
                'message' => 'Email ou mot de passe incorrect'
            ];
        }
        
        if (!$this->utilisateurModel->verifyPassword($password, $utilisateur['mot_de_passe'])) {
            return [
                'success' => false,
                'message' => 'Email ou mot de passe incorrect'
            ];
        }
        
        unset($utilisateur['mot_de_passe']);
        
        return [
            'success' => true,
            'utilisateur' => $utilisateur,
            'message' => 'Connexion réussie'
        ];
    }

    public function getCompleteProfile($utilisateurId)
    {
        $utilisateur = $this->utilisateurModel->find($utilisateurId);
        $sante = $this->santeModel->getSanteWithIMC($utilisateurId);
        
        if ($utilisateur && $sante) {
            return array_merge($utilisateur, $sante);
        }
        
        return null;
    }
}
