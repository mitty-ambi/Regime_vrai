<?php

namespace App\Models;

use CodeIgniter\Model;

class Code extends Model
{
    protected $table = "codes";
    protected $primaryKey = 'id';
    protected $allowedFields = ['code', 'montant', 'est_utilise'];
    protected $useTimestamps = false;

    public function getCodeByCode($code)
    {
        return $this->where('code', $code)->first();
    }

    public function getCodesNonUtilises()
    {
        return $this->where('est_utilise', false)->findAll();
    }
}