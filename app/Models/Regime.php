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
        return $this->whereAugmenteurPoid()
            ->whereDurrerInferieur($durer)
            ->preference($preference)
            ->whereSueiVariationPoidlMax($seuilVariationPoidMax)
            ->findAll();
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
    private function whereDurrerInferieur($durrer)
    {
        return $this->where("duree <= ", $durrer)->orderBy('duree', 'DESC');
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
    private function whereSueiVariationPoidlMin($seuil)
    {
        return  $this->where("variation_poids >=", $seuil);
    }

    private function whereSueiVariationPoidlMax($seuil)
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
