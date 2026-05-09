<?php

namespace App\Models;

use CodeIgniter\Model;

class ObjectifModel extends Model
{
    protected $table = 'objectifs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom'];
    protected $returnType = 'array';

    // Récupérer tous les objectifs disponibles
    public function getAllObjectifs()
    {
        return $this->findAll();
    }

    // Récupérer un objectif par son ID
    public function getObjectifById($id)
    {
        return $this->find($id);
    }
}

class UtilisateurObjectifModel extends Model
{
    protected $table = 'utilisateur_objectifs';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'utilisateur_id', 
        'objectif_id', 
        'statut', 
        'poids_initial', 
        'poids_cible'
    ];
    protected $returnType = 'array';

    // Ajouter un objectif pour un utilisateur
    public function addObjectifToUser($utilisateurId, $objectifId, $poidsInitial = null, $poidsCible = null)
    {
        // Vérifier si l'utilisateur n'a pas déjà cet objectif
        $existing = $this->where('utilisateur_id', $utilisateurId)
                         ->where('objectif_id', $objectifId)
                         ->where('statut', 'actif')
                         ->first();

        if ($existing) {
            return false; // L'objectif existe déjà
        }

        return $this->insert([
            'utilisateur_id' => $utilisateurId,
            'objectif_id' => $objectifId,
            'poids_initial' => $poidsInitial,
            'poids_cible' => $poidsCible,
            'statut' => 'actif'
        ]);
    }

    // Récupérer les objectifs d'un utilisateur
    public function getUserObjectifs($utilisateurId)
    {
        return $this->select('utilisateur_objectifs.*, objectifs.nom as objectif_nom')
                    ->join('objectifs', 'objectifs.id = utilisateur_objectifs.objectif_id')
                    ->where('utilisateur_objectifs.utilisateur_id', $utilisateurId)
                    ->where('utilisateur_objectifs.statut', 'actif')
                    ->findAll();
    }

    // Supprimer un objectif pour un utilisateur
    public function removeUserObjectif($utilisateurId, $objectifId)
    {
        return $this->where('utilisateur_id', $utilisateurId)
                    ->where('objectif_id', $objectifId)
                    ->delete();
    }
}
