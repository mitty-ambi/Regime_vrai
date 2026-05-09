<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionCode extends Model
{
    protected $table = 'transactions_codes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['utilisateur_id', 'code_id', 'montant_credite', 'date_transaction'];
    protected $useTimestamps = false;
}
