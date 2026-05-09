<?php

namespace App\Controllers;

error_reporting(E_ALL);
ini_set('display_errors', 1);

use App\Controllers\BaseController;
use App\Models\Regime;
use App\Models\Objectif;
use App\Models\SanteModel;

class RegimeController extends BaseController
{
    protected $regimeModel;
    protected $objectifModel;
    protected $santeModel;

    public function __construct()
    {
        $this->regimeModel = new Regime();
        $this->objectifModel = new Objectif();
        $this->santeModel = new SanteModel();
    }

    public function go_to_suggest()
    {
        $data['liste_objectif'] = $this->objectifModel->findAll();
        $data['liste_regime'] = $this->regimeModel->findAll();
        return view('regime/SuggestRegime', $data);
    }

    public function suggest()
    {
        // recuperation des data
        $objectif_id = $this->request->getGet("objectif_id");
        $durrer = $this->request->getGet("durrer");
        $preference = $this->request->getGet("preference");
        $user = session()->get("utilisateur");


        //recuperer l objectif de poid
        $variationVoulu = $this->request->getGet("variationVoulu");

        //verfier quelle est l objecif selectionner
        $objectif = $this->objectifModel->find($objectif_id);

        if ($objectif['nom'] === 'IMC ideal') {

            $dataImcIdeal = $this->santeModel->getInfoForImcIdeal($user['id']);
            $variationVoulu = $dataImcIdeal['variation_poid'];

            if ($variationVoulu < 0) {
                $data['liste_regime']  = $this->regimeModel->getSuggestionDiminuateurPoid($durrer, $preference, $variationVoulu);
            }
            if ($variationVoulu > 0) {
                $data['liste_regime']  = $this->regimeModel->getSuggestionHaugmenterPoid($durrer, $preference, $variationVoulu);
            }
            $data['data_imc_ideal'] = $dataImcIdeal;
        }

        if ($objectif['nom'] === 'augmentation') {
            $data['liste_regime'] = $this->regimeModel->getSuggestionHaugmenterPoid($durrer, $preference, $variationVoulu);
        }

        if ($objectif['nom'] === 'reduction') {
            $data['liste_regime'] = $this->regimeModel->getSuggestionDiminuateurPoid($durrer, $preference, (-1) * $variationVoulu);
        }

        $data['liste_objectif'] = $this->objectifModel->findAll();
        return view('regime/SuggestRegime', $data);
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
