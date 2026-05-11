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
    public function getSuggestionHaugmenterPoid($durer, $preference, $seuilVariationPoidMax)
    {
        return $this
            ->preference($preference)
            ->whereAugmenteurPoid()
            ->whereDurrerInferieur($durer)
            ->whereSueiVariationPoidlMax($seuilVariationPoidMax)
            ->withSportAssocier()
            ->findAll();
    }

    //suggestion du sport associer au regime
    public function withSportAssocier()
    {
        return $this->select('regimes.*,activites.nom as nom_activite,activites.calories_brulees')
            ->join('regime_activite', 'regime_activite.id_regime=regimes.id', 'left')
            ->join('activites', 'regime_activite.id=activites.id', 'left');
    }

    //suggestion des regimes diminuateur de poid
    public function getSuggestionDiminuateurPoid($durer, $preference, $seuilVariationPoidMin)
    {
        return $this->preference($preference)
            ->whereDiminuateurPoid()
            ->whereDurrerInferieur($durer)
            ->whereSueiVariationPoidlMin($seuilVariationPoidMin)
            ->withSportAssocier()
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
            $this->orderBy('pourcentage_poisson', 'DESC');
        } else if ($elementPreferer == "viande") {
            $this->orderBy('pourcentage_viande', 'DESC');
        } else if ($elementPreferer == "volaille") {
            $this->orderBy('pourcentage_volaille', 'DESC');
        }
        return $this;
    }

    //reucuper les regime pour haugmenter le poid jusqu a une certain seuil
    private function whereSueiVariationPoidlMin($seuil)
    {
        return $this->where("variation_poids >=", $seuil);
    }

    private function whereSueiVariationPoidlMax($seuil)
    {
        return $this->where("variation_poids <=", $seuil);
    }

    //recuperer les regime pour dimuner le poid
    public function whereDiminuateurPoid()
    {
        return $this->where("variation_poids <", 0)->orderBy('variation_poids', 'ASC');
    }

    //recuperer les regime pour haugmenter le poid
    public function whereAugmenteurPoid()
    {
        return $this->where("variation_poids >", 0)->orderBy('variation_poids', 'DESC');
    }

    // ======= STATISTIQUES POUR LE DASHBOARD =======

    public function getStatsUtilisateurs()
    {
        $db = \Config\Database::connect();
        $result = $db->table('utilisateurs')->selectCount('id', 'total')->get()->getRow();
        return $result->total ?? 0;
    }

    public function getRegimesActifs()
    {
        $db = \Config\Database::connect();
        $result = $db->table('achats_regimes')->selectCount('id', 'total')->get()->getRow();
        return $result->total ?? 0;
    }

    public function getRevenusTotal()
    {
        $db = \Config\Database::connect();
        $result = $db->table('achats_regimes')->selectSum('prix_paye', 'total')->get()->getRow();
        return $result->total ?? 0;
    }

    public function getCodesUtilises()
    {
        $db = \Config\Database::connect();
        $result = $db->table('codes')->where('est_utilise', true)->selectCount('id', 'total')->get()->getRow();
        return $result->total ?? 0;
    }

    public function getTopRegimes($limit = 5)
    {
        $db = \Config\Database::connect();
        $result = $db->table('achats_regimes')
            ->select('regimes.id, regimes.nom, COUNT(achats_regimes.id) as actifs')
            ->join('regimes', 'achats_regimes.regime_id = regimes.id')
            ->groupBy('regimes.id')
            ->orderBy('actifs', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
        return $result ?? [];
    }

    public function getTypesRegimes()
    {
        $db = \Config\Database::connect();
        $result = $db->table('achats_regimes')
            ->select('regimes.type, COUNT(achats_regimes.id) as actifs')
            ->join('regimes', 'achats_regimes.regime_id = regimes.id')
            ->groupBy('regimes.type')
            ->orderBy('actifs', 'DESC')
            ->get()
            ->getResultArray();
        return $result ?? [];
    }

    public function getInscriptionsRecentes($days = 7)
    {
        $db = \Config\Database::connect();
        $result = $db->table('utilisateurs')
            ->select('DATE(date_creation) as date, COUNT(id) as count')
            ->where("date_creation >= DATE_SUB(NOW(), INTERVAL {$days} DAY)")
            ->groupBy('DATE(date_creation)')
            ->orderBy('date', 'ASC')
            ->get()
            ->getResultArray();
        return $result ?? [];
    }

    public function getRevenuesParMois()
    {
        $db = \Config\Database::connect();
        $result = $db->table('achats_regimes')
            ->select('DATE_FORMAT(date_achat, "%Y-%m") as mois, SUM(prix_paye) as total')
            ->where("date_achat >= DATE_SUB(NOW(), INTERVAL 12 MONTH)")
            ->groupBy('DATE_FORMAT(date_achat, "%Y-%m")')
            ->orderBy('mois', 'DESC')
            ->limit(1)
            ->get()
            ->getRow();
        return $result->total ?? 0;
    }

    public function getTotalRegimes()
    {
        return $this->selectCount('id', 'total')->get()->getRow()->total ?? 0;
    }

    public function getRegimesWithStats()
    {
        $db = \Config\Database::connect();
        $result = $db->table('regimes')
            ->select('regimes.*, COUNT(achats_regimes.id) as actifs')
            ->join('achats_regimes', 'regimes.id = achats_regimes.regime_id', 'LEFT')
            ->groupBy('regimes.id')
            ->orderBy('actifs', 'DESC')
            ->get()
            ->getResultArray();
        return $result ?? [];
    }
}
