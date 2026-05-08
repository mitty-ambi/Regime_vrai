<?php
namespace App\Models;
use CodeIgniter\Model;

class Sante extends Model
{
    protected $table = "sante";
    protected $primaryKey = 'id';
    protected $allowedFields = ['utilisateur_id', 'taille', 'poids'];
    protected $useTimestamps = false;
}
?>