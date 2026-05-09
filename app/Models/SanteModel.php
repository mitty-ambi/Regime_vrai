<?php

namespace App\Models;

use CodeIgniter\Model;

class SanteModel extends Model
{
    protected $table = 'sante';
    protected $primaryKey = 'id';
    protected $allowedFields = ['utilisateur_id', 'taille', 'poids'];
    protected $returnType = 'array';
    protected $useTimestamps = false;

    protected $validationRules = [
        'taille' => 'required|numeric|greater_than[0]|less_than[300]',
        'poids' => 'required|numeric|greater_than[0]|less_than[500]'
    ];

    protected $validationMessages = [
        'taille' => [
            'required' => 'La taille est obligatoire',
            'numeric' => 'La taille doit être un nombre',
            'greater_than' => 'La taille doit être supérieure à 0',
            'less_than' => 'La taille doit être inférieure à 300 cm'
        ],
        'poids' => [
            'required' => 'Le poids est obligatoire',
            'numeric' => 'Le poids doit être un nombre',
            'greater_than' => 'Le poids doit être supérieur à 0',
            'less_than' => 'Le poids doit être inférieur à 500 kg'
        ]
    ];

    public function getSanteByUtilisateurId($utilisateurId)
    {
        return $this->where('utilisateur_id', $utilisateurId)->first();
    }

    public function createSanteInfo($data)
    {
        return $this->insert($data);
    }

    public function insertTaillePoids($taille, $poids)
    {
        return $this->insert([
            'taille' => $taille,
            'poids' => $poids
        ]);
    }

    public function updateSanteInfo($utilisateurId, $data)
    {
        return $this->where('utilisateur_id', $utilisateurId)->set($data)->update();
    }

    public function calculateIMC($taille, $poids)
    {
        $tailleEnMetres = $taille / 100;
        return round($poids / ($tailleEnMetres * $tailleEnMetres), 2);
    }

    public function getSanteWithIMC($utilisateurId)
    {
        $sante = $this->getSanteByUtilisateurId($utilisateurId);
        if ($sante) {
            $sante['imc'] = $this->calculateIMC($sante['taille'], $sante['poids']);
        }
        return $sante;
    }

    public function calculerPoid($imc,$taille) {
         $tailleEnMetres = $taille / 100;
        return round($imc*($tailleEnMetres*$tailleEnMetres),2);
    }

    //recuperer la variation de poid necessaire pour ateindre l IMC ideal
    public function getInfoForImcIdeal($utilisateurId) {
        $sante = $this->getSanteByUtilisateurId($utilisateurId);
        if ($sante) {
            $taille = $sante['taille'];
            $poids = $sante["poids"];
            $imcIdeal = $this->db->table("parametre")->get(1)->getResultArray()[0]["imc_ideal"];
            $poidIdeal = $this->calculerPoid($imcIdeal,$taille);
            $variationPoid = $poidIdeal - $poids;

            $sante['imc'] = $this->calculateIMC($sante['taille'], $sante['poids']);
            $sante['imc_ideal'] = $this->db->table("parametre")->get(1)->getResultArray()[0]["imc_ideal"];
            $sante['poids_ideal'] = $poidIdeal;
            $sante['variation_poid'] = $variationPoid;
        }
        return $sante;
    }
        
    /**
     * Mettre à jour le poids d'un utilisateur
     */
    public function updatePoids($utilisateurId, $poids)
    {
        // Vérifier si l'utilisateur a déjà des données santé
        $existing = $this->where('utilisateur_id', $utilisateurId)->first();
        
        if ($existing) {
            // Mettre à jour le poids existant
            return $this->where('utilisateur_id', $utilisateurId)
                        ->set('poids', $poids)
                        ->update();
        } else {
            // Créer une nouvelle entrée si aucune donnée n'existe
            return $this->insert([
                'utilisateur_id' => $utilisateurId,
                'poids' => $poids,
                'taille' => 170 // Valeur par défaut, devrait être mise à jour
            ]);
        }
    }
}
