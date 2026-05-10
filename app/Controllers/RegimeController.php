<?php

namespace App\Controllers;

error_reporting(E_ALL);
ini_set('display_errors', 1);

use App\Controllers\BaseController;
use App\Models\Regime;
use App\Models\Objectif;
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

    public function go_to_suggest()
    {
        $data['liste_objectif'] = $this->objectifModel->findAll();
        $data['liste_regime'] = $this->regimeModel->findAll();
        return view('regime/SuggestRegime', $data);
    }

    public function suggest()
    {
        // recuperation des data
        $preference = $this->request->getGet("preference");
        $user = session()->get("utilisateur");

        //verfier quelle est l objecif selectionner
        $objectif = $this->utilisateurObjectif->getUserObjectifsCourante($user['id']);
        if(!isset($objectif)) {
            return redirect()->to('/objectif/choix');
        }
        $codeObjectif = $objectif['code_objectif'];
        $durrer = $objectif['durrer'];
        //calculer la variation voulu 
        $variationVoulu = $objectif['poids_cible'] - $user['poids'] ;

        if ($codeObjectif === 'IMC-IDEAL') {

            $dataImcIdeal = $this->santeModel->getInfoForImcIdeal($user['id']);
            $variationVoulu = $dataImcIdeal['variation_poid'];
            $objectif['poids_cible'] = $dataImcIdeal['poids_ideal'];
            
            if ($variationVoulu < 0) {
                $data['liste_regime']  = $this->regimeModel->getSuggestionDiminuateurPoid($durrer, $preference, $variationVoulu);
            }
            if ($variationVoulu > 0) {
                $data['liste_regime']  = $this->regimeModel->getSuggestionHaugmenterPoid($durrer, $preference, $variationVoulu);
            }
            $data['data_imc_ideal'] = $dataImcIdeal;
        }

        if ($codeObjectif === 'AUG') {
            $data['liste_regime'] = $this->regimeModel->getSuggestionHaugmenterPoid($durrer, $preference, $variationVoulu);
        }

        if ($codeObjectif === 'RED') {
            $data['liste_regime'] = $this->regimeModel->getSuggestionDiminuateurPoid($durrer, $preference,$variationVoulu);
        }
        $data['user'] = $user;
        $data['objectif'] = $objectif;
        $data['variation_poid'] = $variationVoulu;
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
