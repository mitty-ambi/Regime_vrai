<?php

namespace App\Models;

use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table = 'utilisateurs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'email', 'mot_de_passe', 'genre', 'solde', 'is_gold'];
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $createdField = 'date_creation';
    protected $updatedField = '';
    protected $deletedField = '';

    protected $validationRules = [
        'nom' => 'required|min_length[2]|max_length[100]',
        'email' => 'required|valid_email|is_unique[utilisateurs.email]',
        'mot_de_passe' => 'required|min_length[6]',
        'genre' => 'required|in_list[Homme,Femme]'
    ];

    protected $validationMessages = [
        'nom' => [
            'required' => 'Le nom est obligatoire',
            'min_length' => 'Le nom doit contenir au moins 2 caractères',
            'max_length' => 'Le nom ne peut pas dépasser 100 caractères'
        ],
        'email' => [
            'required' => 'L\'email est obligatoire',
            'valid_email' => 'L\'email n\'est pas valide',
            'is_unique' => 'Cet email est déjà utilisé'
        ],
        'mot_de_passe' => [
            'required' => 'Le mot de passe est obligatoire',
            'min_length' => 'Le mot de passe doit contenir au moins 6 caractères'
        ],
        'genre' => [
            'required' => 'Le genre est obligatoire',
            'in_list' => 'Le genre doit être Homme ou Femme'
        ]
    ];

    public function getSolde($idUtilisateur) {
        $solde = $this->select('solde')->find($idUtilisateur);
        return $solde ? $solde['solde'] : 0;
    }

    public function getUtilisateurByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function createUtilisateur($data)
    {
        $data['mot_de_passe'] = password_hash($data['mot_de_passe'], PASSWORD_DEFAULT);
        return $this->insert($data);
    }

    public function verifyPassword($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword);
    }
}
