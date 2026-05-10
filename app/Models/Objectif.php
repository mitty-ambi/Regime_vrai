<?php
namespace App\Models;
use CodeIgniter\Model;

class Objectif extends Model
{
    protected $table = "objectifs";
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom','code'];
    protected $useTimestamps = false;

    //recuperer l objectif de l utilisateur
    public function getObjectif($idUtilisateur) {
        
        return $this->select("objectifs.*")
                ->join("utilisateur_objectifs","objectifs.id = utilisateur_objectifs.objectif_id")
                ->where("utilisateur_objectifs.utilisateur_id",$idUtilisateur)
                ->first();
    }
}
?>