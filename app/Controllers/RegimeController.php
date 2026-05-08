<?php
namespace App\Controllers;
error_reporting(E_ALL);
ini_set('display_errors', 1);


use App\Controllers\BaseController;
use App\Models\Regime;
use App\Models\Objectif;


class RegimeController extends BaseController
{
    protected $regimeModel;
    protected $objectifModel;

    public function __construct()
    {
        $this->regimeModel = new Regime();
        $this->objectifModel = new Objectif();
    }
    public function go_to_regime()
    {
        $data['liste_regime'] = $this->regimeModel->findAll();
        $data['liste_objectif'] = $this->objectifModel->findAll();
        return view('CrudRegime', $data);
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
}