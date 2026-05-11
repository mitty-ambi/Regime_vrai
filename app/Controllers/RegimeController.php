<?php

namespace App\Controllers;

error_reporting(E_ALL);
ini_set('display_errors', 1);

use App\Controllers\BaseController;
use App\Models\Regime;
use App\Models\Objectif;
use App\Models\RegimeSuggestionPdf;
use App\Models\SanteModel;
use App\Models\UtilisateurObjectifModel;

class RegimeController extends BaseController
{
    protected $regimeModel;
    protected $objectifModel;
    protected $santeModel;
    protected $utilisateurObjectif;

    public function __construct()
    {
        $this->regimeModel = new Regime();
        $this->objectifModel = new Objectif();
        $this->utilisateurObjectif = new UtilisateurObjectifModel();
        $this->santeModel = new SanteModel();
    }

    public function suggestPdf()
    {
        $data = $this->getDataSuggest();

        $user = $data['user'];
        $objectif = $data['objectif'];
        $variation = $data['variation_poid'];
        $liste = $data['liste_regime'];
        $date = date('d/m/Y');

        $pdf = new RegimeSuggestionPdf();
        $pdf->AddPage();

        // ── Titre ──
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, utf8_decode('Plan nutritionnel'), 0, 1, 'C');
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColor(120, 120, 120);
        $pdf->Cell(0, 6, 'Date : ' . $date, 0, 1, 'C');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Ln(4);

