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

    //suggestons des regimes augmentateur de poid
    public function getSuggestionHaugmenterPoid($durer, $preference, $seuilVariationPoidMax) {
        
    }
    //suggestion des regimes diminuateur de poid
    public function getSuggestionDiminuateurPoid($durer, $preference, $seuilVariationPoidMin)
    {
        return $this->whereDiminuateurPoid()
            ->whereDurrerInferieur($durer)
            ->preference($preference)
            ->whereSueiVariationPoidlMin($seuilVariationPoidMin)
            ->findAll();
    }


    //recuperer les regimes selons une durer determiner
    public function whereDurrerInferieur($durrer)
    {
        return $this->where("duree <= ", $durrer)->orderBy('duree', 'DESC');
    }

    //recuperer les reigime avec preference en 
    public function wherePreferenceVolaille()
    {
        return $this->wherePreference($this, "volaille")->orderBy('pourcentage_volaille', "DESC")->findAll();
    }

    //recuperer les reigime avec preference en viande
    public function wherePreferenceViande()
    {
        return $this->wherePreference($this, "viande")->orderBy('pourcentage_viande', "DESC")->findAll();
    }


    //recuperer les reigime avec preference en poisson
    public function preferencePoisson()
    {
        return $this->orderBy('pourcentage_poisson', "DESC")->findAll();
    }

    //recuperer les regimes  avec une preference en viande , poisson , ou volaille
    public function preference($elementPreferer)
    {
        if ($elementPreferer == "poisson") {
            $this->orderBy('pourcentage_poisson','DESC');
        } else if ($elementPreferer == "viande") {
            $this->orderBy('pourcentage_viande','DESC');
        } else if ($elementPreferer == "volaille") {
            $this->orderBy('pourcentage_volaille','DESC');
        }
        return $this;
    }

    //reucuper les regime pour haugmenter le poid jusqu a une certain seuil
    public function whereSueiVariationPoidlMin($seuil)
    {
        return  $this->where("variation_poids >=", $seuil);
    }

    public function whereSueiVariationPoidlMax($seuil)
    {
        return $this->where("variation_poids <=", $seuil);
    }

    //recuperer les regime pour dimuner le poid
    public function whereDiminuateurPoid()
    {
        return $this->where("variation_poids <", 0);
    }

    //recuperer les regime pour haugmenter le poid
    public function whereAugmenteurPoid()
    {
        return $this->where("variation_poids >", 0);
    }
}
