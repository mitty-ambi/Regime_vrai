<?php
namespace App\Controllers;

use App\Models\Activites;
use App\Models\Regime;
use App\Models\regimeModel;



class ActiviteController extends BaseController
{
    protected $activiteModel;
    protected $regimeModel;

    public function __construct()
    {
        $this->activiteModel = new Activites();
        $this->regimeModel = new Regime();
    }

    public function go_to_activite()
    {
        $data['liste_activite'] = $this->activiteModel->findAll();
        $data['liste_regime'] = $this->regimeModel->findAll();
        return view('/activites/CrudActivites', $data);
    }

    public function insert()
    {
        $this->activiteModel->insert([
            'nom' => $this->request->getPost("nom"),
            'calories_brulees' => $this->request->getPost("calories_brulees")
        ]);
        session()->setFlashdata('success', 'Activité ajoutée avec succès');
        return redirect()->to('/Activites/add');
    }

    public function update($id)
    {
        $data['activite'] = $this->activiteModel->find($id);
        return view('/activites/EditActivite', $data);
    }

    public function edit($id)
    {
        $this->activiteModel->update($id, [
            'nom' => $this->request->getPost("nom"),
            'calories_brulees' => $this->request->getPost("calories_brulees")
        ]);
        session()->setFlashdata('success', 'Activité modifiée avec succès');
        return redirect()->to('/Activites/add');
    }

    public function supprimer($id)
    {
        $this->activiteModel->delete($id);
        session()->setFlashdata('success', 'Activité supprimée avec succès');
        return redirect()->to('/Activites/add');
    }
    public function associer()
    {
        $id_regime = $this->request->getPost('id_regime');
        $id_activite = $this->request->getPost('id_activite');

        $result = $this->activiteModel->associerRegime($id_regime, $id_activite);

        if ($result) {
            session()->setFlashdata('success', 'Activité associée au régime');
        } else {
            session()->setFlashdata('error', 'Déjà associé');
        }

        return redirect()->to('/Activites/go_to_activite');
    }
}