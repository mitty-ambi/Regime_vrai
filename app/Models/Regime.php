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
    
    //recuperer les regimes selons une durer determiner
    public function whereDurrerInferieur($durrer) {
        return $this->where("duree <= ", $durrer)->findAll();
    }

    //recuperer les reigime avec preference en 
    public function wherePreferenceVolaille() {
        return $this->wherePreference($this,"volaille")->orderBy('pourcentage_volaille',"DESC")->findAll();
    }

    //recuperer les reigime avec preference en viande
    public function wherePreferenceViande() {
        return $this->wherePreference($this,"viande")->orderBy('pourcentage_viande',"DESC")->findAll();
    }


    //recuperer les reigime avec preference en poisson
    public function wherePreferencePoisson() {
        return $this->wherePreference($this,"poisson")->orderBy('pourcentage_poisson',"DESC")->findAll();
    }

    //recuperer les regimes  avec une preference en viande , poisson , ou volaille
    public function wherePreference($query,$elementPreferer) {
        if($elementPreferer == "poisson") {
            $query->where("pourcentage_viande <= pourcentage_poisson")
            ->where("pourcentage_volaille <= pourcentage_poisson");
        } else if ($elementPreferer == "viande") {
            $query->where("pourcentage_poisson <= pourcentage_viande")
            ->where("pourcentage_volaille <= pourcentage_viande");
        } else if ($elementPreferer == "volaille") {
            $query->where("pourcentage_poisson <= pourcentage_volaille")
            ->where("pourcentage_viande <= pourcentage_volaille");
        }
        return $query;
    }

    //reucuper les regime pour haugmenter le poid jusqu a une certain seuil
    public function getRegimeDiminuateurPoidAvecSeuil($seuil) {
        return $this->where("variation_poids <",0)
        ->where("variation_poids >=",$seuil)
        ->findAll();
    }

    //reucuper les regime pour haugmenter le poid jusqu a une certain seuil
    public function getRegimeAugmentateurPoidAvecSeuil($seuil) {
        return $this->select("variation_poids >",0)
        ->where("variation_poids <=",$seuil)
        ->findAll();
    }

    //recuperer les regime pour dimuner le poid
    public function getRegimeDiminuateurPoid() {
        return $this->where("variation_poids <",0)
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