<?php

namespace App\Models;

use CodeIgniter\Model;

class AchatRegime extends Model
{
    protected $table = "achats_regimes";
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'utilisateur_id',
        'regime_id',
        'prix_original',
        'prix_paye'
    ];
    protected $useTimestamps = false;
}
