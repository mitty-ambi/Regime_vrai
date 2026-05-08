<?php
namespace App\Models;
use CodeIgniter\Model;

class Regime extends Model
{
    protected $table = "activites";
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'date_activite', 'calories_brulees'];
    protected $useTimestamps = false;
}
?>