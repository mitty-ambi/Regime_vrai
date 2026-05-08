<?php

namespace App\Controllers;

use App\Models\Code;
use App\Models\TransactionCode;
use App\Models\UtilisateurModel;

class CodeController extends BaseController
{
    protected $codeModel;
    protected $transactionModel;
    protected $utilisateurModel;

    public function __construct()
    {
        $this->codeModel = new Code();
        $this->transactionModel = new TransactionCode();
        $this->utilisateurModel = new UtilisateurModel();
    }

    // BACK OFFICE - Liste et CRUD des codes
    public function listeCodes()
    {
        if (!session()->has('utilisateur') || !$this->isAdmin()) {
            return redirect()->to('/auth/login')->with('error', 'Accès refusé');
        }

        $data['codes'] = $this->codeModel->findAll();
        return view('codes/ListeCodes', $data);
    }

    public function ajouterCode()
    {
        if (!session()->has('utilisateur') || !$this->isAdmin()) {
            return redirect()->to('/auth/login')->with('error', 'Accès refusé');
        }

        return view('codes/AjouterCode');
    }

    public function insererCode()
    {
        $code = $this->request->getPost('code');
        $montant = $this->request->getPost('montant');

        // Vérifier que le code n'existe pas
        $codeExistant = $this->codeModel->getCodeByCode($code);
        if ($codeExistant) {
            return redirect()->back()->with('error', 'Ce code existe déjà');
        }

        $this->codeModel->insert([
            'code' => strtoupper($code),
            'montant' => $montant,
            'est_utilise' => false
        ]);

        session()->setFlashdata('success', 'Code ajouté avec succès');
        return redirect()->to('/codes/liste');
    }

    public function modifierCode($id)
    {
        if (!session()->has('utilisateur') || !$this->isAdmin()) {
            return redirect()->to('/auth/login')->with('error', 'Accès refusé');
        }

        $data['code'] = $this->codeModel->find($id);
        return view('codes/ModifierCode', $data);
    }

    public function updateCode($id)
    {
        $montant = $this->request->getPost('montant');

        $this->codeModel->update($id, [
            'montant' => $montant
        ]);

        session()->setFlashdata('success', 'Code modifié avec succès');
        return redirect()->to('/codes/liste');
    }

    public function supprimerCode($id)
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/auth/login')->with('error', 'Accès refusé');
        }

        $this->codeModel->delete($id);
        session()->setFlashdata('success', 'Code supprimé avec succès');
        return redirect()->to('/codes/liste');
    }

    public function ajouterCredit()
    {
        return view('codes/AjouterCredit');
    }

    public function validerCode()
    {
        // Vérifier que c'est un POST
        if (!$this->request->is('post')) {
            return redirect()->to('/codes/ajouter-credit')->with('error', 'Accès invalide');
        }

        // Si pas connecté, rediriger vers login
        if (!session()->has('utilisateur')) {
            return redirect()->to('/auth/login')->with('error', 'Veuillez vous connecter pour utiliser un code');
        }

        try {
            $codeStr = strtoupper($this->request->getPost('code'));
            $utilisateur = session()->get('utilisateur');

            // Chercher le code
            $code = $this->codeModel->getCodeByCode($codeStr);

            if (!$code) {
                return redirect()->back()->with('error', '❌ Code invalide');
            }

            if ($code['est_utilise']) {
                return redirect()->back()->with('error', '🔒 Ce code a déjà été utilisé');
            }

            // Ajouter le crédit
            $nouveauSolde = $utilisateur['solde'] + $code['montant'];
            $this->utilisateurModel->update($utilisateur['id'], [
                'solde' => $nouveauSolde
            ]);

            // Enregistrer la transaction
            $this->transactionModel->insert([
                'utilisateur_id' => $utilisateur['id'],
                'code_id' => $code['id'],
                'montant_credite' => $code['montant']
            ]);

            // Marquer le code comme utilisé
            $this->codeModel->update($code['id'], ['est_utilise' => true]);

            // Mettre à jour la session
            $utilisateur['solde'] = $nouveauSolde;
            session()->set('utilisateur', $utilisateur);

            session()->setFlashdata('success', '✅ Crédit ajouté avec succès! +' . $code['montant'] . '€');
            return redirect()->to('/dashboard');
        } catch (\Exception $e) {
            log_message('error', 'Erreur lors de la validation du code: ' . $e->getMessage());
            log_message('error', $e->getFile() . ' line ' . $e->getLine());
            return redirect()->back()->with('error', '❌ Erreur: ' . $e->getMessage());
        }
    }

    private function isAdmin()
    {
        return session()->has('utilisateur'); // Pour l'instant, tout utilisateur connecté
    }
}
