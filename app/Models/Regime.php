<?php
namespace App\Models;
use CodeIgniter\Model;
use WeakReference;

class Regime extends Model
{
    protected $table = "regimes";
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'type', 'prix', 'duree', 'variation_poids', 'pourcentage_viande', 'pourcentage_poisson', 'pourcentage_volaille'];
    protected $useTimestamps = false;
    

    //recuperer les reigime avec preference en poisson
    public function getRegimePreferencePoisson() {
        return $this->wherePreference($this,"poisson")->findAll();
    }

    //recuperer les regimes  avec une preference en viande , poisson , ou volaille
    public function wherePreference($query,$elementPreferer) {
        if($elementPreferer == "poisson") {
            $query->where("pourcentage_viande <= pourcentage_poisson")
            ->where("pourcentage_volaille <= pourcentage_poisson");
        }
        return $query;
    }

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