<?php
namespace App\Models;
use CodeIgniter\Model;

class Regime extends Model
{
    protected $table = "regimes";
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'type', 'prix', 'duree', 'variation_poids', 'pourcentage_viande', 'pourcentage_poisson', 'pourcentage_volaille'];
    protected $useTimestamps = false;

    //recuperer les regime pour dimuner le poid
    public function getRegimeDiminuePoid() {
        return $this->select("*")
        ->where("variation_poids <",0)
        ->findAll();
    }

    //recuperer les regime pour haugmenter le poid
    public function getRegimeAugmenterPoid() {
        return $this->select("*")
        ->where("variation_poids >",0)
        ->findAll();
    }
}
?>