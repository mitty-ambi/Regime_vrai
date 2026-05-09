<?php
namespace App\Models;
use CodeIgniter\Model;

class Regime extends Model
{
    protected $table = "regimes";
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'type', 'prix', 'duree', 'variation_poids', 'pourcentage_viande', 'pourcentage_poisson', 'pourcentage_volaille'];
    protected $useTimestamps = false;
    
    //reucuper les regime pour haugmenter le poid jusqu a une certain seuil
    public function getRegimeDiminuateurPoidAvecSeuil($seuil) {
        return $this->select("*")
        ->where("variation_poids <",0)
        ->where("variation_poids >=",$seuil)
        ->findAll();
    }

    //reucuper les regime pour haugmenter le poid jusqu a une certain seuil
    public function getRegimeAugmentateurPoidAvecSeuil($seuil) {
        return $this->select("*")
        ->where("variation_poids >",0)
        ->where("variation_poids <=",$seuil)
        ->findAll();
    }

    //recuperer les regime pour dimuner le poid
    public function getRegimeDiminuateurPoid() {
        return $this->select("*")
        ->where("variation_poids <",0)
        ->findAll();
    }

    //recuperer les regime pour haugmenter le poid
    public function getRegimeAugmenteurPoid() {
        return $this->select("*")
        ->where("variation_poids >",0)
        ->findAll();
    }
}
?>