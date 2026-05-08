<?php
namespace App\Models;
use CodeIgniter\Model;

class Code extends Model
{
    protected $table = "code";
    protected $primaryKey = 'id';
    protected $allowedFields = ['code', 'montant', 'est_utilise'];
    protected $useTimestamps = false;
}
?>