        // ── Infos client ──
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 8, utf8_decode('Informations'), 0, 1);
        $pdf->SetFont('Arial', '', 10);

        $infos = [
            ['Nom', utf8_decode($user['nom'] ?? '-')],
            ['Objectif', utf8_decode($objectif['objectif_nom'])],
            ['Poids initial', number_format($objectif['poids_initial'], 1) . ' kg'],
            ['Poids actuel', number_format($user['poids'], 1) . ' kg'],
            ['Poids cible', number_format($objectif['poids_cible'], 1) . ' kg'],
            ['Variation visée', ($variation > 0 ? '+' : '') . number_format($variation, 1) . ' kg'],
        ];

        foreach ($infos as [$label, $val]) {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(55, 7, utf8_decode($label) . ' :', 0, 0);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(0, 7, $val, 0, 1);
        }

        // ── IMC si disponible ──
        if (isset($data['data_imc_ideal'])) {
            $imc = $data['data_imc_ideal'];
            $pdf->Ln(3);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(0, 8, 'IMC', 0, 1);
            $pdf->SetFont('Arial', '', 10);

            $imcInfos = [
                ['IMC actuel', number_format($imc['imc'], 1)],
                ['IMC ideal', number_format($imc['imc_ideal'], 1)],
                ['Poids pour IMC ideal', number_format($imc['poids_ideal'], 1) . ' kg'],
            ];

            foreach ($imcInfos as [$label, $val]) {
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(55, 7, utf8_decode($label) . ' :', 0, 0);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(0, 7, $val, 0, 1);
            }
        }

        $pdf->Ln(4);

        // ── Tableau des régimes ──
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 8, utf8_decode('Régimes suggérés'), 0, 1);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->Cell(50, 8, 'Nom', 1, 0, 'C', true);
        $pdf->Cell(22, 8, utf8_decode('Durée'), 1, 0, 'C', true);
        $pdf->Cell(30, 8, 'Variation', 1, 0, 'C', true);
        $pdf->Cell(25, 8, '% Viande', 1, 0, 'C', true);
        $pdf->Cell(25, 8, '% Poisson', 1, 0, 'C', true);
        $pdf->Cell(25, 8, '% Volaille', 1, 0, 'C', true);
        $pdf->Cell(13, 8, 'Prix', 1, 1, 'C', true);

        $pdf->SetFont('Arial', '', 9);
        foreach ($liste as $r) {
            $vPoids = (float) $r['variation_poids'];
            $sign = $vPoids >= 0 ? '+' : '';

            $pdf->Cell(50, 7, utf8_decode($r['nom']), 1, 0);
            $pdf->Cell(22, 7, (int) $r['duree'] . ' j', 1, 0, 'C');
            $pdf->Cell(30, 7, $sign . number_format($vPoids, 1) . ' kg', 1, 0, 'C');
            $pdf->Cell(25, 7, (int) $r['pourcentage_viande'] . ' %', 1, 0, 'C');
            $pdf->Cell(25, 7, (int) $r['pourcentage_poisson'] . ' %', 1, 0, 'C');
            $pdf->Cell(25, 7, (int) $r['pourcentage_volaille'] . ' %', 1, 0, 'C');
            $pdf->Cell(13, 7, number_format($r['prix'], 0) . ' Ar', 1, 1, 'C');
        }

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="regime_' . date('Ymd') . '.pdf"')
            ->setBody($pdf->Output('S'));
    }

    public function go_to_suggest()
    {
        $data['liste_objectif'] = $this->objectifModel->findAll();
        $data['liste_regime'] = $this->regimeModel->findAll();
        return view('regime/SuggestRegime', $data);
    }

    public function suggest()
    {
        $data = $this->getDataSuggest();
        if (!isset($data)) {
            return redirect()->to('/objectif/choix');
        }
        return view('regime/SuggestRegime', $data);
    }

    private function getDataSuggest()
    {
        // initialiser $data
        $data = [];

        // recuperation des data
        $preference = $this->request->getGet("preference");
        $user = session()->get("utilisateur");

        //verfier quelle est l objecif selectionner
        $objectif = $this->utilisateurObjectif->getUserObjectifsCourante($user['id']);
        if (!isset($objectif)) {
            return null;
        }
        $codeObjectif = $objectif['code_objectif'];
        $duree = $objectif['duree'];
        //calculer la variation voulu 
        $variationVoulu = $objectif['poids_cible'] - $user['poids'];

        if ($codeObjectif === 'IMC-IDEAL') {

            $dataImcIdeal = $this->santeModel->getInfoForImcIdeal($user['id']);
            $variationVoulu = $dataImcIdeal['variation_poid'];
            $objectif['poids_cible'] = $dataImcIdeal['poids_ideal'];

            if ($variationVoulu < 0) {
                $data['liste_regime'] = $this->regimeModel->getSuggestionDiminuateurPoid($duree, $preference, $variationVoulu);
            }
            if ($variationVoulu > 0) {
                $data['liste_regime'] = $this->regimeModel->getSuggestionHaugmenterPoid($duree, $preference, $variationVoulu);
            }
            $data['data_imc_ideal'] = $dataImcIdeal;
        }

        if ($codeObjectif === 'AUG') {
            $data['liste_regime'] = $this->regimeModel->getSuggestionHaugmenterPoid($duree, $preference, $variationVoulu);
        }

        if ($codeObjectif === 'RED') {
            $data['liste_regime'] = $this->regimeModel->getSuggestionDiminuateurPoid($duree, $preference, $variationVoulu);
        }
        $data['user'] = $user;
        $data['objectif'] = $objectif;
        $data['variation_poid'] = $variationVoulu;
        $data['liste_objectif'] = $this->objectifModel->findAll();
        return $data;
    }

    public function go_to_regime()
    {
        $data['liste_regime'] = $this->regimeModel->findAll();
        $data['liste_objectif'] = $this->objectifModel->findAll();
        return view('/regime/CrudRegime', $data);
    }

    public function insert()
    {
        $nom = $this->request->getPost("nom");
        $type = $this->request->getPost("type");
        $prix = $this->request->getPost("prix");
        $duree = $this->request->getPost("duree");
        $variation = $this->request->getPost("variation");
        $viande = $this->request->getPost("viande");
        $poisson = $this->request->getPost("poisson");
        $volaille = $this->request->getPost("volaille");

        $this->regimeModel->insert([
            'nom' => $nom,
            'type' => $type,
            'prix' => $prix,
            'duree' => $duree,
            'variation_poids' => $variation,
            'pourcentage_viande' => $viande,
            'pourcentage_poisson' => $poisson,
            'pourcentage_volaille' => $volaille,
        ]);
        session()->setFlashdata('success', 'Insertion reussie');
        return redirect()->to('/Regime/go_to_regime');
    }

    // FONCTION POUR AFFICHER LE FORMULAIRE DE MODIFICATION
    public function update($id)
    {
        $data['regime'] = $this->regimeModel->find($id);
        $data['liste_objectif'] = $this->objectifModel->findAll();
        return view('/regime/EditRegime', $data);
    }

    public function edit($id)
    {
        $nom = $this->request->getPost("nom");
        $type = $this->request->getPost("type");
        $prix = $this->request->getPost("prix");
        $duree = $this->request->getPost("duree");
        $variation = $this->request->getPost("variation");
        $viande = $this->request->getPost("viande");
        $poisson = $this->request->getPost("poisson");
        $volaille = $this->request->getPost("volaille");

        $this->regimeModel->update($id, [
            'nom' => $nom,
            'type' => $type,
            'prix' => $prix,
            'duree' => $duree,
            'variation_poids' => $variation,
            'pourcentage_viande' => $viande,
            'pourcentage_poisson' => $poisson,
            'pourcentage_volaille' => $volaille,
        ]);
        session()->setFlashdata('success', 'Modification reussie');
        return redirect()->to('/Regime/go_to_regime');
    }

    public function supprimer($id)
    {
        $this->regimeModel->delete($id);
        session()->setFlashdata('success', 'Suppression reussie');
        return redirect()->to('/Regime/go_to_regime');
    }
}
