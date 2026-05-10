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
