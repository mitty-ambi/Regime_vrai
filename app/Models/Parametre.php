<?php
namespace App\Models;
use CodeIgniter\Model;

class Parametre extends Model
{
    protected $table = "parametre";
    protected $primaryKey = 'id';
    protected $allowedFields = ['imc_ideal', 'prix_gold', 'reduction_gold'];
    protected $useTimestamps = false;

    /**
     * Récupérer les paramètres GOLD
     */
    public function getGoldParams()
    {
        return $this->first();
    }
}
?>